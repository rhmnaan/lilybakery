<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_order', function (Blueprint $table) {
            $table->id('id_detail_order');
            $table->foreignId('id_order')->nullable()->constrained('orders', 'id_order');
            $table->foreignId('kode_produk')->nullable()->constrained('produk', 'kode_produk');
            $table->integer('jumlah')->nullable();
            $table->integer('subtotal')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_order');
    }
};