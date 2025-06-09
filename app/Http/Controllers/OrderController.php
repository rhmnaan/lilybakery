<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StoreLocation;

class OrderController extends Controller
{
    // ... (metode orderInfo Anda) ...
    public function orderInfo()
    {
        if (!Auth::guard('pelanggan')->check()) {
            return redirect()->route('pelanggan.login.form');
        }
        $pelanggan = Auth::guard('pelanggan')->user();
        $stores = StoreLocation::all();
        if ($stores->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Lokasi toko tidak ditemukan.');
        }
        return view('order-info', ['pelanggan' => $pelanggan, 'stores' => $stores]);
    }


    /**
     * Menyimpan detail pengiriman ke session dan redirect ke halaman pembayaran.
     */
    public function saveOrderInfo(Request $request)
    {
        $request->validate([
            'nama_penerima' => 'required|string|max:100',
            'telp_penerima' => 'required|string|max:15',
            'alamat_pengiriman' => 'required|string',
            'ongkir' => 'required|numeric',
            'toko_asal' => 'required|string',
        ]);

        session([
            'order_details' => [
                'nama_penerima'     => $request->nama_penerima,
                'telp_penerima'     => $request->telp_penerima,
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'ongkir'            => (int) $request->ongkir,
                'toko_asal'         => $request->toko_asal,
            ]
        ]);

        return redirect()->route('payment.show');
    }
}