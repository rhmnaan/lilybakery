<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StoreLocation;
use App\Models\Keranjang; // Tambahkan ini jika belum ada
use App\Models\Produk;    // INI YANG PALING PENTING UNTUK DIPASTIKAN ADA

class OrderController extends Controller
{
    /**
     * Menampilkan halaman info pengiriman.
     * Logika disesuaikan untuk menangani alur "Buy Now" dan "Keranjang".
     */ 
    public function orderInfo()
    {
        if (!Auth::guard('pelanggan')->check()) {
            return redirect()->route('pelanggan.login.form');
        }

        // Cek apakah ada proses "Buy Now" yang sedang aktif di session
        if (session()->has('buy_now_checkout')) {
            $checkoutItems = collect(session('buy_now_checkout'));
        } else {
            // Jika tidak, ambil data dari keranjang belanja
            $keranjangItems = Keranjang::where('id_pelanggan', Auth::guard('pelanggan')->id())->with('produk')->get();
            // Ubah struktur agar konsisten dengan alur "Buy Now"
            $checkoutItems = $keranjangItems->map(function ($item) {
                if (!$item->produk) return null; // Handle jika produk terhapus
                return [
                    'subtotal' => $item->produk->harga * $item->jumlah
                ];
            })->filter(); // Hapus item yang produknya null
        }

        if ($checkoutItems->isEmpty()) {
            return redirect()->route('home')->with('error', 'Tidak ada item untuk di-checkout.');
        }

        $pelanggan = Auth::guard('pelanggan')->user();
        $stores = StoreLocation::all();
        $subtotal = $checkoutItems->sum('subtotal');

        return view('order-info', compact('pelanggan', 'stores', 'subtotal'));
    }

    /**
     * [METHOD BARU] Menangani proses "Buy Now".
     */
    public function buyNow(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|exists:produk,kode_produk',
            'jumlah' => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->kode_produk);

        if ($produk->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi untuk jumlah yang diminta.');
        }

        $buyNowItem = [
            'kode_produk' => $produk->kode_produk,
            'nama_produk' => $produk->nama_produk,
            'harga' => $produk->harga,
            'gambar' => $produk->gambar,
            'jumlah' => (int)$request->jumlah,
            'subtotal' => $produk->harga * $request->jumlah,
        ];

        // Simpan item ini ke session dengan key khusus
        session(['buy_now_checkout' => [$buyNowItem]]);
        
        // Hapus session keranjang reguler jika ada, agar tidak tumpang tindih
        session()->forget('order_details'); 

        return redirect()->route('order.info');
    }

    /**
     * Menyimpan detail pengiriman ke session dan redirect ke halaman pembayaran.
     */
    public function saveOrderInfo(Request $request)
    {
        $request->validate([
            'nama_penerima' => 'required|string|max:100',
            'telp_penerima' => 'required|string|max:15',
            'alamat_pengiriman' => 'required|string',
            'ongkir' => 'required|numeric',
            'toko_asal' => 'required|string',
        ]);

        $details = $request->only(['nama_penerima', 'telp_penerima', 'alamat_pengiriman', 'ongkir', 'toko_asal']);
        
        // Simpan detail pengiriman ke session. Key 'order_details' akan digunakan oleh PembayaranController
        session(['order_details' => $details]);

        return redirect()->route('payment.show');
    }
}