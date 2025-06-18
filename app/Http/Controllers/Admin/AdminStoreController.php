<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException; // Tambahkan ini untuk penanganan error database

class AdminStoreController extends Controller
{
    /**
     * Menampilkan halaman utama manajemen toko dengan semua data.
     */
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
        try {
            $validated = $request->validate([
                'nama_toko' => 'required|string|max:255',
                'alamat' => 'required|string',
                'telp' => 'nullable|string|max:20',
                'link_location' => 'nullable|url',
                'latitude' => 'nullable|string|max:255',
                'longitude' => 'nullable|string|max:255',
                'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
            ]);

            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $filename = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('images/store');

                // Pastikan direktori ada sebelum memindahkan file
                if (!File::isDirectory($destinationPath)) {
                    File::makeDirectory($destinationPath, 0775, true, true);
                }

                $file->move($destinationPath, $filename);
                $validated['img'] = $filename;
            } else {
                // Jika tidak ada gambar diunggah, set null agar tidak ada masalah dengan validasi atau database
                $validated['img'] = null;
            }

            StoreLocation::create($validated);

            return redirect()->route('admin.store')->with('success', 'Toko baru berhasil ditambahkan.');
        } catch (QueryException $e) {
            // Tangkap error khusus database
            // Anda bisa log $e->getMessage() untuk debugging lebih lanjut
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan toko ke database: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Tangkap error umum lainnya (misal: validasi gagal, masalah izin file)
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Memperbarui data toko yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        try {
            $store = StoreLocation::findOrFail($id);

            $validated = $request->validate([
                'nama_toko' => 'required|string|max:255',
                'alamat' => 'required|string',
                'telp' => 'nullable|string|max:20',
                'link_location' => 'nullable|url',
                'latitude' => 'nullable|string|max:255',
                'longitude' => 'nullable|string|max:255',
                'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
            ]);

            if ($request->hasFile('img')) {
                // Hapus gambar lama jika ada
                if ($store->img && File::exists(public_path('images/store/' . $store->img))) {
                    File::delete(public_path('images/store/' . $store->img));
                }

                $file = $request->file('img');
                $filename = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('images/store');

                // Pastikan direktori ada sebelum memindahkan file
                if (!File::isDirectory($destinationPath)) {
                    File::makeDirectory($destinationPath, 0775, true, true);
                }

                $file->move($destinationPath, $filename);
                $validated['img'] = $filename;
            } else {
                // Jika tidak ada gambar baru diunggah, hapus 'img' dari $validated
                // agar tidak menimpa nilai yang sudah ada di database.
                // Penting jika kolom 'img' di database tidak nullable atau Anda ingin mempertahankan yang lama.
                unset($validated['img']);
            }

            $store->update($validated);

            return redirect()->route('admin.store')->with('success', 'Data toko berhasil diperbarui.');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data toko ke database: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui toko: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data toko dari database.
     */
    public function destroy($id)
    {
        try {
            $store = StoreLocation::findOrFail($id);

            // Hapus gambar dari storage
            if ($store->img && File::exists(public_path('images/store/' . $store->img))) {
                File::delete(public_path('images/store/' . $store->img));
            }

            $store->delete();

            return redirect()->route('admin.store')->with('success', 'Toko berhasil dihapus.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Gagal menghapus toko dari database: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus toko: ' . $e->getMessage());
        }
    }
}