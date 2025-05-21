<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    
    protected $fillable = [
        'nama_admin',
        'email',
        'password',
        'telp',
        'jenis_kelamin',
        'alamat'
    ];
}
