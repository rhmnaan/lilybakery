<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request) {
        $query = Produk::query();
        if ($request->has('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }
        return response()->json($query->get());
    }

    public function store(Request $request) {
        $produk = Produk::create($request->all());
        return response()->json($produk, 201);
    }

    public function show($kode_produk) {
        return response()->json(Produk::findOrFail($kode_produk));
    }

    public function update(Request $request, $kode_produk) {
        $produk = Produk::findOrFail($kode_produk);
        $produk->update($request->all());
        return response()->json($produk);
    }

    public function destroy($kode_produk) {
        $produk = Produk::findOrFail($kode_produk);
        $produk->delete();
        return response()->json(null, 204);
    }

    public function recommended() {
        return response()->json(Produk::inRandomOrder()->limit(5)->get());
    }

    public function customCakes() {
        return response()->json(Produk::where('id_kategori', 999)->get()); // misalnya 999 itu kategori custom
    }
}
