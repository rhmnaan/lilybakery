<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id_order';
    public $timestamps = false;

    protected $fillable = [
        'id_pelanggan',
        'total_harga',
        'tanggal_order',
        'status',
        'ongkir'
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function detailOrder()
    {
        return $this->hasMany(DetailOrder::class, 'id_order', 'id_order');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_order', 'id_order');
    }

    public function historyOrder()
    {
        return $this->hasOne(HistoryOrder::class, 'id_order', 'id_order');
    }
}
