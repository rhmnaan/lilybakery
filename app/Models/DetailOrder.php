<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailOrder extends Model
{
    use HasFactory;

    protected $table = 'detail_order';
    protected $primaryKey = 'id_detail_order';
    public $timestamps = false;

    protected $fillable = [
        'id_order',
        'kode_produk',
        'jumlah',
        'subtotal'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kode_produk', 'kode_produk');
    }
}
