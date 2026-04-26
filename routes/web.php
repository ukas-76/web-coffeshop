<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/menu', function () {
    return view('menu');
});

Route::get('/reservasi', function () {
    return view('reservasi');
});

Route::get('/order', function () {
    return view('order');
});

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/login-admin', function () {
    return view('login-admin');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/payment', function () {
    return view('payment');
});

// Redirect old route to new one
Route::get('/dashboard-admin', function () {
    return redirect('/admin/dashboard');
});

// Admin Route Group
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });
    
    Route::get('/pesanan', function () {
        return view('admin.orders');
    });

    Route::get('/reservasi', function () {
        return view('admin.reservations');
    });

    Route::get('/katalog-menu', function () {
        return view('admin.menus');
    });

    Route::get('/pengguna', function () {
        return view('admin.users');
    });
});
