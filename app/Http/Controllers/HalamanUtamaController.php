<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;
use App\Models\Event;
use App\Models\Menu;

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
        // Ambil menu yang tersedia dari database beserta kategori
        $menus = Menu::with('kategori')->where('tersedia', true)->get();

        // Kirimkan data menus ke view
        return view('menu', compact('menus'));
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