@extends('layouts.admin')

@section('title', 'Katalog Menu | Portal Admin')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0">Manajemen Katalog Menu</h3>
        <p class="text-muted mb-0 small">Tambah, edit, dan hapus menu yang tersedia di sistem.</p>
    </div>
    <div class="d-flex gap-2">
        <select class="form-select bg-dark text-white border-0 shadow-none" style="border: 1px solid var(--border-color) !important; width: auto;">
            <option value="all">Semua Kategori</option>
            <option value="kopi">Kopi</option>
            <option value="non-kopi">Non-Kopi</option>
            <option value="makanan">Makanan</option>
        </select>
        <button class="btn btn-admin btn-sm px-3 rounded-pill text-nowrap"><i class="bi bi-plus-circle me-1"></i> Tambah Menu Baru</button>
    </div>
</div>

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
                <tr>
                    <td>
                        <img src="https://images.unsplash.com/photo-1541167760496-1628856ab772?auto=format&fit=crop&w=80&q=80" class="rounded" alt="Kopi Kenangan Mantan" style="width: 50px; height: 50px; object-fit: cover;">
                    </td>
                    <td>
                        <div class="fw-bold text-white">Kopi Kenangan Mantan</div>
                        <div class="small text-muted text-truncate" style="max-width: 250px;">Espresso block, susu, gula aren asli.</div>
                    </td>
                    <td><span class="badge bg-dark text-light border border-secondary">Kopi</span></td>
                    <td class="fw-bold text-white">Rp 25.000</td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" checked style="background-color: var(--admin-accent); border-color: var(--admin-accent);">
                            <label class="form-check-label text-white small" for="flexSwitchCheckChecked">Tersedia</label>
                        </div>
                    </td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-outline-danger ms-1" title="Hapus"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <img src="https://images.unsplash.com/photo-1559525839-b184a4d698c7?auto=format&fit=crop&w=80&q=80" class="rounded" alt="Caramel Macchiato" style="width: 50px; height: 50px; object-fit: cover;">
                    </td>
                    <td>
                        <div class="fw-bold text-white">Caramel Macchiato</div>
                        <div class="small text-muted text-truncate" style="max-width: 250px;">Kopi, vanilla, susu, saus karamel lezat.</div>
                    </td>
                    <td><span class="badge bg-dark text-light border border-secondary">Kopi</span></td>
                    <td class="fw-bold text-white">Rp 32.000</td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input bg-secondary border-secondary" type="checkbox" role="switch">
                            <label class="form-check-label text-muted small">Habis</label>
                        </div>
                    </td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-outline-danger ms-1" title="Hapus"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <img src="https://images.unsplash.com/photo-1572442388796-11668a67e53d?auto=format&fit=crop&w=80&q=80" class="rounded" alt="Matcha Latte" style="width: 50px; height: 50px; object-fit: cover;">
                    </td>
                    <td>
                        <div class="fw-bold text-white">Premium Matcha Latte</div>
                        <div class="small text-muted text-truncate" style="max-width: 250px;">Bubuk matcha kyoto, susu segar premium.</div>
                    </td>
                    <td><span class="badge bg-dark text-light border border-secondary">Non-Kopi</span></td>
                    <td class="fw-bold text-white">Rp 28.000</td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" checked style="background-color: var(--admin-accent); border-color: var(--admin-accent);">
                            <label class="form-check-label text-white small" for="flexSwitchCheckChecked">Tersedia</label>
                        </div>
                    </td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-outline-danger ms-1" title="Hapus"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <img src="https://images.unsplash.com/photo-1550461716-1f016d9ba2dc?auto=format&fit=crop&w=80&q=80" class="rounded" alt="Croissant" style="width: 50px; height: 50px; object-fit: cover;">
                    </td>
                    <td>
                        <div class="fw-bold text-white">Butter Croissant</div>
                        <div class="small text-muted text-truncate" style="max-width: 250px;">Croissant mentega dari adonan berlapis khas Prancis.</div>
                    </td>
                    <td><span class="badge bg-dark text-light border border-secondary">Makanan</span></td>
                    <td class="fw-bold text-white">Rp 20.000</td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" checked style="background-color: var(--admin-accent); border-color: var(--admin-accent);">
                            <label class="form-check-label text-white small" for="flexSwitchCheckChecked">Tersedia</label>
                        </div>
                    </td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-outline-danger ms-1" title="Hapus"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-4 pt-3 border-top text-center" style="border-color: var(--border-color) !important;">
        <button class="btn btn-sm btn-outline-secondary">Muat Lebih Banyak...</button>
    </div>
</div>
@endsection
