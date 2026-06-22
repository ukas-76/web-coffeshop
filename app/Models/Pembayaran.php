<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    // 1. Tentukan nama tabel secara eksplisit (opsional, tapi aman jika nama tabelmu jamak/tunggal)
    protected $table = 'pembayaran';

    // 2. Daftarkan kolom yang boleh diisi massal (Mass Assignment)
    protected $fillable = [
        'id_transaksi',
        'reservasi_id',
        'total_bayar',
        'metode_pembayaran',
        'status',
    ];

    // 3. Relasi: Setiap pembayaran itu milik (Belongs To) sebuah reservasi
    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'reservasi_id', 'id');
    }
}