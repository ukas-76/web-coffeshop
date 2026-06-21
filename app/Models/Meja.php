<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    use HasFactory;

    // 1. Tentukan nama tabel di database jika tidak menggunakan jamak (plural) bahasa Inggris
    protected $table = 'meja'; // Sesuai dengan nama tabel di databasemu

    // 2. Daftarkan semua kolom yang boleh diisi (Mass Assignment)
    // PASTIKAN 'min_dp' sudah masuk di sini agar bisa di-update oleh Controller!
    protected $fillable = [
        'nomor_meja',    //
        'kapasitas',     //
        'min_dp',        // Kolom baru untuk minimum DP reservasi
        'status',        //
        'gambar_lokasi' 
    ];

    /**
     * Relasi ke tabel Reservasi (One to Many)
     * Satu meja bisa memiliki banyak riwayat reservasi
     */
    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'meja_id'); //
    }
}