<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// Make sure your Pelanggan model extends Authenticatable if it's used for authentication
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable; // If you use notifications

class Pelanggan extends Authenticatable // Changed from Model to Authenticatable
{
    use HasFactory, Notifiable; // Added Notifiable if needed

    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    public $timestamps = false; // Keep this if your table doesn't have created_at/updated_at
                                // If it does, remove this line or set to true.
                                // Based on your migration, you DO have timestamps. So REMOVE/COMMENT this line.

    protected $fillable = [
        'nama_pelanggan',
        'email',
        'password',
        'otp',
        'otp_expires_at',
        'email_verified',
        'telp',
        'jenis_kelamin',
        'alamat',
        // Add 'email_verified_at' if you manage it
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp',
        'otp_expires_at', // Add if you use "remember me" functionality
    ];

    protected $casts = [
        // 'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'otp_expires_at' => 'datetime', // Cast this to datetime
        'email_verified' => 'boolean',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array // Changed from protected $casts to a method for Laravel 10+
    {
        return [
            'email_verified_at' => 'datetime', // If you have this column
            'password' => 'hashed', // Ensures password is automatically hashed
        ];
    }

    // ... (relationships if any)
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