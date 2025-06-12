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
use App\Models\DetailOrder;

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
            $subtotal = $cartItems->sum(function ($item) {
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
        // Kode yang ada di sini sudah menangani validasi,
        // pengambilan item dari keranjang atau session "Buy Now",
        // pembuatan Order di database, dan persiapan parameter untuk Midtrans.
        // Ini adalah implementasi yang solid.

        $request->validate(['payment_method' => 'required|string']);

        $pelanggan = Auth::guard('pelanggan')->user();
        $orderDetails = session('order_details');

        // Logika untuk memproses item dari session 'buy_now_checkout' atau 'Keranjang' sudah benar.
        if (session()->has('buy_now_checkout')) {
            $checkoutData = session('buy_now_checkout');
            $itemsToProcess = collect($checkoutData)->map(fn($item) => (object) ['kode_produk' => $item['kode_produk'], 'jumlah' => $item['jumlah'], 'produk' => (object) $item]);
            $clearAction = fn() => session()->forget('buy_now_checkout');
        } else {
            $itemsToProcess = Keranjang::with('produk')->where('id_pelanggan', $pelanggan->id_pelanggan)->get();
            $clearAction = fn() => Keranjang::where('id_pelanggan', $pelanggan->id_pelanggan)->delete();
        }

        if ($itemsToProcess->isEmpty() || !$orderDetails) {
            return response()->json(['error' => 'Data pesanan tidak valid.'], 400);
        }

        // app/Http/Controllers/PembayaranController.php -> method process()

        DB::beginTransaction();
        try {
            // Bagian kode untuk validasi, mengambil item, dan membuat order tetap sama
            // ... (kode Anda yang sudah ada untuk validasi, get item, create order)
            $request->validate(['payment_method' => 'required|string']);

            $pelanggan = Auth::guard('pelanggan')->user();
            $orderDetails = session('order_details');

            if (session()->has('buy_now_checkout')) {
                $checkoutData = session('buy_now_checkout');
                $itemsToProcess = collect($checkoutData)->map(fn($item) => (object) ['kode_produk' => $item['kode_produk'], 'jumlah' => $item['jumlah'], 'produk' => (object) $item]);
                $clearAction = fn() => session()->forget('buy_now_checkout');
            } else {
                $itemsToProcess = Keranjang::with('produk')->where('id_pelanggan', $pelanggan->id_pelanggan)->get();
                $clearAction = fn() => Keranjang::where('id_pelanggan', $pelanggan->id_pelanggan)->delete();
            }

            if ($itemsToProcess->isEmpty() || !$orderDetails) {
                return response()->json(['error' => 'Data pesanan tidak valid.'], 400);
            }

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
                DetailOrder::create(['id_order' => $order->id_order, 'kode_produk' => $item->kode_produk, 'jumlah' => $item->jumlah]);
                $item_details_midtrans[] = ['id' => $item->kode_produk, 'price' => $item->produk->harga, 'quantity' => $item->jumlah, 'name' => $item->produk->nama_produk];
            }
            $item_details_midtrans[] = ['id' => 'ONGKIR', 'price' => $orderDetails['ongkir'], 'quantity' => 1, 'name' => 'Biaya Pengiriman'];

            // --- PERUBAHAN DIMULAI DI SINI ---

            $midtrans_params = [
                'transaction_details' => [
                    'order_id' => 'LILY-' . $order->id_order . '-' . time(),
                    'gross_amount' => $order->total_harga,
                ],
                'customer_details' => [
                    'first_name' => $orderDetails['nama_penerima'],
                    'email' => $pelanggan->email,
                    'phone' => $orderDetails['telp_penerima'],
                ],
                'item_details' => $item_details_midtrans,
            ];

            $paymentMethod = $request->payment_method;

            // Menyesuaikan payload berdasarkan metode pembayaran dari frontend
            if (in_array($paymentMethod, ['bca_va', 'bni_va', 'bri_va'])) {
                // Jika metode adalah VA, set payment_type ke 'bank_transfer'
                $midtrans_params['payment_type'] = 'bank_transfer';
                // Dan tambahkan detail bank spesifiknya
                $midtrans_params['bank_transfer'] = [
                    'bank' => explode('_', $paymentMethod)[0] // Mengambil 'bca' dari 'bca_va'
                ];
            } else {
                // Untuk metode lain seperti 'qris', 'gopay', dll.
                $midtrans_params['payment_type'] = $paymentMethod;
            }

            // Mengirim request ke Midtrans dengan parameter yang sudah benar
            $response = \Midtrans\CoreApi::charge($midtrans_params);

            // --- AKHIR PERUBAHAN ---

            DB::commit();

            $clearAction(); // Membersihkan keranjang atau session
            session()->forget('order_details');

            return response()->json($response);

        } catch (\Exception $e) {
            DB::rollBack();
            // Mengembalikan pesan error yang lebih jelas ke frontend
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}