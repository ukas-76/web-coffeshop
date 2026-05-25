<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Arahkan ke tabel pengguna
    protected $table = 'pengguna'; 

    protected $fillable = [
        'tingkat_pelanggan_id', 'nama', 'email', 'password', 'nomor_telepon', 'role', 'poin'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Relasi ke tabel tingkat pelanggan
    public function tingkatPelanggan()
    {
        return $this->belongsTo(TingkatPelanggan::class, 'tingkat_pelanggan_id');
    }
}
