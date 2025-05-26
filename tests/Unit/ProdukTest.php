<?php

namespace Tests\Unit;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Foundation\Testing\RefreshDatabase; // Untuk mereset database setiap test
use Tests\TestCase;

class ProdukTest extends TestCase
{
    use RefreshDatabase; // Penting!

    /** @test */
    public function produk_belongs_to_a_kategori()
    {
        // 1. Persiapan (Arrange)
        $kategori = Kategori::factory()->create(); // Jika Anda punya factory
        // Atau buat manual: $kategori = Kategori::create(['nama_kategori' => 'Test Kategori']);
        // Pastikan model Kategori Anda punya $timestamps = false jika tidak pakai timestamps
        if (!property_exists(Kategori::class, 'timestamps') || (new Kategori())->usesTimestamps()) {
             // Anda mungkin perlu menambahkan $timestamps = false; di Kategori jika migrasinya tidak punya timestamps
        }


        $produk = Produk::factory()->create(['id_kategori' => $kategori->id_kategori]);
        // Atau buat manual:
        // $produk = Produk::create([
        //     'nama_produk' => 'Test Produk',
        //     'id_kategori' => $kategori->id_kategori,
        //     'harga' => 10000,
        //     // ... field lainnya
        // ]);
        // Pastikan model Produk Anda punya $timestamps = false jika tidak pakai timestamps

        // 2. Aksi (Act)
        $kategoriDariProduk = $produk->kategori;

        // 3. Penegasan (Assert)
        $this->assertInstanceOf(Kategori::class, $kategoriDariProduk);
        $this->assertEquals($kategori->id_kategori, $kategoriDariProduk->id_kategori);
    }

    // Tambahkan test lain untuk relasi dan fungsionalitas model Produk
}