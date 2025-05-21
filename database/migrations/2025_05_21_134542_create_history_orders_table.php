<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('history_order', function (Blueprint $table) {
            $table->id('id_history');
            $table->foreignId('id_order')->nullable()->constrained('orders', 'id_order');
            $table->timestamp('tanggal_selesai')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('history_order');
    }
};