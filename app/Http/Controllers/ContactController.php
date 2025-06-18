<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // Untuk mengirim email
use App\Mail\ContactFormMail;     // Import Mailable yang akan kita buat
use Illuminate\Database\QueryException; // Untuk penanganan error database (jika nanti ada)

class ContactController extends Controller
{
    /**
     * Menangani pengiriman formulir kontak.
     */
    public function submit(Request $request)
    {
        try {
            // 1. Validasi Data
            $validatedData = $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'nomor_telepon' => 'required|string|max:20', // Mengubah ke required
                'email' => 'required|email|max:255',
                'pesan' => 'required|string|min:10|max:1000', // Menambahkan min/max panjang pesan
            ]);

            // 2. Kirim Email ke Admin
            // Ganti 'admin@lilybakery.id' dengan alamat email tujuan yang sebenarnya
            Mail::to('admin@lilybakery.id')
                ->send(new ContactFormMail($validatedData));

            // Jika berhasil, redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error validasi (ini akan otomatis di-redirect kembali dengan error)
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Tangani error umum lainnya (misal: masalah konfigurasi email, server email down)
            // Log error untuk debugging lebih lanjut
            \Log::error('Gagal mengirim email kontak: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal mengirim pesan. Silakan coba lagi nanti atau hubungi kami langsung. Pesan error: ' . $e->getMessage());
        }
    }
}