<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order; // Import the Order model
use App\Models\HistoryOrder; // Import HistoryOrder model if needed for direct querying, though whereHas is usually sufficient

class PelangganOrderController extends Controller
{
    public function index(Request $request)
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        if (!$pelanggan) {
            // Should not happen if middleware is applied correctly, but as a safeguard
            return redirect()->route('pelanggan.login'); // Adjust to your login route
        }
        
        $statusFilter = $request->query('status');

        $query = Order::where('id_pelanggan', $pelanggan->id_pelanggan)
                      ->with(['detailOrder.produk']); // Eager load order details and their products

        // Define the mapping for status filters from 'orders' table
        $statusMap = [
            'belum_bayar' => 'Belum Dibayar',
            'diproses' => 'Diproses',
            'dikirim' => 'Dikirim',
            'dibatalkan' => 'Dibatalkan', // Added from your migration
        ];
        
        $currentStatusView = 'SEMUA'; // Default view status for heading

        if ($statusFilter === 'selesai') {
            // Orders are considered 'Selesai' if they exist in the history_order table
            $query->whereHas('historyOrder');
            $currentStatusView = 'SELESAI';
        } elseif ($statusFilter && isset($statusMap[$statusFilter])) {
            // Filter by status directly from the orders table
            $query->where('status', $statusMap[$statusFilter]);
            $currentStatusView = strtoupper(str_replace('_', ' ', $statusFilter));
        } elseif ($statusFilter === 'semua' || !$statusFilter) {
            // No specific status filter, show all
            $currentStatusView = 'SEMUA';
        } else {
            // If an invalid status is passed, default to all
            $currentStatusView = 'SEMUA';
        }

        // Always order by the original order date
        $orders = $query->orderBy('tanggal_order', 'desc')->paginate(10);

        // For orders explicitly filtered as 'Selesai', we'll mark their display status
        // For the "SEMUA" tab, the original status from the `orders` table will be shown.
        if ($statusFilter === 'selesai') {
            foreach ($orders as $order) {
                $order->display_status_override = 'Selesai';
            }
        }

        return view('pesanan', [
            'orders' => $orders,
            'currentStatusFilter' => $statusFilter ?: 'semua', // Pass current filter to view for active tab
            'currentStatusView' => $currentStatusView
        ]);
    }
}