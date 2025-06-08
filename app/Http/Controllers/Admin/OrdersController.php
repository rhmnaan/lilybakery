<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = DB::table('orders')
            ->join('pelanggan', 'orders.id_pelanggan', '=', 'pelanggan.id_pelanggan')
            ->join('detail_order', 'orders.id_order', '=', 'detail_order.id_order')
            ->join('produk', 'detail_order.kode_produk', '=', 'produk.kode_produk')
            ->select(
                'orders.id_order',
                'pelanggan.nama_pelanggan',
                'produk.nama_produk',
                'detail_order.jumlah',
                'orders.total_harga',
                'orders.status',
                'orders.tanggal_order'
            )
            //->whereDate('orders.tanggal_order', now()->toDateString())
            ->get();
        
        $produk = DB::table('produk')->get();
        $pelanggans = DB::table('pelanggan')->get();

        return view('admin.orders', compact('orders', 'produk', 'pelanggans'));
    }
}