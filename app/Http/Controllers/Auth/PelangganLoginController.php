<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse; // Untuk type hinting redirect

class PelangganLoginController extends Controller
{
    /**
     * Menampilkan form login pelanggan.
     */
    public function showLoginForm()
    {
        // Cek jika pelanggan sudah login, redirect ke halaman yang sesuai
        if (Auth::guard('pelanggan')->check()) {
            return redirect()->route('pelanggan.dashboard'); // Buat rute ini nanti
        }
        return view('auth.pelanggan_login'); // Kita akan buat view ini di Langkah 4
    }

    /**
     * Menangani permintaan login pelanggan.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba autentikasi menggunakan guard 'pelanggan'
        if (Auth::guard('pelanggan')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            // Redirect ke halaman setelah login berhasil (misalnya dashboard pelanggan)
            // Jika ada intended URL (halaman yang coba diakses sebelum login), redirect ke sana
            return redirect()->intended('/'); // Buat rute ini nanti
        }

        // Jika autentikasi gagal
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Menangani permintaan logout pelanggan.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('pelanggan')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Redirect ke halaman utama setelah logout
    }
}