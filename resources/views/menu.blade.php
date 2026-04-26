@extends('layouts.app')

@section('title', 'Katalog Menu | Kopi Kenangan Kita')

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
        <p class="lead opacity-90 mx-auto" style="max-width: 600px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>
</div>

<!-- Konten Utama: Tabs & Cards -->
<main class="container mb-5">

    <!-- Tab Kategori -->
    <ul class="nav nav-pills justify-content-center mb-5 gap-2" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-kopi-tab" data-bs-toggle="pill" data-bs-target="#pills-kopi" type="button" role="tab">
                <i class="bi bi-cup-hot me-2"></i> Base Kopi
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-nonkopi-tab" data-bs-toggle="pill" data-bs-target="#pills-nonkopi" type="button" role="tab">
                <i class="bi bi-cup-straw me-2"></i> Non-Kopi
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-makanan-tab" data-bs-toggle="pill" data-bs-target="#pills-makanan" type="button" role="tab">
                <i class="bi bi-cake2 me-2"></i> Makanan
            </button>
        </li>
    </ul>

    <!-- Isi Konten Berdasarkan Tab -->
    <div class="tab-content" id="pills-tabContent">

        <!-- Tab Kategori Kopi -->
        <div class="tab-pane fade show active" id="pills-kopi" role="tabpanel">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="menu-card">
                        <img src="https://images.unsplash.com/photo-1572442388796-11668a67e53d?ixlib=rb-4.0.3&w=600&q=80" alt="Espresso" class="menu-img">
                        <div class="menu-content">
                            <h4 class="fw-bold mb-2">Classic Espresso</h4>
                            <p class="text-muted mb-4 small">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="menu-price">Rp 18.000</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="menu-card">
                        <img src="https://images.unsplash.com/photo-1541167760496-1628856ab772?ixlib=rb-4.0.3&w=600&q=80" alt="Cappuccino" class="menu-img">
                        <div class="menu-content">
                            <h4 class="fw-bold mb-2">Cappuccino Hangat</h4>
                            <p class="text-muted mb-4 small">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="menu-price">Rp 26.000</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="menu-card border border-warning" style="box-shadow: 0 0 0 1px #ffc107;">
                        <img src="https://images.unsplash.com/photo-1559525839-b184a4d698c7?ixlib=rb-4.0.3&w=600&q=80" alt="Kopi Susu Gula Aren" class="menu-img">
                        <div class="menu-content">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h4 class="fw-bold mb-0">Kopsus Kenangan</h4>
                                <span class="badge bg-warning text-dark rounded-pill py-2 px-3 fw-bold"><i class="bi bi-star-fill me-1"></i> Terlaris</span>
                            </div>
                            <p class="text-muted mb-4 small">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="menu-price">Rp 24.000</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Kategori Non Kopi -->
        <div class="tab-pane fade" id="pills-nonkopi" role="tabpanel">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="menu-card">
                        <img src="https://images.unsplash.com/photo-1536935338788-846bb9981813?ixlib=rb-4.0.3&w=600&q=80" alt="Matcha" class="menu-img">
                        <div class="menu-content">
                            <h4 class="fw-bold mb-2">Matcha Sakura Latte</h4>
                            <p class="text-muted mb-4 small">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="menu-price">Rp 28.000</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="menu-card">
                        <img src="https://images.unsplash.com/photo-1579954115545-a95e78619bc9?ixlib=rb-4.0.3&w=600&q=80" alt="Choco Latte" class="menu-img">
                        <div class="menu-content">
                            <h4 class="fw-bold mb-2">Belgian Chocolate</h4>
                            <p class="text-muted mb-4 small">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="menu-price">Rp 25.000</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Kategori Makanan -->
        <div class="tab-pane fade" id="pills-makanan" role="tabpanel">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="menu-card">
                        <img src="https://images.unsplash.com/photo-1509365465985-25d11c17e812?ixlib=rb-4.0.3&w=600&q=80" alt="Croissant" class="menu-img">
                        <div class="menu-content">
                            <h4 class="fw-bold mb-2">Butter Croissant</h4>
                            <p class="text-muted mb-4 small">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="menu-price">Rp 20.000</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="menu-card">
                        <img src="https://images.unsplash.com/photo-1621236378699-859efab60411?ixlib=rb-4.0.3&w=600&q=80" alt="Brownies" class="menu-img">
                        <div class="menu-content">
                            <h4 class="fw-bold mb-2">Fudgy Brownies</h4>
                            <p class="text-muted mb-4 small">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="menu-price">Rp 18.000</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5 mb-3 p-5 rounded-4 shadow-sm" style="background: linear-gradient(135deg, rgba(253, 251, 247, 1) 0%, rgba(212, 181, 157, 0.2) 100%); border: 1px solid rgba(92, 61, 46, 0.1);">
        <div class="mb-3">
            <i class="bi bi-geo-alt-fill fs-1 text-kopi"></i>
        </div>
        <h3 class="fw-bold mb-3">Ingin Menikmati Kopi Langsung di Tempat?</h3>
        <p class="text-muted mx-auto" style="max-width: 500px;">Rasakan suasana nyaman dan hangat hanya di Kopi Kenangan Kita.</p>
        <a href="{{ url('/reservasi') }}" class="btn btn-kopi mt-3 fw-bold px-5 py-3 rounded-pill btn-lg shadow-sm">
            Mulai Reservasi Meja <i class="bi bi-arrow-right ms-2"></i>
        </a>
    </div>

</main>
@endsection
