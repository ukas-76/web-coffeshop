<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo; 
use App\Models\Event; 

class PromoEventController extends Controller
{
    public function index()
    {
        // Mengambil semua data promo dan event dari database
        $allPromo = Promo::latest()->get();
        $allEvent = Event::latest()->get();

        // Kirim kedua data ke satu view yang sama
        return view('admin.promo_event', compact('allPromo', 'allEvent'));
    }
}