<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- 1. Tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 2. Tambahkan baris ini untuk memaksa semua URL yang dibuat
        //    oleh Laravel menggunakan skema HTTPS.
        //    Ini akan menyelesaikan masalah Mixed Content.
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            URL::forceScheme('https');
        }
    }
}