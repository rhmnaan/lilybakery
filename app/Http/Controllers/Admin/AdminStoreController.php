<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreLocation;

class AdminStoreController extends Controller
{
    public function index()
    {
        $storeLocations = StoreLocation::all(); // Ambil semua data store
        return view('admin.admin-store', compact('storeLocations'));
    }

    public function search(Request $request)
    {
        $keyword = $request->search;

        $storeLocations = StoreLocation::where('nama_toko', 'like', '%' . $keyword . '%')->get();

        // Return partial view untuk AJAX
        return view('admin.partials.store-cards', compact('storeLocations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_toko'      => 'required|string|max:255',
            'alamat'         => 'required|string',
            'telp'           => 'nullable|string',
            'link_location'  => 'nullable|string',
            'latitude'       => 'nullable|string',
            'longitude'      => 'nullable|string',
            'img'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/store'), $filename);
            $validated['img'] = $filename;
        }

        StoreLocation::create($validated);

        return redirect()->route('admin.store')->with('success', 'Toko berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $store = StoreLocation::findOrFail($id);

        $validated = $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telp' => 'nullable|string',
            'link_location' => 'nullable|string',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/store'), $filename);
            $validated['img'] = $filename;
        }

        $store->update($validated);

        return redirect()->route('admin.store')->with('success', 'Data toko berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $store = StoreLocation::findOrFail($id);
        
        // Hapus gambar jika perlu
        if ($store->img && file_exists(public_path('images/store/' . $store->img))) {
            unlink(public_path('images/store/' . $store->img));
        }

        $store->delete();

        return redirect()->back()->with('success', 'Toko berhasil dihapus.');
    }


}
