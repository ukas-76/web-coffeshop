@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan | Kopi Kenangan Kita')

@push('styles')
<style>
.error-page-container {
    min-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    margin-top: 50px;
}

.error-hero-icon {
    font-size: 8rem;
    color: var(--primary-coffee);
    margin-bottom: 20px;
    opacity: 0.8;
}

.error-title {
    font-size: 6rem;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 10px;
    letter-spacing: -2px;
}

.error-message {
    font-size: 1.25rem;
    color: #6c757d;
    max-width: 500px;
    margin: 0 auto 30px auto;
}

.btn-spilled {
    padding: 15px 40px;
    font-size: 1.1rem;
    border-radius: 50px;
}
</style>
@endpush

@section('content')
<main class="container error-page-container">
    <div>
        <div class="error-hero-icon">
            <i class="bi bi-cup-hot-fill"></i>
        </div>
        <h1 class="error-title">404</h1>
        <h3 class="fw-bold mb-3">Waduh, Kopinya Tumpah!</h3>
        <p class="error-message">
            Sepertinya halaman yang Anda cari pindah meja atau sudah tidak tersedia. Jangan khawatir, selalu ada kopi hangat menunggu di depan!
        </p>
        <a href="{{ url('/') }}" class="btn btn-kopi btn-spilled shadow-sm fw-bold">
            <i class="bi bi-house-door me-2"></i> Kembali ke Beranda
        </a>
    </div>
</main>
@endsection
