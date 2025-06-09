<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Produk;

class MenuController extends Controller
{
    /**
     * Menampilkan produk berdasarkan kategori yang dipilih di URL.
     *
     * @param string $categoryName
     * @return \Illuminate\View\View
     */
    public function showCategory($categoryName)
    {
        // Cari kategori di database berdasarkan nama (slug)
        $kategori = Kategori::where('nama_kategori', 'like', str_replace('-', ' ', $categoryName))->firstOrFail();

        // Ambil semua produk yang aktif dari kategori tersebut
        $products = Produk::where('id_kategori', $kategori->id_kategori)
            ->where('status', 1) // Hanya tampilkan produk yang aktif
            ->withAvg('ulasan', 'rating') // Ambil rata-rata rating
            ->paginate(12); // Tampilkan 12 produk per halaman

        // Siapkan data header untuk view
        $header = [
            'title' => 'Koleksi ' . $kategori->nama_kategori,
            'subtitle' => 'Temukan ' . strtolower($kategori->nama_kategori) . ' favorit Anda di sini.'
        ];

        // Kirim data ke view
        return view('category-menu', [
            'category' => $kategori->nama_kategori,
            'products' => $products,
            'header' => $header,
        ]);
    }

    /**
     * Metode ini tidak lagi diperlukan karena sudah ditangani oleh ProdukController,
     * namun bisa dibiarkan kosong atau dihapus.
     */
    public function showProductDetail($category, $productName)
    {
        // Logika ini sekarang ditangani oleh ProdukController@show
        // Redirect atau abort
        return redirect()->route('home');
    }
}