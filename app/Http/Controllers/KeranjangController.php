<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    public function index()
    {
        
        $id_pelanggan = 3; // Ganti sesuai auth()->user()->id_pelanggan jika pakai sistem login

        // Ambil data keranjang + data produk
        $cartItems = DB::table('keranjang')
            ->join('produk', 'keranjang.kode_produk', '=', 'produk.kode_produk')
            ->where('keranjang.id_pelanggan', $id_pelanggan)
            ->select(
                'keranjang.id_keranjang',
                'produk.nama_produk',
                'produk.harga',
                'keranjang.jumlah',
                DB::raw('(produk.harga * keranjang.jumlah) as subtotal')

            )
            ->get();

        $total = $cartItems->sum('subtotal');

        return view('cart', compact('cartItems', 'total'));
    }
}