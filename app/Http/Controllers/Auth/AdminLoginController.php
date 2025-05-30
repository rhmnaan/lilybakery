<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AdminLoginController extends Controller
{
    /**
     * Hanya izinkan tamu (yang belum login sebagai admin) untuk mengakses form login admin.
     * Jika sudah login sebagai admin, redirect ke dashboard admin.
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    /**
     * Menampilkan form login admin.
     * Menggunakan view yang sudah Anda definisikan di route.
     */
    public function showLoginForm()
    {
        return view('auth.admin-login'); // Sesuai dengan route Anda: resources/views/admin-login.blade.php
    }

    /**
     * Menangani permintaan login admin.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba autentikasi menggunakan guard 'admin'
        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            // Redirect ke halaman setelah login berhasil (misalnya dashboard admin)
            return redirect()->intended(route('admin.dashboard')); // Kita akan buat route bernama 'admin.dashboard'
        }

        // Jika autentikasi gagal
        return back()->withErrors([
            'email' => 'Email atau password admin yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Menangani permintaan logout admin.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login.form'); // Redirect ke form login admin setelah logout
    }
}