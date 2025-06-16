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
        // Validasi input: login (bisa email / telp) dan password wajib diisi
        $request->validate([
            'login' => ['required'],
            'password' => ['required'],
        ]);

        // Deteksi apakah login input berupa email atau nomor telepon
        $loginType = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'telp';

        // Siapkan credentials sesuai loginType
        $credentials = [
            $loginType => $request->input('login'),
            'password' => $request->input('password'),
        ];

        // Coba login dengan guard pelanggan
        if (Auth::guard('pelanggan')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/'); // atau rute dashboard pelanggan kamu
        }

        // Jika gagal login
        return back()->withErrors([
            'login' => 'Email / No. Telepon atau password yang Anda masukkan salah.',
        ])->onlyInput('login');
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