<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    public $timestamps = false;
    
    protected $fillable = [
        'nama_admin',
        'email',
        'password',
        'telp',
        'jenis_kelamin',
        'alamat'
    ];
}
