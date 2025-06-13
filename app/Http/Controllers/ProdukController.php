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
        $produk->load('kategori');

        $ratingFilter = request()->query('rating');

        $ulasansQuery = $produk->ulasan()->with('pelanggan')
            ->orderBy('tanggal', 'desc');

        if ($ratingFilter && in_array($ratingFilter, [1, 2, 3, 4, 5])) {
            $ulasansQuery->where('rating', $ratingFilter);
        }

        $ulasans = $ulasansQuery->paginate(5)->withQueryString();

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

        return view('product-detail', compact(
            'produk',
            'ulasans',
            'averageRating',
            'totalUlasan',
            'ulasanStats',
            'ratingFilter',
            'canReview'
        ));
    }
}