<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CustomCakeController;
use App\Http\Controllers\Auth\PelangganLoginController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\StoreLocationController;
use App\Http\Controllers\PelangganProfileController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PelangganOrderController;

Route::get('/', function () {
    return view('index');
});

Route::get('/about-us', function () {
    return view('about-us');
});

Route::get('/promotion', function () {
    return view('promotion');
});

Route::get('/promotion', [PromoController::class, 'index'])->name('promotion.index');

Route::get('/stores', function () {
    return view('stores');
});

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
});

Route::get('/product-detail', function () {
    return view('product-detail');
});

Route::get('/payment-method', function () {
    return view('payment-method');
});

Route::get('/delivery-info', function () {
    return view('delivery-info');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/register-otp', function () {
    return view('register-otp');
});

Route::get('/cart', function () {
    return view('cart');
});

Route::get('/order-info', function () {
    return view('order-info');
})->name('order.info');

Route::get('profil-pelanggan', function () {
    return view('profil-pelanggan');
})->name('profil-pelanggan');

// Dashboard Admin
Route::get('Admin/admin-dashboard', function () {
    return view('Admin/admin-dashboard');
});

// --- Rute Autentikasi Pelanggan ---
Route::get('/login', [PelangganLoginController::class, 'showLoginForm'])->name('pelanggan.login.form');
Route::post('/login', [PelangganLoginController::class, 'login'])->name('pelanggan.login.attempt');
Route::post('/logout', [PelangganLoginController::class, 'logout'])->name('pelanggan.logout');

Route::middleware(['auth:pelanggan'])->group(function () {
    Route::get('/pelanggan/dashboard', function () {
        return view('pelanggan.index'); // Jika filenya resources/views/pelanggan/index.blade.php
    })->name('pelanggan.dashboard');
});

// Profile routes for 'pelanggan' guard
Route::middleware(['auth:pelanggan'])->prefix('profile')->name('pelanggan.profile.')->group(function () {
    Route::get('/', [PelangganProfileController::class, 'show'])->name('show'); // To display the profile page
    Route::post('/update-profile', [PelangganProfileController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-account-info', [PelangganProfileController::class, 'updateAccountInfo'])->name('updateAccountInfo');
    Route::post('/change-password', [PelangganProfileController::class, 'changePassword'])->name('changePassword');
});

// --- Rute Autentikasi Admin ---
Route::get('/admin-login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('/admin-login', [AdminLoginController::class, 'login'])->name('admin.login.attempt');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// --- Rute Dashboard Admin (Terproteksi) ---
Route::middleware(['auth:admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('Admin.admin-dashboard'); // Sesuaikan path view jika berbeda
        })->name('dashboard');
    });
});

// Rute untuk lokasi toko
Route::get('/stores', [StoreLocationController::class, 'index'])->name('stores.index'); // New route

Route::get('/product-detail', function () {
    return view('product-detail');
});

// pesanan
Route::get('/pesanan', function () {
    return view('pesanan');
});


// keranjang
Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');

Route::get('/menu/{category}', [MenuController::class, 'showCategory'])->name('menu.category');

// Route detail produk
Route::get('/menu/{category}/{productName}', [MenuController::class, 'showProductDetail'])->name('product.detail');

Route::get('/custom-cakes', [CustomCakeController::class, 'index'])->name('custom-cakes');

// order info
Route::get('/orderinfo', [OrderController::class, 'orderInfo'])->name('order.info');