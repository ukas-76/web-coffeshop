<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $fillable = ['reservasi_id', 'total_bayar', 'metode_pembayaran', 'status'];
}