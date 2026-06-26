<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembayaranController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Models\Pengaturan;

Route::get('/location', function () {
    $url = Pengaturan::where('kunci', 'google_maps_embed_url')->value('nilai');
    return response()->json([
        'success' => true,
        'embed_url' => $url
    ]);
});

use App\Http\Controllers\ReservasiController;
Route::get('/cek-ketersediaan-meja', [ReservasiController::class, 'cekKetersediaan']);

