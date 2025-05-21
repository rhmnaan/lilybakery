<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id('id_ulasan');
            $table->foreignId('id_pelanggan')->nullable()->constrained('pelanggan', 'id_pelanggan');
            $table->foreignId('kode_produk')->nullable()->constrained('produk', 'kode_produk');
            $table->integer('rating')->nullable();
            $table->timestamp('tanggal')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};