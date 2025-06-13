<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    /**
     * [DIPERBAIKI] Menampilkan halaman setting.
     * Tidak lagi menggunakan email statis, tapi mengambil admin yang sedang login.
     */
    public function index()
    {
        // Ambil ID admin yang sedang login
        $loggedInAdminId = Auth::guard('admin')->id();

        // Ambil data admin yang sedang login
        $mainAdmin = Admin::find($loggedInAdminId);

        // Ambil semua admin lain (kecuali yang sedang login)
        $otherAdmins = Admin::where('id_admin', '!=', $loggedInAdminId)->get();

        return view('admin.settings', compact('mainAdmin', 'otherAdmins'));
    }

    /**
     * [DIPERBAIKI] Mengupdate password admin yang sedang login.
     */
    public function updateMainAdminPassword(Request $request, $id)
    {
        // Pastikan admin yang mencoba mengubah password adalah admin yang sama dengan yang sedang login
        if (Auth::guard('admin')->id() != $id) {
            return response()->json(['success' => false, 'message' => 'Anda tidak diizinkan mengubah password admin ini.'], 403);
        }

        try {
            $request->validate([
                'password' => 'required|min:8|confirmed',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->errors()], 422);
        }

        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json(['success' => false, 'message' => 'Admin tidak ditemukan.'], 404);
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        return response()->json(['success' => true, 'message' => 'Password berhasil diubah.']);
    }

    /**
     * [DIPERBAIKI] Menghapus admin lain.
     * Logika pencegahan sudah benar, tidak perlu diubah, hanya memastikan tidak ada hardcode.
     */
    public function destroyAdmin($id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json(['success' => false, 'message' => 'Admin tidak ditemukan.'], 404);
        }

        // Pencegahan: Jangan biarkan admin menghapus dirinya sendiri
        if (Auth::guard('admin')->id() == $id) {
            return response()->json(['success' => false, 'message' => 'Anda tidak bisa menghapus akun Anda sendiri.'], 403);
        }

        $admin->delete();
        return response()->json(['success' => true, 'message' => 'Admin berhasil dihapus.']);
    }

    // Metode lain (store, update, edit) tetap sama seperti sebelumnya
    // karena sudah menggunakan parameter ID dan tidak bergantung pada email.
    
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return response()->json($admin->only(['id_admin', 'nama_admin', 'email', 'telp', 'jenis_kelamin', 'alamat']));
    }

    public function storeAdmin(Request $request)
    {
        try {
            $request->validate([
                'name'          => 'required|string|max:100',
                'email'         => 'required|email|unique:admin,email',
                'password'      => 'required|min:8',
                'telp'          => 'required|string|max:15',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'alamat'        => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->errors()], 422);
        }

        $admin = Admin::create([
            'nama_admin'    => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'telp'          => $request->telp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat'        => $request->alamat,
        ]);
        
        return response()->json(['success' => true, 'message' => 'Admin baru berhasil ditambahkan.', 'admin' => $admin]);
    }

    public function updateAdmin(Request $request, $id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json(['success' => false, 'message' => 'Admin tidak ditemukan.'], 404);
        }

        try {
            $request->validate([
                'name'          => 'required|string|max:100',
                'email'         => 'required|email|unique:admin,email,' . $id . ',id_admin',
                'password'      => 'nullable|min:8',
                'telp'          => 'required|string|max:15',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'alamat'        => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'message' => $e->errors()], 422);
        }

        $admin->nama_admin = $request->name;
        $admin->email = $request->email;
        $admin->telp = $request->telp;
        $admin->jenis_kelamin = $request->jenis_kelamin;
        $admin->alamat = $request->alamat;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }
        $admin->save();
        
        return response()->json(['success' => true, 'message' => 'Admin berhasil diperbarui.', 'admin' => $admin]);
    }
}