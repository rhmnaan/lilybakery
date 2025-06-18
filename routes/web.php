<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PelangganLoginController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\StoreLocationController;
use App\Http\Controllers\PelangganProfileController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PelangganOrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CustomCakeController;
use App\Http\Controllers\Admin\PromoController as AdminPromoController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\Admin\AdminStoreController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Admin\KategoriController;


use App\Http\Controllers\ProdukController as PublicProdukController;


Route::get('/', [HomeController::class, 'index']);

// Rute untuk 
Route::post('/midtrans/webhook', [MidtransWebhookController::class, 'handle']);


Route::get('/about-us', function () {
    return view('about-us');
});

Route::get('/promotion', function () {
    return view('promotion');
});
// Route::get('/promotion', action: [PromoController::class, 'index'])->name('promotion.index');

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

    // pesanan
    Route::get('/pesanan', [PelangganOrderController::class, 'index'])->name('pesanan.index');
    Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
    
    Route::patch('/admin/product/promo/{kode_produk}/update', [ProdukController::class, 'updatePromo']);

    // keranjang
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah', [KeranjangController::class, 'tambahKeKeranjang'])->name('keranjang.tambah');
    Route::delete('/keranjang/hapus/{id_keranjang}', [KeranjangController::class, 'hapusDariKeranjang'])->name('keranjang.hapus');
    Route::patch('/keranjang/update/{id_keranjang}', [KeranjangController::class, 'updateKuantitas'])->name('keranjang.update');

    Route::get('/order-info', [OrderController::class, 'orderInfo'])->name('order.info');
    Route::post('/order-info/save', [OrderController::class, 'saveOrderInfo'])->name('order.save_info');

    Route::get('/payment', [PembayaranController::class, 'show'])->name('payment.show');
    Route::post('/payment/process', [PembayaranController::class, 'process'])->name('payment.process');

    // Rute untuk buy now
    Route::post('/buy-now', [OrderController::class, 'buyNow'])->name('order.buyNow');

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

        // Halaman utama kategori
        Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
        // Tambah kategori
        Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
        // Update kategori
        Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
        // Hapus kategori
        Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

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
        Route::get('product', [ProdukController::class, 'index'])->name('product'); // Ganti nama route
        Route::post('product', [ProdukController::class, 'store'])->name('product.store');
        Route::get('product/{produk}/edit', [ProdukController::class, 'edit'])->name('product.edit');
        Route::put('product/{produk}', [ProdukController::class, 'update'])->name('product.update');
        Route::delete('product/{produk}', [ProdukController::class, 'destroy'])->name('product.destroy');
        

        // admin product promo
        Route::get('product/promo/kode/{kode_produk}/edit', [ProdukController::class, 'editPromoByKode'])->name('product.promo.editByKode');
        Route::post('product/promo/{id}/update', [ProdukController::class, 'updatePromo'])->name('product.promo.update');


        // admin promosi
        Route::post('/promotions', [AdminPromoController::class, 'store'])->name('promo.store');
        Route::resource('promotions', AdminPromoController::class)->only([
            'store',
            'update',
            'destroy'
        ])->names('promo');

        // orders
        Route::get('/orders', [OrdersController::class, 'index'])->name('orders');
        Route::post('/orders', [OrdersController::class, 'store'])->name('orders.store'); // Ganti dari orders.store ke orders saja agar konsisten
        Route::post('/orders/export', [OrdersController::class, 'exportData'])->name('orders.data'); // Ganti nama metode
        Route::get('/orders/{order}/edit', [OrdersController::class, 'edit'])->name('orders.edit');
        Route::put('/orders/{order}', [OrdersController::class, 'update'])->name('orders.update');
        Route::delete('/orders/{order}', [OrdersController::class, 'destroy'])->name('orders.destroy');

        // admin setting
        // Route::get('/setting', function () {
        //     return view('Admin.admin-setting'); // Sesuaikan path view jika berbeda
        // })->name('setting');
        // --- Rute untuk Halaman Setting ---
        Route::get('/settings', [SettingController::class, 'index'])->name('settings');
        Route::get('/settings', [SettingController::class, 'index'])->name('settings');
        Route::put('/settings/main-admin-password/{id}', [SettingController::class, 'updateMainAdminPassword'])->name('settings.updateMainAdminPassword');

        // Rute untuk manajemen admin lain (CRUD)
        Route::post('/settings/admins', [SettingController::class, 'storeAdmin'])->name('settings.storeAdmin');
        Route::get('/settings/admins/{id}/edit', [SettingController::class, 'edit'])->name('settings.editAdmin'); // <-- ROUTE BARU
        Route::put('/settings/admins/{id}', [SettingController::class, 'updateAdmin'])->name('settings.updateAdmin');
        Route::delete('/settings/admins/{id}', [SettingController::class, 'destroyAdmin'])->name('settings.destroyAdmin');

        // Rute untuk halaman Store Admin
        Route::get('/store', [AdminStoreController::class, 'index'])->name('store');
        Route::get('/store/search', [AdminStoreController::class, 'search'])->name('store.search');
        Route::post('/store', [AdminStoreController::class, 'store'])->name('store.store');
        Route::put('/store/{id}', [AdminStoreController::class, 'update'])->name('store.update');

        // [TAMBAHKAN INI] Rute untuk menghapus toko
        Route::delete('/store/{id}', [AdminStoreController::class, 'destroy'])->name('store.destroy');
        
      
    });
});

// use App\Http\Controllers\Api\AuthController;
// Form awal untuk isi email/telepon
Route::get('/register', function () {
    return view('register');
})->name('register.form');
// Form OTP setelah email dikirim
Route::get('/verify-otp', function () {
    return view('auth.verify-otp');
})->name('verify.otp.form');
// Proses POST register (kirim email + simpan pelanggan)
Route::post('/register', [AuthController::class, 'register'])->name('register');
// Proses verifikasi OTP
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');
// Proses resend OTP
Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('resend.otp');

// Forgot password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showEmailForm'])->name('forgot.password.form');
Route::post('/forgot-password/send-otp', [ForgotPasswordController::class, 'sendOtp'])->name('forgot.password.sendOtp');
Route::get('/forgot-password/verify', [ForgotPasswordController::class, 'showVerifyOtpForm'])->name('forgot.password.verify.form');
Route::post('/forgot-password/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('forgot.password.verifyOtp');
Route::post('/forgot-password/resend-otp', [ForgotPasswordController::class, 'resendOtp'])->name('forgot.password.resendOtp');
Route::get('/forgot-password/reset', [ForgotPasswordController::class, 'showResetForm'])->name('forgot.password.reset.form');
Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'resetPassword'])->name('forgot.password.reset');



// Rute untuk lokasi toko
Route::get('/stores', [StoreLocationController::class, 'index'])->name('stores.index'); // New route


// keranjang
Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');

// order info
Route::get('/orderinfo', [OrderController::class, 'orderInfo'])->name('order.info');

Route::get('/produk/{produk}', [PublicProdukController::class, 'show'])->name('produk.show');

// Rute untuk kategori produk
Route::get('/menu/{category}', [MenuController::class, 'showCategory'])->name('menu.category');
// Rute untuk menampilkan semua produk
Route::get('/custom-cakes', [CustomCakeController::class, 'index'])->name('custom-cakes.index');

