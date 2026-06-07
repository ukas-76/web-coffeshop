<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HalamanUtamaController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| Jalur Autentikasi (Login & Register)
|--------------------------------------------------------------------------
*/
// Tambahkan ->name('login') agar Laravel tahu ini adalah halaman login utama
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/login-admin', [AuthController::class, 'loginAdmin']);
Route::get('/register', [AuthController::class, 'register'])->name('register'); 
// Route POST untuk memproses form (BARU)
Route::post('/register', [AuthController::class, 'prosesRegister']);
Route::post('/login', [AuthController::class, 'prosesLogin']);

/*
|--------------------------------------------------------------------------
| Jalur Pengunjung (Halaman Depan)
|--------------------------------------------------------------------------
*/

// Jika user mengakses namacoffeeshop.com/
Route::get('/', [HalamanUtamaController::class, 'index']);

// Jika user mengakses namacoffeeshop.com/menu
Route::get('/menu', [HalamanUtamaController::class, 'menu']);


// Jika user mengakses namacoffeeshop.com/reservasi
Route::get('/reservasi', [ReservasiController::class, 'index']);

Route::get('/about', [HalamanUtamaController::class, 'about']);
Route::get('/order', [HalamanUtamaController::class, 'order']);
Route::get('/payment', [HalamanUtamaController::class, 'payment']);
Route::get('/profile', [HalamanUtamaController::class, 'profile']);


/*
|--------------------------------------------------------------------------
| Jalur Khusus Admin
|--------------------------------------------------------------------------
| Kita menggunakan fitur "prefix" agar semua URL admin otomatis diawali 
| dengan '/admin'. Contoh: namacoffeeshop.com/admin/dashboard
*/

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index']);

    Route::get('/menus', [DashboardAdminController::class, 'menus']);
    Route::get('/orders', [DashboardAdminController::class, 'orders']);
    Route::get('/reservations', [DashboardAdminController::class, 'reservations']);
    Route::get('/users', [DashboardAdminController::class, 'users']);

    Route::delete('/users/{id}', [DashboardAdminController::class, 'hapusUser']);
    Route::delete('/menus/{id}', [DashboardAdminController::class, 'hapusMenu']);

    Route::post('/menus', [DashboardAdminController::class, 'storeMenu']); 
    Route::put('/menus/{id}', [DashboardAdminController::class, 'updateMenu']);

    Route::get('/reservasi', [DashboardAdminController::class, 'indexReservasi']);
    Route::get('/orders', [DashboardAdminController::class, 'indexPesanan']);
    Route::put('/pesanan/{id}/status', [DashboardAdminController::class, 'updateStatusPesanan']);
    Route::get('/reservations', [DashboardAdminController::class, 'indexReservasi']);
    Route::post('/reservations', [DashboardAdminController::class, 'storeReservasi']);
    Route::put('/reservations/{id}/status', [DashboardAdminController::class, 'updateStatusReservasi']);
});