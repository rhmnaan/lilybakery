<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/about-us', function () {
    return view('about-us');
});

<<<<<<< HEAD

=======
>>>>>>> 23eb2fc99bc707a55f2da3544cca01a9f0c3831a
Route::get('/promotion', function () {
    return view('promotion');
});

Route::get('/stores', function () {
    return view('stores');
});

<<<<<<< HEAD
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
=======
Route::get('/product-detail', function () {
    return view('product-detail');
});

Route::get('/payment-method', function () {
    return view('payment-method');
>>>>>>> 23eb2fc99bc707a55f2da3544cca01a9f0c3831a
});

Route::get('/delivery-info', function () {
    return view('delivery-info');
});

<<<<<<< HEAD
Route::get('/payment-method', function () {
    return view('payment-method');
});

=======
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
});

Route::get('/contact', function () {
    return view('contact');
});


>>>>>>> 23eb2fc99bc707a55f2da3544cca01a9f0c3831a
Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
<<<<<<< HEAD
});
=======
});

Route::get('/admin-login', function () {
    return view('admin-login');
});

Route::get('/register-otp', function () {
    return view('register-otp');
});

Route::get('/custome-cake', function () {
    return view('custome-cake');
});


// Dashboard Admin
Route::get('Admin/admin-dashboard', function () {
    return view('Admin/admin-dashboard');
});

>>>>>>> 23eb2fc99bc707a55f2da3544cca01a9f0c3831a
