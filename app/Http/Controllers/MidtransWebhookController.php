<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Set konfigurasi Midtrans
        Config::$isProduction = config('midtrans.is_production');
        Config::$serverKey = config('midtrans.server_key');

        try {
            // Buat instance dari Midtrans Notification
            $notification = new Notification();

            $orderIdParts = explode('-', $notification->order_id);
            $order = Order::find($orderIdParts[1]); // Ekstrak ID order dari 'LILY-ID-TIMESTAMP'

            if (!$order) {
                return response()->json(['message' => 'Order not found.'], 404);
            }

            // Lakukan validasi signature key (hash)
            $signatureKey = hash('sha512', $notification->order_id . $notification->status_code . $notification->gross_amount . config('midtrans.server_key'));
            if ($notification->signature_key != $signatureKey) {
                return response()->json(['message' => 'Invalid signature.'], 403);
            }

            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;

            // Handle status transaksi
            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                if ($fraudStatus == 'accept') {
                    // Pembayaran berhasil
                    $order->status = 'Diproses';
                    $order->save();
                }
            } else if ($transactionStatus == 'pending') {
                // Pembayaran tertunda
                $order->status = 'Belum Dibayar';
                $order->save();
            } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                // Pembayaran gagal atau dibatalkan
                $order->status = 'Dibatalkan';
                $order->save();
            }

            return response()->json(['message' => 'Webhook handled successfully.']);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}