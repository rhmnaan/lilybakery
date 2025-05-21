<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    // public $timestamps = false;
    
    protected $fillable = [
        'nama_admin',
        'email',
        'password',
        'telp',
        'jenis_kelamin',
        'alamat'
    ];
}
