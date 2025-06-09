<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- TAMBAHKAN INI

class OrderController extends Controller
{
    /**
     * [MODIFIKASI] Menampilkan halaman order-info dengan data pelanggan.
     */
    public function orderInfo()
    {
        // Pastikan pelanggan sudah login
        if (!Auth::guard('pelanggan')->check()) {
            // Jika belum, arahkan ke halaman login
            return redirect()->route('pelanggan.login.form');
        }

        // Ambil data pelanggan yang sedang login
        $pelanggan = Auth::guard('pelanggan')->user();

        // Kirim data pelanggan ke view
        return view('order-info', ['pelanggan' => $pelanggan]);
    }
}