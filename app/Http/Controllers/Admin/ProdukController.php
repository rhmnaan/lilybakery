<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    protected $imagePath = 'images/products/';

    public function index(Request $request)
    {
        $query = Produk::with('kategori');

        // ... (logika filter dan sort Anda yang sudah ada) ...
        $filterStatus = $request->input('filter_status');
        $filterKategori = $request->input('filter_kategori');
        $filterPromotion = $request->input('filter_promotion');

        if ($filterStatus === 'active') {
            $query->where('status', true);
        } elseif ($filterStatus === 'nonactive') {
            $query->where('status', false);
        }

        if ($filterKategori && $filterKategori !== 'semua') {
            $query->where('id_kategori', $filterKategori);
        }

        if ($filterPromotion === 'true') {
            $query->whereHas('promo');
        }

        if ($request->has('sort_by')) {
            $direction = $request->get('sort_dir', 'asc');
            $sortableColumns = ['nama_produk', 'harga', 'stok', 'kode_produk', 'status'];
            if (in_array($request->sort_by, $sortableColumns)) {
                $query->orderBy($request->sort_by, $direction);
            }
        } else {
            $query->orderBy('kode_produk', 'desc');
        }


        $produks = $query->paginate(10)->appends($request->except('page'));
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        $activeFilters = [
            'status' => $filterStatus,
            'kategori' => $filterKategori ?: 'semua',
            'promotion' => $filterPromotion
        ];

        // TAMBAHKAN BARIS INI:
        $imagePath = $this->imagePath;

        // KIRIMKAN $imagePath KE VIEW MELALUI COMPACT()
        return view('admin.admin-product', compact('produks', 'kategoris', 'activeFilters', 'imagePath'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'required|boolean', // status sekarang wajib dan boolean (0 atau 1)
        ]);

        $filename = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($this->imagePath), $filename);
        }

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'id_kategori' => $request->id_kategori,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'gambar' => $filename,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.product')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Produk $produk)
    {
        $produk->load('kategori');
        return response()->json($produk);
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        $data = $request->only(['nama_produk', 'id_kategori', 'harga', 'stok', 'deskripsi', 'status']);

        if ($request->hasFile('gambar')) {
            if ($produk->gambar && File::exists(public_path($this->imagePath . $produk->gambar))) {
                File::delete(public_path($this->imagePath . $produk->gambar));
            }
            $file = $request->file('gambar');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($this->imagePath), $filename);
            $data['gambar'] = $filename;
        }

        $produk->update($data);
        return redirect()->route('admin.product')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Produk $produk)
    {
        if ($produk->gambar && File::exists(public_path($this->imagePath . $produk->gambar))) {
            File::delete(public_path($this->imagePath . $produk->gambar));
        }
        $produk->delete();
        return redirect()->route('admin.product')->with('success', 'Produk berhasil dihapus!');
    }
}