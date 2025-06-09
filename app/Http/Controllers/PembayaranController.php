<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Keranjang;
use App\Models\Produk; // <-- Tambahkan ini
use Midtrans\Config;
use Midtrans\CoreApi;

class PembayaranController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
    }

    /**
     * Menampilkan halaman pembayaran dengan ringkasan pesanan.
     */
    public function show()
    {
        $orderDetails = session('order_details');
        if (!$orderDetails) {
            return redirect()->route('order.info')->with('error', 'Harap lengkapi info pengiriman terlebih dahulu.');
        }

        // --- AWAL LOGIKA BARU ---
        if (session()->has('buy_now_checkout')) {
            // Jika ini adalah alur "Buy Now", ambil data dari session
            $checkoutData = session('buy_now_checkout');
            $cartItems = collect($checkoutData)->map(function ($item) {
                // Ubah array menjadi object yang mirip dengan eloquent agar view tidak perlu diubah
                return (object) [
                    'produk' => (object) $item,
                    'jumlah' => $item['jumlah'],
                ];
            });
            $subtotal = collect($checkoutData)->sum('subtotal');
        } else {
            // Jika ini adalah alur keranjang biasa, ambil data dari database
            $cartItems = Keranjang::with('produk')->where('id_pelanggan', Auth::guard('pelanggan')->id())->get();
            $subtotal = $cartItems->sum(function($item) {
                return $item->produk->harga * $item->jumlah;
            });
        }
        // --- AKHIR LOGIKA BARU ---

        if ($cartItems->isEmpty()) {
            return redirect()->route('home')->with('error', 'Tidak ada item untuk di-checkout.');
        }
        
        $total = $subtotal + $orderDetails['ongkir'];
        
        return view('payment', compact('orderDetails', 'cartItems', 'subtotal', 'total'));
    }
    
    /**
     * Memproses permintaan pembayaran dari pelanggan.
     */
    public function process(Request $request)
    {
        $request->validate(['payment_method' => 'required|string']);

        $pelanggan = Auth::guard('pelanggan')->user();
        $orderDetails = session('order_details');
            
        // --- AWAL LOGIKA BARU ---
        if (session()->has('buy_now_checkout')) {
            // Ambil item dari session "Buy Now"
            $checkoutData = session('buy_now_checkout');
            $itemsToProcess = collect($checkoutData)->map(function ($item) {
                // Ubah menjadi object agar strukturnya sama
                return (object) [
                    'kode_produk' => $item['kode_produk'],
                    'jumlah' => $item['jumlah'],
                    'produk' => (object) ['harga' => $item['harga'], 'nama_produk' => $item['nama_produk']]
                ];
            });
            $clearAction = fn() => session()->forget('buy_now_checkout');
        } else {
            // Ambil item dari keranjang
            $itemsToProcess = Keranjang::with('produk')->where('id_pelanggan', $pelanggan->id_pelanggan)->get();
            $clearAction = fn() => Keranjang::where('id_pelanggan', $pelanggan->id_pelanggan)->delete();
        }
        // --- AKHIR LOGIKA BARU ---

        if ($itemsToProcess->isEmpty() || !$orderDetails) {
            return response()->json(['error' => 'Data pesanan tidak valid.'], 400);
        }

        DB::beginTransaction();
        try {
            $subtotal = $itemsToProcess->sum(fn($i) => $i->produk->harga * $i->jumlah);
            $totalHarga = $subtotal + $orderDetails['ongkir'];

            $order = Order::create([
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'total_harga' => $totalHarga,
                'status' => 'Belum Dibayar',
                'ongkir' => $orderDetails['ongkir'],
                'tanggal_order' => now(),
            ]);

            $item_details_midtrans = [];
            foreach ($itemsToProcess as $item) {
                $order->detailOrder()->create([
                    'kode_produk' => $item->kode_produk, 
                    'jumlah' => $item->jumlah, 
                    'subtotal' => $item->produk->harga * $item->jumlah
                ]);
                
                $item_details_midtrans[] = [
                    'id' => $item->kode_produk, 
                    'price' => $item->produk->harga, 
                    'quantity' => $item->jumlah, 
                    'name' => $item->produk->nama_produk
                ];
            }
            $item_details_midtrans[] = ['id' => 'ONGKIR', 'price' => $orderDetails['ongkir'], 'quantity' => 1, 'name' => 'Biaya Pengiriman'];

            $params = [
                'transaction_details' => ['order_id' => 'LILY-' . $order->id_order . '-' . time(), 'gross_amount' => $order->total_harga],
                'customer_details' => ['first_name' => $orderDetails['nama_penerima'], 'email' => $pelanggan->email, 'phone' => $orderDetails['telp_penerima']],
                'item_details' => $item_details_midtrans,
            ];

            // ... (sisa logika Midtrans tetap sama)
            
            $response = CoreApi::charge($params);
            
            DB::commit();
            
            // Hapus item dari keranjang atau session sesuai alurnya
            $clearAction();
            session()->forget('order_details');
            
            return response()->json($response);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}