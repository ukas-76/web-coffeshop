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
}