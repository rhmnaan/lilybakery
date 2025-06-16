<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Ulasan;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    public function show(Produk $produk)
    {
        // Memuat relasi kategori untuk produk yang sedang ditampilkan
        $produk->load('kategori');

        // [TAMBAHAN] Buat penanda untuk memeriksa apakah ini produk custom cake
        $is_custom_cake = ($produk->kategori && $produk->kategori->nama_kategori === 'Custom Cake');

        // Logika untuk filter ulasan berdasarkan rating
        $ratingFilter = request()->query('rating');
        $ulasansQuery = $produk->ulasan()->with('pelanggan')->orderBy('tanggal', 'desc');
        if ($ratingFilter && in_array($ratingFilter, [1, 2, 3, 4, 5])) {
            $ulasansQuery->where('rating', $ratingFilter);
        }
        $ulasans = $ulasansQuery->paginate(5)->withQueryString();

        // Logika untuk statistik ulasan
        $ulasanStats = Ulasan::where('kode_produk', $produk->kode_produk)
            ->selectRaw('rating, count(*) as count')
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get()
            ->keyBy('rating');

        $totalUlasan = $ulasanStats->sum('count');
        $averageRating = $totalUlasan > 0
            ? $ulasanStats->sum(fn($stat) => $stat->rating * $stat->count) / $totalUlasan
            : 0;
        
        // Logika untuk memeriksa apakah pelanggan bisa memberikan ulasan
        $canReview = false;
        if (Auth::guard('pelanggan')->check()) {
            $pelanggan = Auth::guard('pelanggan')->user();
            
            $hasBought = Order::where('id_pelanggan', $pelanggan->id_pelanggan)
                ->whereHas('historyOrder')
                ->whereHas('detailOrder', fn($q) => $q->where('kode_produk', $produk->kode_produk))
                ->exists();

            $hasReviewed = Ulasan::where('id_pelanggan', $pelanggan->id_pelanggan)
                ->where('kode_produk', $produk->kode_produk)
                ->exists();

            $canReview = $hasBought && !$hasReviewed;
        }

        // Kirim semua data ke view, termasuk penanda $is_custom_cake
        return view('product-detail', compact(
            'produk',
            'ulasans',
            'averageRating',
            'totalUlasan',
            'ulasanStats',
            'ratingFilter',
            'canReview',
            'is_custom_cake' // <-- Penanda ditambahkan di sini
        ));
    }
}