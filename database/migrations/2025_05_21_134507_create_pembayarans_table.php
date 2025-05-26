<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('pembayaran_id');
            $table->foreignId('id_order')->nullable()->constrained('orders', 'id_order');
            $table->enum('metode', ['Transfer Bank', 'QRIS', 'E-Wallet'])->nullable();
            $table->integer('jumlah_bayar')->nullable();
            $table->timestamp('tanggal_pembayaran')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};