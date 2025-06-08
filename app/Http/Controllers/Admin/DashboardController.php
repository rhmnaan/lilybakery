<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Metrik yang sudah ada
        $totalProduk = DB::table('produk')->count();
        $today = Carbon::today()->toDateString();
        $totalPesananHariIni = DB::table('orders')
            ->whereDate('tanggal_order', $today)
            ->count();
        $totalPendapatanHariIni = DB::table('orders')
            ->whereDate('tanggal_order', $today)
            ->sum('total_harga');
        $totalPelanggan = DB::table('pelanggan')->count();

        // --- TAMBAHAN UNTUK GRAFIK PENJUALAN MINGGUAN ---
        $sevenDaysAgo = Carbon::today()->subDays(6)->toDateString();

        $salesData = DB::table('orders')
            ->select(
                DB::raw('DATE(tanggal_order) as tanggal'),
                DB::raw('SUM(total_harga) as total_harian')
            )
            ->where('status', '!=', 'Dibatalkan') // Hanya hitung pesanan yang tidak dibatalkan
            ->whereBetween('tanggal_order', [$sevenDaysAgo, Carbon::today()->endOfDay()])
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        // Siapkan data untuk Chart.js
        $labels = [];
        $data = [];
        // Buat rentang tanggal 7 hari terakhir
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('D, d M'); // Format: "Sun, 02 Jun"

            // Cari data penjualan untuk tanggal ini
            $dailySale = $salesData->firstWhere('tanggal', $date->toDateString());
            $data[] = $dailySale ? $dailySale->total_harian : 0;
        }

        $produkTerlaris = DB::table('detail_order')
            ->join('produk', 'detail_order.kode_produk', '=', 'produk.kode_produk')
            ->select(
                'produk.nama_produk',
                'produk.harga',
                DB::raw('SUM(detail_order.jumlah) as total_terjual')
            )
            ->groupBy('produk.kode_produk', 'produk.nama_produk', 'produk.harga')
            ->orderBy('total_terjual', 'desc')
            ->limit(5) // Ambil 5 produk teratas
            ->get();

        // --- AKHIR TAMBAHAN ---

        return view('admin.admin-dashboard', compact(
            'totalProduk',
            'totalPesananHariIni',
            'totalPendapatanHariIni',
            'totalPelanggan',
            'labels',
            'data',
            'produkTerlaris'
        ));
    }
}