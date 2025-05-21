<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promo', function (Blueprint $table) {
            $table->id('id_promo');
            $table->foreignId('kode_produk')->nullable()->constrained('produk', 'kode_produk');
            $table->decimal('diskon_persen', 5, 2)->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_berakhir')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promo');
    }
};