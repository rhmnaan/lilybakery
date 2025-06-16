<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id('id_pelanggan');
            $table->string('nama_pelanggan', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('password')->nullable();
            $table->string('telp', 15)->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->text('alamat')->nullable();
            $table->string('otp')->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->boolean('email_verified')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->dropColumn([
                'name_pelanggan', // Jika Anda menambahkan ini
                'telp',
                'jenis_kelamin',
                'alamat',
                'otp',
                'otp_expires_at',
                'email_verified'
            ]);
            // Jika Anda rename 'name' ke 'name_pelanggan', balikkan juga:
            // $table->renameColumn('name_pelanggan', 'name');
        });
    }

    // public function down(): void
    // {
    //     Schema::dropIfExists('pelanggan');
    // }
};