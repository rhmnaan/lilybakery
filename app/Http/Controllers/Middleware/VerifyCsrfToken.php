<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // BARIS INI yang paling penting:
        'api/*', // Ini akan mengecualikan semua rute yang dimulai dengan '/api/'
    ];
}