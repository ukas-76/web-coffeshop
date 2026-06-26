<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturans';
    protected $fillable = ['kunci', 'nilai'];
    public $timestamps = false;
}
