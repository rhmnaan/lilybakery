<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Keranjang;
use Midtrans\Config;
use Midtrans\CoreApi; // Menggunakan CoreApi untuk backend-to-backend

class PembayaranController extends Controller
{
    /**
     * Constructor untuk setup kunci Midtrans.
     */
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
            // Jika detail pesanan tidak ada di session, kembalikan ke halaman info pesanan
            return redirect()->route('order.info')->with('error', 'Harap lengkapi info pengiriman terlebih dahulu.');
        }

        $cartItems = Keranjang::with('produk')->where('id_pelanggan', Auth::guard('pelanggan')->id())->get();
        if ($cartItems->isEmpty()) {
            // Jika keranjang kosong, kembalikan ke halaman utama
            return redirect()->route('home')->with('error', 'Keranjang Anda kosong.');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->produk->harga * $item->jumlah);
        $total = $subtotal + $orderDetails['ongkir'];
        
        // Kirim semua data yang diperlukan ke view 'payment'
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
        $cartItems = Keranjang::with('produk')->where('id_pelanggan', $pelanggan->id_pelanggan)->get();
            
        if ($cartItems->isEmpty() || !$orderDetails) {
            return response()->json(['error' => 'Data pesanan tidak valid.'], 400);
        }

        // Memulai transaksi database untuk memastikan integritas data
        DB::beginTransaction();
        try {
            $subtotal = $cartItems->sum(fn($i) => $i->produk->harga * $i->jumlah);
            $totalHarga = $subtotal + $orderDetails['ongkir'];

            // 1. Buat pesanan baru di tabel 'orders'
            $order = Order::create([
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'total_harga' => $totalHarga,
                'status' => 'Belum Dibayar', // Status awal
                'ongkir' => $orderDetails['ongkir'],
                'tanggal_order' => now(),
            ]);

            $item_details_midtrans = [];
            // 2. Pindahkan item dari keranjang ke 'detail_order' dan siapkan detail untuk Midtrans
            foreach ($cartItems as $item) {
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
            // Tambahkan ongkir sebagai item terpisah untuk Midtrans
            $item_details_midtrans[] = [
                'id' => 'ONGKIR', 
                'price' => $orderDetails['ongkir'], 
                'quantity' => 1, 
                'name' => 'Biaya Pengiriman'
            ];

            // 3. Siapkan parameter untuk Midtrans Core API
            $params = [
                'transaction_details' => [
                    'order_id' => 'LILY-' . $order->id_order . '-' . time(), // Order ID unik
                    'gross_amount' => $order->total_harga,
                ],
                'customer_details' => [
                    'first_name' => $orderDetails['nama_penerima'], 
                    'email' => $pelanggan->email, 
                    'phone' => $orderDetails['telp_penerima']
                ],
                'item_details' => $item_details_midtrans,
            ];

            // Sesuaikan parameter berdasarkan metode pembayaran
            $paymentMethod = $request->payment_method;
            if (in_array($paymentMethod, ['bca_va', 'bni_va', 'bri_va'])) {
                $params['payment_type'] = 'bank_transfer';
                $params['bank_transfer'] = ['bank' => str_replace('_va', '', $paymentMethod)];
            } else {
                $params['payment_type'] = $paymentMethod; // Untuk 'qris' atau 'gopay'
            }
            
            // 4. Panggil Midtrans Core API
            $response = CoreApi::charge($params);
            
            // 5. Jika berhasil, selesaikan transaksi database
            DB::commit();
            
            // Hapus item dari keranjang dan session
            Keranjang::where('id_pelanggan', $pelanggan->id_pelanggan)->delete();
            session()->forget('order_details');
            
            // 6. Kirim respons dari Midtrans ke frontend
            return response()->json($response);

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan transaksi jika terjadi error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}