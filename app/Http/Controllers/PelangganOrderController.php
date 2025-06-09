<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelangganOrderController extends Controller
{
    public function index(Request $request)
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        $statusFilter = $request->query('status', 'semua');

        $ordersQuery = Order::where('id_pelanggan', $pelanggan->id_pelanggan);

        $currentStatusView = 'Semua';
        if ($statusFilter && $statusFilter !== 'semua') {
            // --- UBAH STRING DI BAWAH INI MENJADI HURUF KAPITAL ---
            if ($statusFilter === 'belum_bayar') {
                $ordersQuery->where('status', 'BELUM DIBAYAR');
                $currentStatusView = 'Belum Bayar';
            } elseif ($statusFilter === 'diproses') {
                $ordersQuery->where('status', 'DIPROSES');
                $currentStatusView = 'Diproses';
            } elseif ($statusFilter === 'dikirim') {
                $ordersQuery->where('status', 'DIKIRIM');
                $currentStatusView = 'Dikirim';
            } elseif ($statusFilter === 'dibatalkan') {
                $ordersQuery->where('status', 'DIBATALKAN');
                $currentStatusView = 'Dibatalkan';
            } elseif ($statusFilter === 'selesai') {
                // Untuk status 'selesai', kita tetap menggunakan pengecekan ke tabel history
                $ordersQuery->whereHas('historyOrder'); 
                $currentStatusView = 'Selesai';
            }
        }
        
        // ... (Sisa kode controller tetap sama)
        $orders = $ordersQuery->with([
            'detailOrder.produk' => function ($query) {
                $query->select('kode_produk', 'nama_produk', 'harga', 'gambar');
            },
            'detailOrder.produk.ulasan' => function ($query) use ($pelanggan) {
                $query->where('id_pelanggan', $pelanggan->id_pelanggan);
            }, 
            'historyOrder'
        ])
        ->orderBy('tanggal_order', 'desc')
        ->paginate(10)
        ->withQueryString();

        foreach ($orders as $order) {
            if ($order->historyOrder) {
                $order->display_status_override = 'Selesai';
            }
        }

        return view('pesanan', [
            'orders' => $orders,
            'currentStatusFilter' => $statusFilter,
            'currentStatusView' => $currentStatusView
        ]);
    }
}