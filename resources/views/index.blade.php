@extends('layouts.app')

@section('title', 'Roastory | Beranda')

@push('styles')
<style>
/* Hero Section */
.hero-carousel {
    height: 85vh;
    min-height: 600px;
    border-radius: 0 0 40px 40px;
    overflow: hidden;
    position: relative;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    margin-bottom: 4rem;
}

.hero-item {
    height: 100%;
    background-size: cover;
    background-position: center;
    position: relative;
}

.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to right, rgba(45, 36, 32, 0.9) 0%, rgba(45, 36, 32, 0.4) 100%);
}

.hero-content {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 0;
    right: 0;
    z-index: 2;
}

.hero-title {
    font-weight: 800;
    letter-spacing: -1px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    margin-bottom: 1.5rem;
}

.carousel-control-prev,
.carousel-control-next {
    z-index: 10;
}

.hero-subtitle {
    font-size: 1.25rem;
    font-weight: 400;
    opacity: 0.9;
    max-width: 600px;
    margin-bottom: 2rem;
    line-height: 1.6;
}

/* Features */
.section-title {
    font-weight: 800;
    color: var(--primary-coffee);
    margin-bottom: 3rem;
    position: relative;
    display: inline-block;
    letter-spacing: -0.5px;
}

.section-title::after {
    content: '';
    position: absolute;
    width: 50%;
    height: 4px;
    background-color: var(--secondary-coffee);
    bottom: -10px;
    left: 25%;
    border-radius: 2px;
}

.feature-card {
    background: white;
    border-radius: 24px;
    padding: 2.5rem 2rem;
    height: 100%;
    border: 1px solid rgba(0,0,0,0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 10px 30px rgba(0,0,0,0.02);
    position: relative;
    z-index: 1;
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0; 
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, white 0%, var(--bg-warm) 100%);
    border-radius: 24px;
    z-index: -1;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(92, 61, 46, 0.08);
}

.feature-card:hover::before {
    opacity: 1;
}

.feature-icon-wrapper {
    width: 70px;
    height: 70px;
    background-color: var(--bg-warm);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: var(--primary-coffee);
    font-size: 2rem;
    transition: all 0.3s ease;
}

.feature-card:hover .feature-icon-wrapper {
    background-color: var(--primary-coffee);
    color: white;
    transform: scale(1.1);
}

/* Call to Action */
.cta-section {
    background: linear-gradient(135deg, var(--primary-coffee) 0%, var(--accent-coffee) 100%);
    border-radius: 30px;
    padding: 4rem 2rem;
    color: white;
    text-align: center;
    margin-top: 5rem;
    box-shadow: 0 20px 40px rgba(92, 61, 46, 0.2);
    position: relative;
    overflow: hidden;
}

.cta-section::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
    z-index: 0;
}

.cta-content {
    position: relative;
    z-index: 1;
}
</style>
@endpush

@section('content')
<div>
    <!-- Hero Section Bergeser / Carousel -->
    <div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <div class="carousel-inner h-100">
            <!-- Slide 1 -->
            <div class="carousel-item active h-100">
                <div class="hero-item" style="background-image: url('https://images.unsplash.com/photo-1497935586351-b67a49e012bf?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');">
                    <div class="hero-overlay"></div>
                </div>
                <div class="hero-content">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 text-white">
                                <span class="badge bg-kopi-light mb-3 px-3 py-2 rounded-pill shadow-sm">Kopi Asli Nusantara</span>
                                <h1 class="display-3 hero-title">Harmoni Rasa dalam<br>Setiap Sesapan</h1>
                                <p class="hero-subtitle">Nikmati perpaduan rasa yang kaya dan aroma yang memikat dalam setiap cangkir, diseduh khusus untuk menemani setiap momen spesial Anda.</p>
                                <div class="d-flex flex-wrap gap-3">
                                    <a href="{{ url('/reservasi') }}" class="btn btn-light text-kopi btn-lg px-4 py-3 rounded-pill fw-bold shadow">
                                        <i class="bi bi-calendar-check me-2"></i> Pesan Meja
                                    </a>
                                    <a href="{{ url('/menu') }}" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill fw-bold">
                                        Lihat Menu <i class="bi bi-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item h-100">
                <div class="hero-item" style="background-image: url('https://images.unsplash.com/photo-1554118811-1e0d58224f24?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');">
                    <div class="hero-overlay"></div>
                </div>
                <div class="hero-content">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 text-white">
                                <span class="badge bg-kopi-light mb-3 px-3 py-2 rounded-pill shadow-sm">Suasana Nyaman</span>
                                <h1 class="display-3 hero-title">Estetika Maksimal<br>Setiap Sudutnya</h1>
                                <p class="hero-subtitle">Dapatkan potongan harga spesial hingga 50% untuk semua varian kopi espresso-based setiap hari kerja pukul 14.00 - 17.00 WIB.</p>
                                <div class="d-flex flex-wrap gap-3">
                                    <a href="{{ url('/about') }}" class="btn btn-light text-kopi btn-lg px-4 py-3 rounded-pill fw-bold shadow">
                                        Kenali Kami Lebih Dekat <i class="bi bi-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item h-100">
                <div class="hero-item" style="background-image: url('https://images.unsplash.com/photo-1600093463592-8e36ae95ef56?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');">
                    <div class="hero-overlay"></div>
                </div>
                <div class="hero-content">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 text-white">
                                <span class="badge bg-kopi-light mb-3 px-3 py-2 rounded-pill shadow-sm">Keahlian Barista</span>
                                <h1 class="display-3 hero-title">Karya Tangan<br>Penuh Ketelitian</h1>
                                <p class="hero-subtitle">Nikmati malam minggu yang syahdu dengan iringan live music akustik lokal terbaik sambil menyeruput secangkir kopi favorit Anda.</p>
                                <div class="d-flex flex-wrap gap-3">
                                    <a href="{{ url('/menu') }}" class="btn btn-light text-kopi btn-lg px-4 py-3 rounded-pill fw-bold shadow">
                                        Jelajahi Rasa <i class="bi bi-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true" style="width: 3rem; height: 3rem;"></span>
            <span class="visually-hidden">Sebelumnya</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true" style="width: 3rem; height: 3rem;"></span>
            <span class="visually-hidden">Selanjutnya</span>
        </button>
    </div>

    <div class="container mb-5">
        <!-- Section Header -->
        <div class="text-center mb-5">
            <h2 class="section-title h1">Promo & Event Terkini</h2>
            <p class="text-muted lead mx-auto mt-3" style="max-width: 600px;">Nikmati perpaduan rasa yang kaya dan aroma yang memikat dalam setiap cangkir, diseduh khusus untuk menemani setiap momen spesial Anda.</p>
        </div>

        <!-- Promo & Event Grid -->
        <!-- Promo & Event Grid Dinamis -->
