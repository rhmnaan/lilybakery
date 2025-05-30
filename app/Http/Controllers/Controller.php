<?php

namespace App\Http\Controllers;

// Tambahkan use statement ini:
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController; // Penting!

// Modifikasi deklarasi kelas Controller Anda:
class Controller extends BaseController // Pastikan extends BaseController
{
    // Tambahkan penggunaan trait ini:
    use AuthorizesRequests, ValidatesRequests;
    // Di beberapa versi Laravel yang lebih lama, mungkin juga ada DispatchesJobs:
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}