<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promo extends Model
{
    use HasFactory;

    protected $table = 'promo';
    protected $primaryKey = 'id_promo';
    public $timestamps = false;

    protected $fillable = [
        'kode_produk',
        'diskon_persen',
        'deskripsi_promo',
        'tanggal_mulai',
        'tanggal_berakhir'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kode_produk', 'kode_produk');
    }
}
