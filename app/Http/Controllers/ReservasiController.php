<?php

namespace App\Http\Controllers;

use App\Models\Meja; // Pastikan nama Model Meja Anda sudah benar
use App\Models\Menu; // Pastikan nama Model Menu Anda sudah benar
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    /**
     * Menampilkan halaman reservasi untuk pelanggan
     */
    public function userIndex()
    {
        // Ambil meja yang statusnya 'tersedia' dari database
        $daftarMeja = Meja::where('status', 'tersedia')->get();

        // Ambil semua data menu untuk pilihan DP awal
        $daftarMenu = Menu::where('tersedia', '1')->get();

        // Mengarah ke file: resources/views/reservasi.blade.php
        return view('reservasi', compact('daftarMeja', 'daftarMenu'));
    }

    /**
     * Proses simpan data reservasi baru
     */
    public function store(Request $request)
    {
        // Logika penyimpanan data booking Anda di sini...
    }
}