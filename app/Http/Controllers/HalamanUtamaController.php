<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HalamanUtamaController extends Controller
{
    public function index()
    {
        // Mengarahkan ke file resources/views/index.blade.php
        return view('index'); 
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