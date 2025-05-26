<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('id_order');
            $table->foreignId('id_pelanggan')->nullable()->constrained('pelanggan', 'id_pelanggan');
            $table->integer('total_harga')->nullable();
            $table->timestamp('tanggal_order')->useCurrent();
            $table->enum('status', ['Belum Dibayar', 'Diproses', 'Dikirim', 'Dibatalkan'])->nullable();
            $table->integer('ongkir')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};