<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = DB::table('produk')->count();

        $today = Carbon::today()->toDateString();

        $totalPesananHariIni = DB::table('orders')
            ->whereDate('tanggal_order', $today)
            ->count();

        $totalPendapatanHariIni = DB::table('orders')
            ->whereDate('tanggal_order', $today)
            ->sum('total_harga');

        $totalPelanggan = DB::table('pelanggan')->count();

        // Jika ingin kirim data ke grafik mingguan, bisa tambah juga di sini nanti

        return view('admin.admin-dashboard', compact(
            'totalProduk',
            'totalPesananHariIni',
            'totalPendapatanHariIni',
            'totalPelanggan'
        ));
    }
}
