@extends('layouts.admin')

@section('title', 'Pengaturan | Portal Admin')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0">Pengaturan Sistem</h3>
        <p class="text-muted mb-0 small">Kelola konfigurasi global aplikasi Anda.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" style="background-color: rgba(25, 135, 84, 0.25); color: #51dd9f;" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="admin-card mb-4">
            <h5 class="fw-bold text-white mb-3 border-bottom border-secondary pb-2">Integrasi Google Maps</h5>
            <p class="text-muted small mb-4">Tempelkan (paste) tautan Embed URL dari Google Maps agar pelanggan dapat melihat lokasi kedai secara langsung di bagian footer halaman web.</p>
            
            <form action="{{ url('/admin/settings') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="form-label text-white small">Google Maps Embed URL</label>
                    <textarea class="form-control bg-dark text-white border-secondary" name="google_maps_embed_url" rows="4" required placeholder="https://www.google.com/maps/embed?pb=...">{{ old('google_maps_embed_url', $googleMapsUrl) }}</textarea>
                    <div class="form-text text-muted mt-2">
                        <i class="bi bi-info-circle"></i> Cara mendapatkan URL: Buka Google Maps > Cari Lokasi > Bagikan > Sematkan Peta (Embed a map) > Salin isi dari atribut <code>src="..."</code> saja.
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-admin px-4 py-2">
                        <i class="bi bi-save me-2"></i> Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="admin-card">
            <h5 class="fw-bold text-white mb-3">Pratinjau Peta Saat Ini</h5>
            @if($googleMapsUrl)
                <div class="ratio ratio-16x9 rounded overflow-hidden" style="border: 1px solid rgba(255,255,255,0.1);">
                    <iframe src="{{ $googleMapsUrl }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            @else
                <div class="d-flex align-items-center justify-content-center bg-dark rounded border border-secondary text-muted" style="height: 150px;">
                    Belum ada peta.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
