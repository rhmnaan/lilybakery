<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Promo;
use Carbon\Carbon;


class ProdukController extends Controller
{
    protected $imagePath = 'images/products/';

    public function index(Request $request)
    {
        // $produk = Produk::whereDoesntHave('promo')->get(); // hanya produk yang belum punya promo
        
        $query = Produk::with(['kategori', 'promo',]); // eager load relasi promo

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
        $kategoriList = Kategori::orderBy('nama_kategori')->get();

        $activeFilters = [
            'status' => $filterStatus,
            'kategori' => $filterKategori ?: 'semua',
            'promotion' => $filterPromotion
        ];

        $imagePath = $this->imagePath;
        $produkTanpaPromo = Produk::whereNotIn('kode_produk', Promo::pluck('kode_produk'))->get();


        return view('admin.admin-product', compact(
            'produks',
            'kategoris',
            'activeFilters',
            'imagePath',
            'filterPromotion',
            'produkTanpaPromo',
            'kategoriList' // ⬅️ ini untuk filter kategori
        ));


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
            'status' => 'required|boolean',
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
        // Cek apakah produk terkait dengan order yang ada
        if ($produk->detailOrder()->exists()) {
            return redirect()->route('admin.product')->with('error', 'Produk tidak bisa dihapus karena sudah pernah dibeli.');
        }

        // Hapus file gambar jika ada
        if ($produk->gambar && File::exists(public_path($this->imagePath . $produk->gambar))) {
            File::delete(public_path($this->imagePath . $produk->gambar));
        }

        $produk->delete();
        return redirect()->route('admin.product')->with('success', 'Produk berhasil dihapus!');
    }

    public function tambahPromo()
    {
        $produks = Produk::whereDoesntHave('promo')->get(); // hanya produk tanpa promo
        return view('admin.promosi.create', compact('produks'));
    }



    public function editPromoByKode($kode_produk)
    {
        $produk = Produk::where('kode_produk', $kode_produk)->with('promo')->first();

        if (!$produk || !$produk->promo) {
            return response()->json([
                'message' => 'Promosi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'promo' => [
                'diskon_persen' => $produk->promo->diskon_persen,
                'deskripsi_promo' => $produk->promo->deskripsi_promo,
                'tanggal_mulai' => $produk->promo->tanggal_mulai,
                'tanggal_berakhir' => $produk->promo->tanggal_berakhir,
            ]
        ]);
    }


    public function updatePromo(Request $request, $kode_produk)
    {
        $request->validate([
            'diskon_persen' => 'required|numeric|min:1|max:100',
            'deskripsi_promo' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // Cari berdasarkan kode_produk (bukan produk_id)
        $promo = Promo::where('kode_produk', $kode_produk)->first();

        if (!$promo) {
            return response()->json(['error' => 'Promosi tidak ditemukan'], 404);
        }

        $promo->update([
            'diskon_persen' => $request->diskon_persen,
            'deskripsi_promo' => $request->deskripsi_promo,
            'tanggal_mulai' => \Carbon\Carbon::parse($request->tanggal_mulai),
            'tanggal_berakhir' => \Carbon\Carbon::parse($request->tanggal_berakhir),
        ]);

        return response()->json(['message' => 'Promosi berhasil diperbarui!']);
    }



}