<div class="row g-4 justify-content-center">
    
    <!-- LOOPING DATA PROMO -->
    @foreach($promos as $promo)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 rounded-4 shadow-sm overflow-hidden">
            <img src="{{ $promo->gambar ? asset('uploads/promo/' . $promo->gambar) : 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}" class="card-img-top" alt="{{ $promo->judul }}" style="height: 220px; object-fit: cover;">
            <div class="card-body p-4 position-relative bg-white pt-5">
                <span class="badge bg-danger rounded-pill px-3 py-2 position-absolute shadow-sm" style="top: -15px; left: 24px; font-size: 0.85rem;">
                    <i class="bi bi-clock me-1"></i> {{ $promo->badge_teks }}
                </span>
                <h4 class="fw-bold text-dark mb-2">{{ $promo->judul }}</h4>
                <p class="text-muted small mb-4">{{ $promo->deskripsi }}</p>
                <a href="{{ url($promo->link_aksi) }}" class="btn btn-outline-kopi rounded-pill fw-bold w-100">Klaim Promo <i class="bi bi-ticket-perforated ms-1"></i></a>
            </div>
        </div>
    </div>
    @endforeach

    <!-- LOOPING DATA EVENT -->
    @foreach($events as $event)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 rounded-4 shadow-sm overflow-hidden">
            <img src="{{ $event->gambar ? asset('uploads/event/' . $event->gambar) : 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}" class="card-img-top" alt="{{ $event->judul }}" style="height: 220px; object-fit: cover;">
            <div class="card-body p-4 position-relative bg-white pt-5">
                <span class="badge bg-kopi rounded-pill px-3 py-2 position-absolute shadow-sm" style="top: -15px; left: 24px; font-size: 0.85rem;">
                    <i class="bi bi-calendar-event me-1"></i> {{ $event->badge_teks }}
                </span>
                <h4 class="fw-bold text-dark mb-2">{{ $event->judul }}</h4>
                <p class="text-muted small mb-4">{{ $event->deskripsi }}</p>
                <a href="{{ url($event->link_aksi) }}" class="btn btn-outline-kopi rounded-pill fw-bold w-100">Reservasi Meja <i class="bi bi-calendar-check ms-1"></i></a>
            </div>
        </div>
    </div>
    @endforeach

    <!-- TAMPILAN JIKA DATABASE KOSONG -->
    @if($promos->isEmpty() && $events->isEmpty())
        <div class="col-12 text-center py-5">
            <p class="text-muted lead">Belum ada promo atau event aktif saat ini. Pantau terus ya!</p>
        </div>
    @endif

</div>

        <!-- CTA Section -->
        <div class="cta-section mx-auto" style="max-width: 900px;">
            <div class="cta-content">
                <h2 class="fw-bold h1 mb-3">Siap Menikmati Seduhan Kami?</h2>
                <p class="lead mb-4 opacity-75">Nikmati perpaduan rasa yang kaya dan aroma yang memikat dalam setiap cangkir, diseduh khusus untuk menemani setiap momen spesial Anda.</p>
                <a href="{{ url('/menu') }}" class="btn btn-light text-kopi btn-lg px-5 py-3 rounded-pill fw-bold shadow-sm">
                    Menuju Katalog Menu <i class="bi bi-book ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
