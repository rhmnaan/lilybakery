<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promo;
use App\Models\Produk;
use Carbon\Carbon;

class AdminPromoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produk,kode_produk',
            'diskon_persen' => 'required|numeric|min:1|max:100',
            'deskripsi_promo' => 'nullable|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // Cegah double promosi
        if (Promo::where('kode_produk', $request->id_produk)->exists()) {
            return back()->with('error', 'Produk ini sudah memiliki promosi.');
        }

        Promo::create([
            'kode_produk' => $request->id_produk,
            'diskon_persen' => $request->diskon_persen,
            'deskripsi_promo' => $request->deskripsi_promo,
            'tanggal_mulai' => Carbon::parse($request->tanggal_mulai),
            'tanggal_berakhir' => Carbon::parse($request->tanggal_berakhir),
        ]);

        return redirect()->route('admin.product', ['filter_promotion' => 'true'])
                         ->with('success', 'Promosi berhasil ditambahkan!');
    }
}