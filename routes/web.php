<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PelangganLoginController;
use App\Http\Controllers\Auth\AdminLoginController; // Pastikan ini diimpor
use App\Http\Controllers\StoreLocationController;
use App\Http\Controllers\PelangganProfileController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PelangganOrderController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProdukController;

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

Route::get('/custome-cake', function () {
    return view('custome-cake');
});

Route::get('/payment', function () {
    return view('payment');
})->name('payment');


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
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout'); // Rute Logout Admin

// --- Rute Dashboard Admin (Terproteksi) ---
Route::middleware(['auth:admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Route Untuk Halaman Pesanan(Orders)
        Route::get('/orders', [OrdersController::class, 'index'])->name('orders');
        Route::post('/orders/store', [OrdersController::class, 'store'])->name('orders.store');
        Route::post('/orders/data', [OrdersController::class, 'data'])->name('orders.data');

        // Route Untuk Halaman Pelanggan (Customer)
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
        Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

        // Rute untuk menampilkan halaman setting
        Route::get('/settings', [SettingController::class, 'index'])->name('settings');

        // Rute untuk update password admin utama
        Route::put('/settings/main-admin-password/{id}', [SettingController::class, 'updateMainAdminPassword'])->name('settings.updateMainAdminPassword');

       // Rute untuk manajemen admin lain (CRUD)
        Route::get('/settings/admins', [SettingController::class, 'getOtherAdmins'])->name('settings.getOtherAdmins'); // Untuk mendapatkan data awal
        Route::post('/settings/admins', [SettingController::class, 'storeAdmin'])->name('settings.storeAdmin');
        Route::put('/settings/admins/{id}', [SettingController::class, 'updateAdmin'])->name('settings.updateAdmin');
        Route::delete('/settings/admins/{id}', [SettingController::class, 'destroyAdmin'])->name('settings.destroyAdmin');
        
        // admin product
        // Route::get('/product', function () {
        //     return view('Admin.admin-product'); // Sesuaikan path view jika berbeda
        // })->name('product');
    Route::get('product', [ProdukController::class, 'index'])->name('product'); // Ganti nama route
    Route::post('product', [ProdukController::class, 'store'])->name('product.store');
    Route::get('product/{produk}/edit', [ProdukController::class, 'edit'])->name('product.edit');
    Route::put('product/{produk}', [ProdukController::class, 'update'])->name('product.update');
    Route::delete('product/{produk}', [ProdukController::class, 'destroy'])->name('product.destroy');

        // admin setting
        Route::get('/setting', function () {
            return view('Admin.admin-setting'); // Sesuaikan path view jika berbeda
        })->name('setting');
    });
});

// Rute untuk lokasi toko
Route::get('/stores', [StoreLocationController::class, 'index'])->name('stores.index'); // New route

// pesanan
Route::get('/pesanan', function () {
    return view('pesanan');
});

// keranjang
Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');

// order info
Route::get('/orderinfo', [OrderController::class, 'orderInfo'])->name('order.info');



// test produk
Route::middleware('web')->group(function () {
    Route::resource('produk', ProdukController::class);
});