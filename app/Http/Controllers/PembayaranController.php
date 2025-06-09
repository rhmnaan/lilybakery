<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Keranjang;
use Midtrans\Config;
use Midtrans\CoreApi; // Gunakan CoreApi, bukan Snap

class PembayaranController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
    }

    public function show()
    {
        $orderDetails = session('order_details');
        if (!$orderDetails) {
            return redirect()->route('order.info')->with('error', 'Harap lengkapi info pengiriman terlebih dahulu.');
        }

        $cartItems = Keranjang::with('produk')->where('id_pelanggan', Auth::guard('pelanggan')->id())->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('home')->with('error', 'Keranjang Anda kosong.');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->produk->harga * $item->jumlah);
        $total = $subtotal + $orderDetails['ongkir'];
        
        return view('payment', compact('orderDetails', 'cartItems', 'subtotal', 'total'));
    }
    
    public function process(Request $request)
    {
        $request->validate(['payment_method' => 'required|string']);

        $pelanggan = Auth::guard('pelanggan')->user();
        $orderDetails = session('order_details');
        $cartItems = Keranjang::with('produk')->where('id_pelanggan', $pelanggan->id_pelanggan)->get();
            
        if ($cartItems->isEmpty() || !$orderDetails) {
            return response()->json(['error' => 'Data pesanan tidak valid.'], 400);
        }

        DB::beginTransaction();
        try {
            $subtotal = $cartItems->sum(fn($i) => $i->produk->harga * $i->jumlah);
            $totalHarga = $subtotal + $orderDetails['ongkir'];

            $order = Order::create([
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'total_harga' => $totalHarga,
                'status' => 'Belum Dibayar',
                'ongkir' => $orderDetails['ongkir'],
                'tanggal_order' => now(),
            ]);

            $item_details_midtrans = [];
            foreach ($cartItems as $item) {
                $order->detailOrder()->create(['kode_produk' => $item->kode_produk, 'jumlah' => $item->jumlah, 'subtotal' => $item->produk->harga * $item->jumlah]);
                $item_details_midtrans[] = ['id' => $item->kode_produk, 'price' => $item->produk->harga, 'quantity' => $item->jumlah, 'name' => $item->produk->nama_produk];
            }
            $item_details_midtrans[] = ['id' => 'ONGKIR', 'price' => $orderDetails['ongkir'], 'quantity' => 1, 'name' => 'Biaya Pengiriman'];

            $params = [
                'transaction_details' => ['order_id' => 'LILY-' . $order->id_order . '-' . time(), 'gross_amount' => $order->total_harga],
                'customer_details' => ['first_name' => $orderDetails['nama_penerima'], 'email' => $pelanggan->email, 'phone' => $orderDetails['telp_penerima']],
                'item_details' => $item_details_midtrans,
            ];

            $paymentMethod = $request->payment_method;
            if (in_array($paymentMethod, ['bca_va', 'bni_va', 'bri_va'])) {
                $params['payment_type'] = 'bank_transfer';
                $params['bank_transfer'] = ['bank' => str_replace('_va', '', $paymentMethod)];
            } else {
                $params['payment_type'] = $paymentMethod; // Untuk 'qris' atau 'gopay'
            }
            
            $response = CoreApi::charge($params);
            
            DB::commit();
            Keranjang::where('id_pelanggan', $pelanggan->id_pelanggan)->delete();
            session()->forget('order_details');
            
            return response()->json($response);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}