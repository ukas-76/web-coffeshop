<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $table = 'reservasi';

    protected $fillable = [
        'pengguna_id',
        'jenis_pesanan', // 'dine_in', 'delivery', 'pickup'
        'meja_id',
        'tanggal_reservasi',
        'jam_mulai',
        'jam_selesai',
        'total_tamu',
        'alamat_pengiriman',
        'ongkir',
        'status' // 'menunggu', 'dikonfirmasi', 'selesai', 'dibatalkan'
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