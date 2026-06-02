@extends('layouts.admin')

@section('title', 'Katalog Menu | Portal Admin')

@push('admin_styles')
<style>
    :root {
        --text-muted: rgba(255, 255, 255, 0.85) !important;
        --border-color: rgba(255, 255, 255, 0.1) !important;
    }
    
    body {
        color: rgba(255, 255, 255, 0.95) !important;
    }
    
    .table-dark {
        color: rgba(255, 255, 255, 0.95) !important;
    }
</style>
@endpush

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0">Manajemen Katalog Menu</h3>
        <p class="text-muted mb-0 small">Tambah, edit, dan hapus menu yang tersedia di sistem.</p>
    </div>
    <div class="d-flex gap-2">
        <select id="filterKategori" class="form-select bg-dark text-white border-0 shadow-none" style="border: 1px solid var(--border-color) !important; width: auto;">
            <option value="all">Semua Kategori</option>
            @foreach($dataKategori as $kat)
                <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
            @endforeach
        </select>
        <button class="btn btn-admin btn-sm px-3 rounded-pill text-nowrap" data-bs-toggle="modal" data-bs-target="#tambahMenuModal">
            <i class="bi bi-plus-circle me-1"></i> Tambah Menu Baru
        </button>
    </div>
</div>

{{-- Blok Error Validasi --}}
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Blok Notifikasi Sukses --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" style="background-color: rgba(25, 135, 84, 0.25); color: #51dd9f;" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 80px;">Gambar</th>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Status Ketersediaan</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dataMenu as $menu)
                <tr class="baris-menu" data-kategori-id="{{ $menu->kategori_menu_id }}">
                    <td>
                        @if($menu->gambar)
                            <img src="{{ asset('uploads/menus/' . $menu->gambar) }}" class="rounded" alt="{{ $menu->nama }}" style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                            <img src="https://placehold.co/50x50/2d2420/d4b59d?text=Kopi" class="rounded" alt="No Image" style="width: 50px; height: 50px; object-fit: cover;">
                        @endif
                    </td>
                    <td>
                        <div class="fw-bold text-white">{{ $menu->nama }}</div>
                        <div class="small text-muted text-truncate" style="max-width: 250px;">{{ $menu->deskripsi }}</div>
                    </td>
                    <td><span class="badge bg-dark text-light border border-secondary">{{ $menu->kategori->nama ?? 'Umum' }}</span></td>
                    <td class="fw-bold text-white">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" {{ $menu->tersedia ? 'checked' : '' }} disabled style="{{ $menu->tersedia ? 'background-color: #51dd9f; border-color: #51dd9f;' : '' }}">
                            <label class="form-check-label text-{{ $menu->tersedia ? 'white' : 'muted' }} small">
                                {{ $menu->tersedia ? 'Tersedia' : 'Habis' }}
                            </label>
                        </div>
                    </td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editMenuModal{{ $menu->id }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="/admin/menus/{{ $menu->id }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus menu {{ $menu->nama }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger ms-1"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Belum ada data menu.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="tambahMenuModal" tabindex="-1" aria-hidden="true" data-bs-theme="dark">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: var(--admin-card); border: 1px solid var(--border-color);">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold text-white">Tambah Menu Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="/admin/menus" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-white small">Nama Menu</label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" name="nama" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white small">Kategori</label>
                            <select class="form-select bg-dark text-white border-secondary" name="kategori_menu_id" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach($dataKategori as $kat)
                                    <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white small">Harga (Rp)</label>
                            <input type="number" class="form-control bg-dark text-white border-secondary" name="harga" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white small">Gambar</label>
                        <input type="file" class="form-control bg-dark text-white border-secondary" name="gambar" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white small">Deskripsi</label>
                        <textarea class="form-control bg-dark text-white border-secondary" name="deskripsi" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white small">Status</label>
                        <select class="form-select bg-dark text-white border-secondary" name="tersedia" required>
                            <option value="1">Tersedia</option>
                            <option value="0">Habis</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-admin">Simpan Menu</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
@foreach($dataMenu as $menu)
<div class="modal fade" id="editMenuModal{{ $menu->id }}" tabindex="-1" aria-hidden="true" data-bs-theme="dark">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: var(--admin-card); border: 1px solid var(--border-color);">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold text-white">Edit Menu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="/admin/menus/{{ $menu->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-white small">Nama Menu</label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" name="nama" value="{{ $menu->nama }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white small">Kategori</label>
                            <select class="form-select bg-dark text-white border-secondary" name="kategori_menu_id" required>
                                @foreach($dataKategori as $kat)
                                    <option value="{{ $kat->id }}" {{ $menu->kategori_menu_id == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white small">Harga (Rp)</label>
                            <input type="number" class="form-control bg-dark text-white border-secondary" name="harga" value="{{ $menu->harga }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white small">Ganti Gambar (Opsional)</label>
                        <input type="file" class="form-control bg-dark text-white border-secondary" name="gambar" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white small">Deskripsi</label>
                        <textarea class="form-control bg-dark text-white border-secondary" name="deskripsi" rows="2">{{ $menu->deskripsi }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white small">Status</label>
                        <select class="form-select bg-dark text-white border-secondary" name="tersedia" required>
                            <option value="1" {{ $menu->tersedia == 1 ? 'selected' : '' }}>Tersedia</option>
                            <option value="0" {{ $menu->tersedia == 0 ? 'selected' : '' }}>Habis</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-admin">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@push('admin_scripts')
<script>
    document.getElementById('filterKategori').addEventListener('change', function() {
        let selectedId = this.value;
        let rows = document.querySelectorAll('.baris-menu');
        rows.forEach(row => {
            let rowId = row.getAttribute('data-kategori-id');
            row.style.display = (selectedId === 'all' || selectedId === rowId) ? '' : 'none';
        });
    });
</script>
@endpush
@endsection