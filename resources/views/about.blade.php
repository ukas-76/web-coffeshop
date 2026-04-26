@extends('layouts.app')

@section('title', 'Tentang Kami | Kopi Kenangan Kita')

@push('styles')
<style>
/* General Header */
.page-header {
    background: linear-gradient(135deg, var(--primary-coffee) 0%, var(--accent-coffee) 100%);
    color: white;
    padding: 80px 0;
    text-align: center;
    border-radius: 0 0 40px 40px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(92, 61, 46, 0.15);
}
.page-header::after {
    content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%); z-index: 0;
}
.header-content { position: relative; z-index: 1; }

/* Feature Card */
.feature-card {
    background: white; border-radius: 24px; padding: 2.5rem 2rem; height: 100%;
    border: 1px solid rgba(0,0,0,0.05); transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 10px 30px rgba(0,0,0,0.02);
}
.feature-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(92, 61, 46, 0.08); }
.feature-icon-wrapper {
    width: 70px; height: 70px; background-color: var(--bg-warm); border-radius: 50%;
    display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;
    color: var(--primary-coffee); font-size: 2rem; transition: all 0.3s ease;
}
.feature-card:hover .feature-icon-wrapper { background-color: var(--primary-coffee); color: white; transform: scale(1.1); }
</style>
@endpush

@section('content')
<!-- Header Halaman -->
<div class="page-header mb-5" style="margin-top: 76px;">
    <div class="container header-content">
        <h1 class="display-4 fw-bold mb-3">Tentang Kami</h1>
        <p class="lead opacity-75 mx-auto" style="max-width: 600px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>
</div>

<!-- Konten Utama -->
<main class="container mb-5">

    <div class="row align-items-center mb-5 g-5">
        <div class="col-md-6 mb-4 mb-md-0 position-relative">
            <div class="position-absolute w-100 h-100 bg-kopi rounded-4 shadow-sm" style="top: -15px; left: -15px; z-index: 0; opacity: 0.2;"></div>
            <img src="https://images.unsplash.com/photo-1511920170033-f8396924c348?ixlib=rb-4.0.3&w=800&q=80"
                alt="Suasana Cafe" class="img-fluid rounded-4 shadow-lg position-relative" style="z-index: 1;">
        </div>
        <div class="col-md-6 ps-md-5">
            <h3 class="fw-bold text-kopi mb-3">Berawal dari Mimpi Kecil</h3>
            <p class="text-secondary" style="line-height: 1.8;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
            <p class="text-secondary" style="line-height: 1.8;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
        </div>
    </div>

    <div class="text-center mt-5 mb-5 pt-4">
        <span class="badge bg-kopi text-white mb-2 px-3 py-2 rounded-pill shadow-sm">Filosofi</span>
        <h2 class="fw-bold text-kopi">Nilai Inti Kami</h2>
        <div class="mt-3 mb-4 mx-auto" style="width: 60px; height: 4px; background-color: var(--secondary-coffee); border-radius: 2px;"></div>
    </div>
    
    <div class="row g-4 text-center justify-content-center">
        <div class="col-lg-4 col-md-6">
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="bi bi-tree"></i>
                </div>
                <h4 class="fw-bold mb-3">Kualitas Terbaik</h4>
                <p class="text-muted mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="bi bi-emoji-smile"></i>
                </div>
                <h4 class="fw-bold mb-3">Kenyamanan Ramah</h4>
                <p class="text-muted mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="bi bi-lightbulb"></i>
                </div>
                <h4 class="fw-bold mb-3">Inovasi Rasa</h4>
                <p class="text-muted mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
        </div>
    </div>

</main>
@endsection
