<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    // Laravels berasumsi nama tabelnya 'promos', ini sudah sesuai dengan database-mu
    protected $table = 'promos';

    protected $fillable = [
        'judul',
        'deskripsi',
        'badge_teks',
        'gambar',
        'link_aksi',
    ];
}