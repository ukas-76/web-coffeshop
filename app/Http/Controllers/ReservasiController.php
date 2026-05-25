<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function index()
    {
        // Mengarahkan ke file resources/views/reservasi.blade.php
        return view('reservasi');
    }
}