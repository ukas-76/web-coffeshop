<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TingkatPelanggan extends Model
{
    protected $table = 'tingkat_pelanggan';
    protected $fillable = ['nama', 'poin_minimal', 'persentase_diskon'];
}
