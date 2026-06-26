@extends('layouts.app')

@section('title', 'Tentang Kami | Roastory')

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
<div class="page-header mb-5">
    <div class="container header-content">
        <h1 class="display-4 fw-bold mb-3">Tentang Kami</h1>
        <p class="lead opacity-75 mx-auto" style="max-width: 600px;">Menyajikan cerita dalam setiap tegukan, menghadirkan kehangatan, inspirasi, dan kebersamaan di setiap cangkir.</p>
    </div>
</div>

<!-- Konten Utama -->
<main class="container mb-5">

    <div class="row align-items-center mb-5 g-5">
        <div class="col-md-6 mb-4 mb-md-0 position-relative">
            <div class="position-absolute w-100 h-100 bg-kopi rounded-4 shadow-sm" style="top: -15px; left: -15px; z-index: 0; opacity: 0.2;"></div>
            <img src="https://images.unsplash.com/photo-1511920170033-f8396924c348?ixlib=rb-4.0.3&w=800&q=80&auto=format&fit=crop"
                alt="Suasana Cafe" class="img-fluid rounded-4 shadow-lg position-relative" style="z-index: 1;">
        </div>
        <div class="col-md-6 ps-md-5">
            <h3 class="fw-bold text-kopi mb-3">Cerita di Balik Roastory</h3>
            <p class="text-secondary" style="line-height: 1.8;">Selamat datang di Roastory, tempat di mana setiap cangkir kopi memiliki cerita. Kami percaya bahwa kopi bukan sekadar minuman, tetapi juga pengalaman yang menghadirkan kehangatan, inspirasi, dan kebersamaan.</p>
            <p class="text-secondary" style="line-height: 1.8;">Roastory hadir dengan pilihan biji kopi berkualitas yang diproses dengan penuh perhatian untuk menghasilkan cita rasa terbaik. Dari aroma yang khas hingga rasa yang autentik, setiap seduhan kami dibuat untuk menemani setiap momen berharga Anda.</p>
            <p class="text-secondary" style="line-height: 1.8;">Bagi kami, setiap biji kopi memiliki perjalanan, setiap proses roasting memiliki makna, dan setiap pelanggan menjadi bagian dari cerita itu. Karena di Roastory, kami tidak hanya menyajikan kopi &mdash; kami menyajikan cerita dalam setiap tegukan.</p>
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
                <p class="text-muted mb-0">Biji kopi pilihan yang diproses dengan standar tinggi untuk menghasilkan aroma dan rasa yang sempurna di setiap cangkir.</p>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="bi bi-emoji-smile"></i>
                </div>
                <h4 class="fw-bold mb-3">Kenyamanan Ramah</h4>
                <p class="text-muted mb-0">Suasana tempat yang hangat dan pelayanan sepenuh hati, membuat Anda selalu merasa seperti di rumah sendiri.</p>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="bi bi-lightbulb"></i>
                </div>
                <h4 class="fw-bold mb-3">Inovasi Rasa</h4>
                <p class="text-muted mb-0">Terus berkreasi menciptakan varian menu baru yang unik tanpa meninggalkan cita rasa kopi autentik yang Anda cintai.</p>
            </div>
        </div>
    </div>

    <!-- Peta Lokasi Section -->
    <div class="mt-5 pt-5 pb-3 border-top">
        <div class="row align-items-center g-5">
            <div class="col-md-5">
                <span class="badge bg-kopi text-white mb-2 px-3 py-2 rounded-pill shadow-sm">Kunjungi Kami</span>
                <h3 class="fw-bold text-kopi mb-4">Lokasi Kami</h3>
                <p class="text-secondary mb-4">Kami dengan senang hati menyambut Anda. Mampirlah untuk menikmati seduhan terbaik dalam suasana yang nyaman dan hangat.</p>
                
                <ul class="list-unstyled">
                    <li class="d-flex align-items-start mb-3">
                        <div class="feature-icon-wrapper" style="width: 45px; height: 45px; font-size: 1.2rem; margin: 0 15px 0 0;">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Alamat</h6>
                            <p class="text-muted small mb-0">Jl. Sudirman No 123, Kota Kopi</p>
                        </div>
                    </li>
                    <li class="d-flex align-items-start mb-3">
                        <div class="feature-icon-wrapper" style="width: 45px; height: 45px; font-size: 1.2rem; margin: 0 15px 0 0;">
                            <i class="bi bi-clock-fill"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Jam Operasional</h6>
                            <p class="text-muted small mb-0">Setiap Hari: 08.00 - 23.00 WIB</p>
                        </div>
                    </li>
                    <li class="d-flex align-items-start mb-3">
                        <div class="feature-icon-wrapper" style="width: 45px; height: 45px; font-size: 1.2rem; margin: 0 15px 0 0;">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Kontak</h6>
                            <p class="text-muted small mb-0">+62 812 3456 7890</p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-md-7">
                <div class="rounded-4 shadow-lg overflow-hidden position-relative" style="height: 400px; background-color: var(--bg-warm);">
                    <div id="about-gmaps-container" class="w-100 h-100">
                        <div class="d-flex align-items-center justify-content-center h-100 text-secondary">
                            <div class="text-center">
                                <div class="spinner-border text-kopi mb-3" role="status"></div>
                                <div>Memuat peta interaktif...</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fetch Google Maps Embed URL from API (Distributed System Approach)
    fetch('/api/location')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('about-gmaps-container');
            if(data.success && data.embed_url) {
                container.innerHTML = `<iframe src="${data.embed_url}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>`;
            } else {
                container.innerHTML = `<div class="d-flex align-items-center justify-content-center h-100 text-secondary"><i class="bi bi-exclamation-triangle me-2"></i> Peta tidak tersedia</div>`;
            }
        })
        .catch(error => {
            console.error('Error fetching location:', error);
            document.getElementById('about-gmaps-container').innerHTML = `<div class="d-flex align-items-center justify-content-center h-100 text-secondary"><i class="bi bi-x-circle me-2"></i> Gagal memuat peta</div>`;
        });
});
</script>
@endpush
@endsection
