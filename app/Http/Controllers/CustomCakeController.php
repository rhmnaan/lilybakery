<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CustomCakeController extends Controller
{
    public function index()
    {
        $cakeImages = [];
        $path = public_path('images/custom-cakes');

        // Ambil semua file gambar dari folder public/images/custom-cakes
        if (File::exists($path)) {
            $files = File::files($path);

            foreach ($files as $file) {
                $cakeImages[] = [
                    'image' => $file->getFilename(),
                    'title' => pathinfo($file->getFilename(), PATHINFO_FILENAME), // Nama file tanpa ekstensi
                ];
            }
        }

        return view('custom-cakes', ['cakes' => $cakeImages]);
    }
}
