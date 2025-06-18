<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'kode_produk';
    public $timestamps = false; // ⛔ Nonaktifkan created_at & updated_at

    protected $fillable = [
        'nama_produk',
        'id_kategori',
        'harga',
        'stok',
        'deskripsi',
        'gambar',
        'status'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function promo()
    {
        return $this->hasOne(Promo::class, 'kode_produk', 'kode_produk');
    }

    public function detailOrder()
    {
        return $this->hasMany(DetailOrder::class, 'kode_produk', 'kode_produk');
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'kode_produk', 'kode_produk');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'kode_produk', 'kode_produk');
    }

    // Scope untuk mengambil produk yang belum memiliki promo
    public function scopeTanpaPromo($query)
    {
        return $query->whereDoesntHave('promo');
    }
    

}
