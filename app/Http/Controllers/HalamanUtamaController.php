<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;
use App\Models\Event;

class HalamanUtamaController extends Controller
{
    public function index()
    {
        // Mengambil semua data promo dan event dari database
        $promos = Promo::all();
        $events = Event::all();

        // Mengirimkan data ke view index.blade.php
        return view('index', compact('promos', 'events')); 
    }

    public function menu()
    {
        // Mengarahkan ke file resources/views/menu.blade.php
        return view('menu');
    }

    public function about()
    {
        return view('about');
    }

    public function order()
    {
        return view('order');
    }

    public function payment()
    {
        return view('payment');
    }

    public function profile()
    {
        return view('profile');
    }
}