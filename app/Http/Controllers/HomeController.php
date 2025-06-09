<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk; // Gunakan model Produk

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama dengan produk rekomendasi (acak).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // [LOGIKA BARU] Ambil 4 produk aktif secara acak sebagai rekomendasi
        $recommendedProducts = Produk::where('status', 1) // Hanya yang statusnya aktif
                                     ->inRandomOrder()       // Diambil secara acak
                                     ->limit(4)              // Batasi sebanyak 4 produk
                                     ->get();

        // Kirim data ke view dengan nama variabel yang baru
        return view('index', ['recommendedProducts' => $recommendedProducts]);
    }
}