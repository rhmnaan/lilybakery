<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StoreLocation extends Model
{
    use HasFactory;

    protected $table = 'store_location';
    protected $primaryKey = 'id_store';
    public $timestamps = false;

    protected $fillable = [
        'nama_toko',
        'alamat',
        'telp',
        'link_location'
    ];
}
