<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\HistoryOrder;

class OrdersController extends Controller
{
    /**
     * Menampilkan daftar pesanan dengan filter.
     */
    public function index(Request $request)
    {
        $statusFilter = $request->query('status', 'all');

        $query = Order::with(['pelanggan', 'detailOrder.produk'])
            ->orderBy('tanggal_order', 'desc');

        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        $orders = $query->get();

        $produk = Produk::where('status', true)->orderBy('nama_produk')->get();
        $pelanggans = Pelanggan::orderBy('nama_pelanggan')->get();

        return view('admin.orders', compact('orders', 'produk', 'pelanggans', 'statusFilter'));
    }

    /**
     * Menyimpan pesanan manual baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
            'produk' => 'required|array|min:1',
            'produk.*' => 'required|exists:produk,kode_produk',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
            'status' => 'required|string',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $totalHarga = 0;
                $details = [];

                foreach ($request->produk as $index => $kode_produk) {
                    $product = Produk::find($kode_produk);
                    $jumlah = $request->jumlah[$index];
                    $subtotal = $product->harga * $jumlah;
                    $totalHarga += $subtotal;
                    $details[] = [
                        'kode_produk' => $kode_produk,
                        'jumlah' => $jumlah,
                        'subtotal' => $subtotal,
                    ];
                }

                $order = Order::create([
                    'id_pelanggan' => $request->id_pelanggan,
                    'total_harga' => $totalHarga,
                    'tanggal_order' => now(),
                    'status' => $request->status,
                    'ongkir' => 0, // Anda bisa tambahkan field ini jika perlu
                ]);

                $order->detailOrder()->createMany($details);
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan pesanan: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('admin.orders')->with('success', 'Pesanan berhasil ditambahkan.');
    }

    public function edit(Order $order)
    {
        // Eager load relasi untuk dikirim sebagai JSON
        $order->load(['pelanggan', 'detailOrder.produk']);
        return response()->json($order);
    }

    /**
     * Memperbarui data pesanan.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'produk' => 'required|array|min:1',
            'produk.*' => 'required|exists:produk,kode_produk',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
            'status' => 'required|string',
        ]);

        try {
            DB::transaction(function () use ($request, $order) {
                // ... (Logika untuk update detail order tetap sama)
                $totalHarga = 0;
                $details = [];
                $order->detailOrder()->delete();
                foreach ($request->produk as $index => $kode_produk) {
                    $product = Produk::find($kode_produk);
                    $jumlah = $request->jumlah[$index];
                    $subtotal = $product->harga * $jumlah;
                    $totalHarga += $subtotal;
                    $details[] = [
                        'kode_produk' => $kode_produk,
                        'jumlah' => $jumlah,
                        'subtotal' => $subtotal,
                    ];
                }
                $order->detailOrder()->createMany($details);

                // Update order utama
                $order->update([
                    'total_harga' => $totalHarga,
                    'status' => $request->status,
                ]);

                // --- AWAL LOGIKA BARU UNTUK HISTORY ORDER ---
                // Cek jika status baru adalah 'Selesai'
                if ($request->status === 'Selesai') {
                    // Gunakan updateOrCreate untuk membuat entri baru atau memperbarui yang sudah ada.
                    // Ini mencegah duplikasi jika admin menyimpan status 'Selesai' lebih dari sekali.
                    HistoryOrder::updateOrCreate(
                        ['id_order' => $order->id_order], // Kunci untuk mencari
                        ['tanggal_selesai' => now()]      // Data yang diisi atau diperbarui
                    );
                } else {
                    // Jika status diubah dari 'Selesai' ke status lain, hapus dari history.
                    $order->historyOrder()->delete();
                }
                // --- AKHIR LOGIKA BARU ---

            });
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui pesanan: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('admin.orders')->with('success', 'Pesanan berhasil diperbarui.');
    }

    /**
     * Menghapus pesanan.
     */
    public function destroy(Order $order)
    {
        try {
            DB::transaction(function () use ($order) {
                // Hapus semua relasi terlebih dahulu
                $order->detailOrder()->delete();
                // Hapus order utama
                $order->delete();
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus pesanan: ' . $e->getMessage());
        }

        return redirect()->route('admin.orders')->with('success', 'Pesanan berhasil dihapus.');
    }

    // ekport excel
    public function exportData(Request $request)
    {
        $request->validate([
            'tanggal-awal' => 'required|date',
            'tanggal-akhir' => 'required|date|after_or_equal:tanggal-awal',
        ]);

        $startDate = Carbon::parse($request->input('tanggal-awal'))->startOfDay();
        $endDate = Carbon::parse($request->input('tanggal-akhir'))->endOfDay();

        $fileName = 'Laporan-Penjualan-' . $startDate->format('d-m-Y') . '-sampai-' . $endDate->format('d-m-Y') . '.csv';

        $orders = Order::with(['pelanggan', 'detailOrder.produk'])
            ->whereBetween('tanggal_order', [$startDate, $endDate])
            ->where('status', '!=', 'Dibatalkan')
            ->get();

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = ['ID Pesanan', 'Tanggal', 'Nama Pelanggan', 'Produk', 'Jumlah', 'Subtotal', 'Status Pesanan'];

        $callback = function () use ($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($orders as $order) {
                foreach ($order->detailOrder as $detail) {
                    $row['ID Pesanan'] = $order->id_order;
                    $row['Tanggal'] = Carbon::parse($order->tanggal_order)->format('Y-m-d H:i:s');
                    $row['Nama Pelanggan'] = $order->pelanggan->nama_pelanggan;
                    $row['Produk'] = $detail->produk->nama_produk;
                    $row['Jumlah'] = $detail->jumlah;
                    $row['Subtotal'] = $detail->subtotal;
                    $row['Status Pesanan'] = $order->status;
                    fputcsv($file, array_values($row));
                }
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}