<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo; // Import the Promo model
use Carbon\Carbon; // Import Carbon for date handling

class PromoController extends Controller
{
    /**
     * Display a listing of the active promotions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $today = Carbon::today();

        // Fetch active promotions with their related products
        // Ensure the product relationship in the Promo model is named 'produk'
        $activePromos = Promo::where('tanggal_mulai', '<=', $today)
                             ->where('tanggal_berakhir', '>=', $today)
                             ->with('produk.kategori') // Eager load product and its category
                             ->get();
        
        // You might want to filter out promos where the product itself is null,
        // though ideally, your database constraints should prevent orphaned promo records.
        $activePromos = $activePromos->filter(function ($promo) {
            return $promo->produk !== null;
        });

        return view('promotion', ['promos' => $activePromos]);
    }
}