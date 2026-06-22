@extends('layouts.app')

@section('title', 'Katalog Menu | Roastory')

@push('styles')
<style>
/* General Header with Background Image */
.page-header {
    background-image: linear-gradient(rgba(45, 36, 32, 0.8), rgba(92, 61, 46, 0.85)), url('https://images.unsplash.com/photo-1559525839-b184a4d698c7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');
    background-size: cover;
    background-position: center;
    color: white;
    padding: 100px 0 80px 0;
    text-align: center;
    border-radius: 0 0 40px 40px;
    position: relative;
    box-shadow: 0 10px 30px rgba(92, 61, 46, 0.15);
}

/* Menu Card */
.menu-card {
    background: white; border-radius: 20px;
    border: 1px solid rgba(0,0,0,0.05); overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%; display: flex; flex-direction: column;
    box-shadow: 0 10px 20px rgba(0,0,0,0.02);
}
.menu-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(92, 61, 46, 0.1); }
.menu-img { width: 100%; height: 220px; object-fit: cover; border-bottom: 1px solid rgba(0,0,0,0.05); }
.menu-content { padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column; }
.menu-price { font-weight: 800; color: var(--primary-coffee); font-size: 1.25rem; }

/* Nav Pills Custom (Tab Menu) */
.nav-pills .nav-link {
    color: var(--text-dark); font-weight: 600; border-radius: 50px;
    padding: 12px 24px; transition: all 0.3s ease; border: 2px solid transparent;
}
.nav-pills .nav-link:hover { background-color: rgba(92, 61, 46, 0.05); }
.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    background-color: var(--primary-coffee); color: white;
    box-shadow: 0 5px 15px rgba(92, 61, 46, 0.2);
}
</style>
@endpush

@section('content')
<!-- Header Halaman -->
<div class="page-header mb-5" style="margin-top: 76px;">
    <div class="container">
        <h1 class="fw-bold display-4 mb-3">Katalog Rasa</h1>
        <p class="lead opacity-90 mx-auto" style="max-width: 600px;">Nikmati perpaduan rasa yang kaya dan aroma yang memikat dalam setiap cangkir, diseduh khusus untuk menemani setiap momen spesial Anda.</p>
    </div>
</div>

<!-- Konten Utama: Tabs & Cards -->
<main class="container mb-5">

    @php
        $categories = $menus->map(function($m){ return $m->kategori?->nama ?? 'Lainnya'; })->unique()->values();
    @endphp

    <!-- Tab Kategori (dibuat dari database) -->
    <ul class="nav nav-pills justify-content-center mb-5 gap-2" id="pills-tab" role="tablist">
        @foreach($categories as $i => $cat)
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $i===0 ? 'active' : '' }}" id="pills-{{ \Illuminate\Support\Str::slug($cat) }}-tab" data-bs-toggle="pill" data-bs-target="#pills-{{ \Illuminate\Support\Str::slug($cat) }}" type="button" role="tab">
                    {{ $cat }}
                </button>
            </li>
        @endforeach
    </ul>

    <div class="tab-content" id="pills-tabContent">
        @foreach($categories as $i => $cat)
            <div class="tab-pane fade {{ $i===0 ? 'show active' : '' }}" id="pills-{{ \Illuminate\Support\Str::slug($cat) }}" role="tabpanel">
                <div class="row g-4">
                    @foreach($menus->filter(function($m) use($cat){ return ($m->kategori?->nama ?? 'Lainnya') === $cat; }) as $menu)
                        <div class="col-lg-4 col-md-6">
                            <div class="menu-card">
                                <img src="{{ $menu->gambar && file_exists(public_path('uploads/menus/' . $menu->gambar)) ? asset('uploads/menus/' . $menu->gambar) : 'https://via.placeholder.com/600x400?text=No+Image' }}" 
     alt="{{ $menu->nama }}" 
     class="menu-img">
                                <div class="menu-content">
                                    <h4 class="fw-bold mb-2">{{ $menu->nama }}</h4>
                                    <p class="text-muted mb-4 small">{{ $menu->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <span class="menu-price">Rp {{ number_format($menu->harga,0,',','.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <div class="text-center mt-5 mb-3 p-5 rounded-4 shadow-sm" style="background: linear-gradient(135deg, rgba(253, 251, 247, 1) 0%, rgba(212, 181, 157, 0.2) 100%); border: 1px solid rgba(92, 61, 46, 0.1);">
        <div class="mb-3">
            <i class="bi bi-geo-alt-fill fs-1 text-kopi"></i>
        </div>
        <h3 class="fw-bold mb-3">Ingin Menikmati Kopi Langsung di Tempat?</h3>
        <p class="text-muted mx-auto" style="max-width: 500px;">Rasakan suasana nyaman dan hangat hanya di Roastory.</p>
        <a href="{{ url('/reservasi') }}" class="btn btn-kopi mt-3 fw-bold px-5 py-3 rounded-pill btn-lg shadow-sm">
            Mulai Reservasi Meja <i class="bi bi-arrow-right ms-2"></i>
        </a>
    </div>

    </main>
@endsection
