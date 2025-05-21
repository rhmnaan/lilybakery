<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id('kode_produk');
            $table->string('nama_produk', 100)->nullable();
            $table->foreignId('id_kategori')->nullable()->constrained('kategori', 'id_kategori');
            $table->integer('harga')->nullable();
            $table->integer('stok')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};