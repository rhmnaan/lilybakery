<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('store_location', function (Blueprint $table) {
            $table->id('id_store');
            $table->string('nama_toko', 100)->nullable();
            $table->text('alamat')->nullable();
            $table->string('telp', 15)->nullable();
            $table->text('link_location')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_location');
    }
};