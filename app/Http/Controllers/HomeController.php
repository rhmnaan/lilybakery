<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil produk rekomendasi beserta rata-rata ratingnya
        $recommendedProducts = Produk::withAvg('ulasan', 'rating') // Menghitung rata-rata dari relasi ulasan
                                     ->where('status', 1)
                                     ->inRandomOrder()
                                     ->limit(4)
                                     ->get();

        return view('index', ['recommendedProducts' => $recommendedProducts]);
    }
}