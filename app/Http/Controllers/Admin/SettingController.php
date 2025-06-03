<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin; // Gunakan model Admin yang mengacu ke tabel 'admins'
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth; // Tambahkan ini untuk Auth::guard('admin')

class SettingController extends Controller
{
    // Method untuk menampilkan halaman setting
    public function index()
    {
        // Ambil data admin utama berdasarkan email
        // Asumsi 'admin@lilybakery.com' adalah email admin utama Anda
        $mainAdmin = Admin::where('email', 'admin@lilybakery.com')->first();

        // Ambil admin lain (selain admin utama) dari tabel 'admins'
        // Karena semua di tabel 'admins' adalah admin, kita tidak perlu kolom 'role' lagi di sini.
        $otherAdmins = Admin::where('email', '!=', 'admin@lilybakery.com')->get();

        return view('admin.settings', compact('mainAdmin', 'otherAdmins'));
    }

    // Method untuk mengupdate password admin utama
    public function updateMainAdminPassword(Request $request, $id)
    {
        // Validasi input
        try {
            $request->validate([
                'password' => 'required|min:8|confirmed', // 'confirmed' akan mencari password_confirmation
            ]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }

        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json(['success' => false, 'message' => 'Admin tidak ditemukan.'], 404);
        }

        // Pastikan admin yang diupdate adalah admin utama yang dimaksud
        if ($admin->email !== 'admin@lilybakery.com') {
            return response()->json(['success' => false, 'message' => 'Anda tidak diizinkan mengubah password admin ini.'], 403);
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        return response()->json(['success' => true, 'message' => 'Password berhasil diubah.']);
    }

    // Method untuk mendapatkan daftar admin lain (opsional, jika Anda ingin mengambilnya via API)
    public function getOtherAdmins()
    {
        // Ambil semua admin kecuali admin utama
        $otherAdmins = Admin::where('email', '!=', 'admin@lilybakery.com')->get(['id', 'name', 'email']);
        return response()->json($otherAdmins);
    }

    // Method untuk menambah admin baru
    public function storeAdmin(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:admins,email', // Unik di tabel 'admins'
                'password' => 'required|min:8',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // Tidak perlu kolom 'role' karena semua di tabel 'admins' sudah dianggap admin
        ]);

        return response()->json(['success' => true, 'message' => 'Admin baru berhasil ditambahkan.', 'admin' => $admin]);
    }

    // Method untuk mengupdate data admin lain
    public function updateAdmin(Request $request, $id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json(['success' => false, 'message' => 'Admin tidak ditemukan.'], 404);
        }

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:admins,email,' . $id, // Email harus unik kecuali untuk ID yang sedang diedit
                'password' => 'nullable|min:8', // Password opsional saat update
            ]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }

        // Pencegahan: Jangan biarkan admin utama diedit via fungsi ini (kecuali password)
        if ($admin->email === 'admin@lilybakery.com') {
            return response()->json(['success' => false, 'message' => 'Anda tidak bisa mengedit detail admin utama melalui metode ini.'], 403);
        }

        $admin->name = $request->name;
        $admin->email = $request->email;
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }
        $admin->save();

        return response()->json(['success' => true, 'message' => 'Admin berhasil diperbarui.']);
    }

    // Method untuk menghapus admin
    public function destroyAdmin($id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json(['success' => false, 'message' => 'Admin tidak ditemukan.'], 404);
        }

        // Pencegahan: Jangan biarkan admin menghapus dirinya sendiri
        // Asumsi guard untuk admin adalah 'admin', jika Anda pakai 'web' ganti menjadi Auth::id()
        if (Auth::guard('admin')->check() && Auth::guard('admin')->id() == $id) {
            return response()->json(['success' => false, 'message' => 'Anda tidak bisa menghapus akun Anda sendiri.'], 403);
        }

        // Pencegahan: Jangan biarkan admin menghapus admin utama
        if ($admin->email === 'admin@lilybakery.com') {
            return response()->json(['success' => false, 'message' => 'Admin utama tidak bisa dihapus.'], 403);
        }

        $admin->delete();
        return response()->json(['success' => true, 'message' => 'Admin berhasil dihapus.']);
    }
}