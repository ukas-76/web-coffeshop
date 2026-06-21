<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HalamanUtamaController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PromoEventController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MejaController;


/*
|--------------------------------------------------------------------------
| Jalur Autentikasi (Login & Register)
|--------------------------------------------------------------------------
*/
// Tambahkan ->name('login') agar Laravel tahu ini adalah halaman login utama
Route::get('/login', [AuthController::class, 'login'])->name('login');
// Route tampilan login admin (sudah ada)
Route::get('/login-admin', [AuthController::class, 'loginAdmin']);
Route::get('/register', [AuthController::class, 'register'])->name('register'); 
// Route POST untuk memproses form (BARU)
Route::post('/login-admin', [AuthController::class, 'prosesLoginAdmin']);
Route::post('/register', [AuthController::class, 'prosesRegister']);
Route::post('/login', [AuthController::class, 'prosesLogin']);
Route::post('/logout', [AuthController::class, 'prosesLogout'])->name('logout');

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


/*
|--------------------------------------------------------------------------
| Jalur Khusus User Terautentikasi (Fitur Profil)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Memanggil method profile() yang baru saja kita buat di atas
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile'); 
    
    Route::patch('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    
    // Pastikan namanya 'profile.avatar.update' jika di blade Anda menggunakan nama ini
    Route::patch('/profile/avatar', [AuthController::class, 'updateAvatar'])->name('profile.avatar.update');
});

/*
|--------------------------------------------------------------------------
| Jalur Khusus Admin
|--------------------------------------------------------------------------
| Kita menggunakan fitur "prefix" agar semua URL admin otomatis diawali 
| dengan '/admin'. Contoh: namacoffeeshop.com/admin/dashboard
*/

Route::prefix('admin')->group(function () {
    // 1. Dashboard Utama & Unduh Laporan
    Route::get('/dashboard', [DashboardAdminController::class, 'index']); 
    Route::get('/export-laporan', [DashboardAdminController::class, 'exportLaporan']);

    // 2. Manajemen Menu
    Route::get('/menus', [DashboardAdminController::class, 'menus']);
    Route::post('/menus', [DashboardAdminController::class, 'storeMenu']); 
    Route::put('/menus/{id}', [DashboardAdminController::class, 'updateMenu']);
    Route::delete('/menus/{id}', [DashboardAdminController::class, 'hapusMenu']);

    // 3. Manajemen Reservasi (Dine-in)
    Route::get('/reservations', [DashboardAdminController::class, 'indexReservasi']);
    Route::post('/reservations', [DashboardAdminController::class, 'storeReservasi']);
    Route::put('/reservations/{id}/status', [DashboardAdminController::class, 'updateStatusReservasi']);

    // 4. Manajemen Pesanan (Delivery & Pickup)
    Route::get('/orders', [DashboardAdminController::class, 'indexPesanan']);
    Route::put('/pesanan/{id}/status', [DashboardAdminController::class, 'updateStatusPesanan']);

    // 5. Manajemen Pengguna (Pelanggan)
    Route::get('/users', [DashboardAdminController::class, 'users']);
    Route::delete('/users/{id}', [DashboardAdminController::class, 'hapusUser']);

    // Rute Pencarian Global
    Route::get('/search', [DashboardAdminController::class, 'globalSearch']);

    // Route tampilan login admin (sudah ada)
    Route::get('/login-admin', [AuthController::class, 'loginAdmin']);

    // TAMBAHKAN ROUTE INI: Untuk memproses data login admin
    Route::post('/login-admin', [AuthController::class, 'prosesLoginAdmin']);

    // 1. Route Promo & Event (Dipisah controllernya agar kode tetap rapi dan bersih)
    Route::get('/promo-event', [PromoEventController::class, 'index']);
    Route::post('/promo/store', [PromoController::class, 'store'])->name('promo.store');
    Route::post('/event/store', [EventController::class, 'store'])->name('event.store');

    // Route untuk Promo
    Route::put('/promo/update/{id}', [PromoController::class, 'update'])->name('promo.update');
    Route::delete('/promo/destroy/{id}', [PromoController::class, 'destroy'])->name('promo.destroy');

    // Route untuk Event
    Route::put('/event/update/{id}', [EventController::class, 'update'])->name('event.update');
    Route::delete('/event/destroy/{id}', [EventController::class, 'destroy'])->name('event.destroy');

    // 2. Route Manajemen Meja
    Route::get('/meja', [MejaController::class, 'index'])->name('meja.index');
    Route::post('/meja/store', [MejaController::class, 'store'])->name('meja.store');
    Route::put('/meja/update/{id}', [MejaController::class, 'update'])->name('meja.update');
    Route::delete('/meja/destroy/{id}', [MejaController::class, 'destroy'])->name('meja.destroy');
});