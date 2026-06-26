<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailReservasi extends Model
{
    protected $table = 'detail_reservasi';
    protected $fillable = ['reservasi_id', 'menu_id', 'jumlah', 'harga_saat_reservasi'];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'reservasi_id');
    }
}
