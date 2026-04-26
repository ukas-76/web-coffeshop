@extends('layouts.admin')

@section('title', 'Daftar Reservasi | Portal Admin')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0">Manajemen Reservasi</h3>
        <p class="text-muted mb-0 small">Kelola ketersediaan meja dan jadwal reservasi pengunjung.</p>
    </div>
    <div class="d-flex gap-2">
        <input type="date" class="form-control bg-dark text-white border-0 shadow-none" style="border: 1px solid var(--border-color) !important;">
        <button class="btn btn-admin btn-sm px-3 rounded-pill text-nowrap"><i class="bi bi-plus-lg me-1"></i> Buat Reservasi</button>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Summary Cards specific for Reservations -->
    <div class="col-md-4">
        <div class="admin-card p-3 d-flex align-items-center gap-3">
            <div class="icon-box info"><i class="bi bi-journal-check"></i></div>
            <div>
                <h6 class="text-muted text-uppercase small fw-bold mb-1">Total Reservasi Hari Ini</h6>
                <h4 class="fw-bold mb-0">12 Meja</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card p-3 d-flex align-items-center gap-3">
            <div class="icon-box warning"><i class="bi bi-clock-history"></i></div>
            <div>
                <h6 class="text-muted text-uppercase small fw-bold mb-1">Menunggu Kedatangan</h6>
                <h4 class="fw-bold mb-0">5 Meja</h4>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card p-3 d-flex align-items-center gap-3">
            <div class="icon-box success"><i class="bi bi-check2-circle"></i></div>
            <div>
                <h6 class="text-muted text-uppercase small fw-bold mb-1">Telah Hadir</h6>
                <h4 class="fw-bold mb-0">7 Meja</h4>
            </div>
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Waktu Reservasi</th>
                    <th>Pelanggan</th>
                    <th>Lokasi Meja</th>
                    <th>Pax</th>
                    <th>DP Dibayar</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="fw-bold text-white">18:00 - 20:00 WIB</div>
                        <div class="text-muted small">Selasa, 15 Nov</div>
                    </td>
                    <td>
                        <div class="fw-bold text-white">Bapak Rian</div>
                        <div class="small text-muted">+62 821-4321-8765</div>
                    </td>
                    <td class="text-white">Indoor Sofa Premium</td>
                    <td><i class="bi bi-people-fill text-muted me-1"></i> 4 Orang</td>
                    <td class="fw-bold text-success">Rp 100.000</td>
                    <td><span class="badge-status badge-pending">Menunggu</span></td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-success" title="Tandai Hadir"><i class="bi bi-check-lg"></i></button>
                        <button class="btn btn-sm btn-outline-admin ms-1"><i class="bi bi-eye"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fw-bold text-white">14:00 - 17:00 WIB</div>
                        <div class="text-muted small">Rabu, 16 Nov</div>
                    </td>
                    <td>
                        <div class="fw-bold text-white">Ibu Siska</div>
                        <div class="small text-muted">+62 899-7766-5544</div>
                    </td>
                    <td class="text-white">Garden Kanopi Besar</td>
                    <td><i class="bi bi-people-fill text-muted me-1"></i> 8 Orang</td>
                    <td class="fw-bold text-success">Rp 150.000</td>
                    <td><span class="badge-status badge-pending">Menunggu</span></td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-success" title="Tandai Hadir"><i class="bi bi-check-lg"></i></button>
                        <button class="btn btn-sm btn-outline-admin ms-1"><i class="bi bi-eye"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fw-bold text-white">10:00 - 12:00 WIB</div>
                        <div class="text-muted small">Rabu, 16 Nov</div>
                    </td>
                    <td>
                        <div class="fw-bold text-white">Kevin Pratama</div>
                        <div class="small text-muted">+62 877-1122-3344</div>
                    </td>
                    <td class="text-white">Indoor Dekat Kaca</td>
                    <td><i class="bi bi-people-fill text-muted me-1"></i> 2 Orang</td>
                    <td class="fw-bold text-success">Rp 50.000</td>
                    <td><span class="badge-status badge-completed">Hadir</span></td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-secondary" disabled><i class="bi bi-check-lg"></i></button>
                        <button class="btn btn-sm btn-outline-admin ms-1"><i class="bi bi-eye"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="fw-bold text-white">19:30 - 22:00 WIB</div>
                        <div class="text-muted small">Jumat, 18 Nov</div>
                    </td>
                    <td>
                        <div class="fw-bold text-white">Sarah Jelita</div>
                        <div class="small text-muted">+62 815-5544-3322</div>
                    </td>
                    <td class="text-white">Outdoor Balcony</td>
                    <td><i class="bi bi-people-fill text-muted me-1"></i> 4 Orang</td>
                    <td class="fw-bold text-success">Rp 100.000</td>
                    <td><span class="badge-status badge-pending">Menunggu</span></td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-success" title="Tandai Hadir"><i class="bi bi-check-lg"></i></button>
                        <button class="btn btn-sm btn-outline-admin ms-1"><i class="bi bi-eye"></i></button>
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
