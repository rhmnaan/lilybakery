<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminStoreController extends Controller
{
    /**
     * Menampilkan halaman utama manajemen toko dengan semua data.
     */
    // Mengurutkan berdasarkan id_store secara descending, atau tanpa urutan
    public function index()
    {
        // Opsi A: Urutkan berdasarkan ID terbaru
        $storeLocations = StoreLocation::orderBy('id_store', 'desc')->get();
        return view('Admin.admin-store', compact('storeLocations'));
    }

    /**
     * Menangani pencarian AJAX dan mengembalikan partial view.
     */
    public function search(Request $request)
    {
        // [PERBAIKAN] Ganti 'q' atau nama lain menjadi 'search'
        // agar cocok dengan parameter yang dikirim dari fetch API.
        $query = $request->input('search');

        $storeLocations = StoreLocation::where('nama_toko', 'like', '%' . $query . '%')
            ->orWhere('alamat', 'like', '%' . $query . '%')
            ->get();

        return view('admin.partials.store-cards', compact('storeLocations'));
    }

    /**
     * Menyimpan data toko baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telp' => 'nullable|string|max:20',
            'link_location' => 'nullable|url',
            'latitude' => 'nullable|string|max:255',
            'longitude' => 'nullable|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/store'), $filename);
            $validated['img'] = $filename;
        }

        StoreLocation::create($validated);

        return redirect()->route('admin.store')->with('success', 'Toko baru berhasil ditambahkan.');
    }

    /**
     * Memperbarui data toko yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $store = StoreLocation::findOrFail($id);

        $validated = $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telp' => 'nullable|string|max:20',
            'link_location' => 'nullable|url',
            'latitude' => 'nullable|string|max:255',
            'longitude' => 'nullable|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('img')) {
            // Hapus gambar lama jika ada
            if ($store->img && File::exists(public_path('images/store/' . $store->img))) {
                File::delete(public_path('images/store/' . $store->img));
            }

            $file = $request->file('img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/store'), $filename);
            $validated['img'] = $filename;
        }

        $store->update($validated);

        return redirect()->route('admin.store')->with('success', 'Data toko berhasil diperbarui.');
    }

    /**
     * Menghapus data toko dari database.
     */
    public function destroy($id)
    {
        $store = StoreLocation::findOrFail($id);

        // Hapus gambar dari storage
        if ($store->img && File::exists(public_path('images/store/' . $store->img))) {
            File::delete(public_path('images/store/' . $store->img));
        }

        $store->delete();

        return redirect()->route('admin.store')->with('success', 'Toko berhasil dihapus.');
    }
}