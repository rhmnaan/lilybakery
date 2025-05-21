<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    
    protected $fillable = [
        'nama_pelanggan',
        'email',
        'password',
        'telp',
        'jenis_kelamin',
        'alamat'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'id_pelanggan', 'id_pelanggan');
    }
}
