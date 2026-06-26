<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $table = 'reservasi';

    protected $fillable = [
        'pengguna_id', 
        'meja_id', 
        'jenis_pesanan', 
        'tanggal_reservasi', 
        'jam_mulai', 
        'jam_selesai',
        'total_tamu',
        'total_harga', 
        'status'
    ];

    // Relasi ke tabel Pengguna/Pelanggan
    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    // Relasi ke tabel Meja
    public function meja()
    {
        return $this->belongsTo(Meja::class, 'meja_id');
    }

    // Relasi ke Detail Reservasi
    public function detailReservasi()
    {
        return $this->hasMany(DetailReservasi::class, 'reservasi_id');
    }

    // Relasi ke Pembayaran
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'reservasi_id');
    }
}