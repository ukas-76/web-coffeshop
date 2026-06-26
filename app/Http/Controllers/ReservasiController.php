<?php

namespace App\Http\Controllers;

use App\Models\Meja; // Pastikan nama Model Meja Anda sudah benar
use App\Models\Menu; // Pastikan nama Model Menu Anda sudah benar
use Illuminate\Http\Request;
use App\Models\Reservasi; // Pastikan nama Model Reservasi Anda sudah benar
use Carbon\Carbon; // Pastikan Anda sudah menginstal Carbon untuk manipulasi tanggal dan waktu

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
        // 1. Validasi Input Data dari Form User
        $request->validate([
            'id_meja'           => 'required|exists:mejas,id', // Sesuaikan nama tabel meja lu di database (mejas / meja)
            'tanggal_reservasi' => 'required|date|after_or_equal:today',
            'jam_mulai'         => 'required',
            'total_tamu'        => 'required|integer|min:1',
            'total_harga'       => 'required|numeric',
        ]);

        // 2. Simpan Data Reservasi ke Database
        // Menggunakan auth()->id() karena ini dilakukan dari halaman user yang sudah login
        Reservasi::create([
            'pengguna_id'       => auth()->guard('web')->id(), 
            'jenis_pesanan'     => 'dine_in',
            'meja_id'           => $request->id_meja, // Memetakan input 'id_meja' dari form user ke kolom 'meja_id' di database
            'tanggal_reservasi' => $request->tanggal_reservasi,
            'jam_mulai'         => $request->jam_mulai,
            'jam_selesai'       => $request->jam_selesai ?? Carbon::parse($request->jam_mulai)->addHours(2)->format('H:i'), // Otomatis booking 2 jam jika kosong
            'total_tamu'        => $request->total_tamu,
            'total_harga'       => $request->total_harga,
            'status'            => 'menunggu' // Status awal menanti verifikasi pembayaran DP / kedatangan
        ]);

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->route('pembayaran.atau.riwayat')->with('success', 'Reservasi meja berhasil dibuat! Silakan lakukan pembayaran DP.');
    }
}