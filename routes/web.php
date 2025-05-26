<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/about-us', function () {
    return view('about-us');
});


Route::get('/promotion', function () {
    return view('promotion');
});

Route::get('/stores', function () {
    return view('stores');
});

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
});

Route::get('/delivery-info', function () {
    return view('delivery-info');
});

Route::get('/payment-method', function () {
    return view('payment-method');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});