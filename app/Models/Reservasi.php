<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $table = 'reservasi';
    protected $fillable = [
        'pengguna_id', 'meja_id', 'tanggal_reservasi', 'jam_mulai', 'jam_selesai', 'total_tamu', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function meja()
    {
        return $this->belongsTo(Meja::class, 'meja_id');
    }
}
