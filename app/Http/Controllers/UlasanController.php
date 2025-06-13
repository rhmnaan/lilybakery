<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    /**
     * Menyimpan rating baru dari pelanggan.
     */
    public function store(Request $request)
    {
        // 1. Validasi input: hanya kode_produk dan rating
        $request->validate([
            // Memastikan kode_produk ada di tabel 'produk' pada kolom 'kode_produk'
            'kode_produk' => 'required|exists:produk,kode_produk', 
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $pelangganId = Auth::guard('pelanggan')->id();

        // 2. Cek apakah pelanggan sudah pernah memberikan rating untuk produk ini
        $existingUlasan = Ulasan::where('kode_produk', $request->kode_produk)
                                     ->where('id_pelanggan', $pelangganId)
                                     ->first();

        if ($existingUlasan) {
            return back()->with('error', 'Anda sudah memberikan rating untuk produk ini.');
        }

        // 3. Simpan data baru ke tabel ulasan (tanpa komentar)
        Ulasan::create([
            'kode_produk' => $request->kode_produk,
            'id_pelanggan' => $pelangganId,
            'rating' => $request->rating,
            'tanggal' => now(), // Set tanggal saat ini secara eksplisit
        ]);

        // 4. Berikan pesan sukses yang sesuai
        return back()->with('success', 'Rating Anda berhasil dikirim. Terima kasih!');
    }
}