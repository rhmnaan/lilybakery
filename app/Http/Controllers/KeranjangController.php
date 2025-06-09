<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Keranjang;

class KeranjangController extends Controller
{
    // ... (Metode index, tambahKeKeranjang, dan hapusDariKeranjang tetap sama) ...
    public function index()
    {
        $id_pelanggan = Auth::guard('pelanggan')->id();
        $cartItems = DB::table('keranjang')
            ->join('produk', 'keranjang.kode_produk', '=', 'produk.kode_produk')
            ->where('keranjang.id_pelanggan', $id_pelanggan)
            ->select(
                'keranjang.id_keranjang',
                'produk.nama_produk',
                'produk.harga',
                'produk.gambar',
                'keranjang.jumlah'
            )
            ->get();
        $total = 0;
        foreach ($cartItems as $item) {
            $item->subtotal = $item->harga * $item->jumlah;
            $total += $item->subtotal;
        }
        return view('cart', compact('cartItems', 'total'));
    }

    public function tambahKeKeranjang(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|exists:produk,kode_produk',
            'jumlah' => 'required|integer|min:1',
        ]);
        $pelangganId = Auth::guard('pelanggan')->id();
        $keranjangItem = Keranjang::where('id_pelanggan', $pelangganId)
                                  ->where('kode_produk', $request->kode_produk)
                                  ->first();
        if ($keranjangItem) {
            $keranjangItem->jumlah += $request->jumlah;
            $keranjangItem->save();
        } else {
            Keranjang::create([
                'id_pelanggan' => $pelangganId,
                'kode_produk' => $request->kode_produk,
                'jumlah' => $request->jumlah,
            ]);
        }
        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
    
    public function hapusDariKeranjang($id_keranjang)
    {
        $keranjangItem = Keranjang::find($id_keranjang);
        if (!$keranjangItem) {
            return back()->with('error', 'Item tidak ditemukan di keranjang.');
        }
        if ($keranjangItem->id_pelanggan != Auth::guard('pelanggan')->id()) {
            return back()->with('error', 'Aksi tidak diizinkan.');
        }
        $keranjangItem->delete();
        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }


    /**
     * [METODE BARU] Update kuantitas item di keranjang.
     */
    public function updateKuantitas(Request $request, $id_keranjang)
    {
        $request->validate(['jumlah' => 'required|integer|min:1']);

        $keranjangItem = Keranjang::find($id_keranjang);

        // Validasi kepemilikan
        if (!$keranjangItem || $keranjangItem->id_pelanggan != Auth::guard('pelanggan')->id()) {
            return response()->json(['success' => false, 'message' => 'Item tidak ditemukan.'], 404);
        }

        $keranjangItem->jumlah = $request->jumlah;
        $keranjangItem->save();

        // Hitung subtotal baru dan total keseluruhan untuk dikirim kembali ke frontend
        $subtotal = $keranjangItem->produk->harga * $keranjangItem->jumlah;
        
        $total = Keranjang::where('id_pelanggan', Auth::guard('pelanggan')->id())
            ->join('produk', 'keranjang.kode_produk', '=', 'produk.kode_produk')
            ->select(DB::raw('SUM(produk.harga * keranjang.jumlah) as total'))
            ->value('total');

        return response()->json([
            'success' => true,
            'subtotal' => 'Rp ' . number_format($subtotal, 0, ',', '.'),
            'total' => 'Rp ' . number_format($total, 0, ',', '.')
        ]);
    }
}