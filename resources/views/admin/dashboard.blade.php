@extends('layouts.admin')

@section('title', 'Ringkasan Utama | Portal Admin')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0">Ringkasan Utama</h3>
        <p class="text-muted mb-0 small">Pantau aktivitas kafe hari ini.</p>
    </div>
    <div>
        <button class="btn btn-admin btn-sm px-3 rounded-pill"><i class="bi bi-download me-1"></i> Unduh Laporan</button>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="admin-card">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <p class="text-muted mb-1 text-uppercase small fw-bold">Pendapatan (Hari Ini)</p>
                    <h4 class="fw-bold mb-0">Rp 2.450.000</h4>
                </div>
                <div class="icon-box primary">
                    <i class="bi bi-currency-dollar"></i>
                </div>
            </div>
            <div class="d-flex align-items-center small">
                <i class="bi bi-arrow-up-circle-fill text-success me-1"></i>
                <span class="text-success fw-bold me-2">+12.5%</span>
                <span class="text-muted">dari kemarin</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="admin-card">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <p class="text-muted mb-1 text-uppercase small fw-bold">Pesanan Baru</p>
                    <h4 class="fw-bold mb-0">45</h4>
                </div>
                <div class="icon-box success">
                    <i class="bi bi-basket-fill"></i>
                </div>
            </div>
            <div class="d-flex align-items-center small">
                <i class="bi bi-arrow-up-circle-fill text-success me-1"></i>
                <span class="text-success fw-bold me-2">+5</span>
                <span class="text-muted">transaksi sukses</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="admin-card">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <p class="text-muted mb-1 text-uppercase small fw-bold">Reservasi Menunggu</p>
                    <h4 class="fw-bold mb-0">8</h4>
                </div>
                <div class="icon-box warning">
                    <i class="bi bi-calendar-event"></i>
                </div>
            </div>
            <div class="d-flex align-items-center small">
                <i class="bi bi-exclamation-circle-fill text-warning me-1"></i>
                <span class="text-warning fw-bold me-2">Perlu tindakan</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="admin-card">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <p class="text-muted mb-1 text-uppercase small fw-bold">Pengunjung Aktif</p>
                    <h4 class="fw-bold mb-0">124</h4>
                </div>
                <div class="icon-box info">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <div class="d-flex align-items-center small">
                <i class="bi bi-arrow-up-circle-fill text-success me-1"></i>
                <span class="text-success fw-bold me-2">+18%</span>
                <span class="text-muted">di situs web saat ini</span>
            </div>
        </div>
    </div>
</div>

<!-- Table Row -->
<div class="row g-4">
    <div class="col-12 col-lg-8">
        <div class="admin-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Daftar Pesanan Terbaru</h5>
                <a href="{{ url('/admin/pesanan') }}" class="text-decoration-none small" style="color: var(--admin-accent);">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Total Transaksi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold">#ORD-9021</td>
                            <td>Bapak Budi Santoso</td>
                            <td>Rp 150.000</td>
                            <td><span class="badge-status badge-completed">Selesai</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-admin"><i class="bi bi-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">#ORD-9022</td>
                            <td>Ibu Siti Aminah</td>
                            <td>Rp 85.000</td>
                            <td><span class="badge-status badge-pending">Diproses</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-admin"><i class="bi bi-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">#ORD-9023</td>
                            <td>Andi Darmawan</td>
                            <td>Rp 210.000</td>
                            <td><span class="badge-status badge-completed">Selesai</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-admin"><i class="bi bi-eye"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">#ORD-9024</td>
                            <td>Maya Sari</td>
                            <td>Rp 45.000</td>
                            <td><span class="badge-status badge-pending">Diproses</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-admin"><i class="bi bi-eye"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4">
        <div class="admin-card">
            <h5 class="fw-bold mb-4">Jadwal Reservasi Terdekat</h5>

            <div class="d-flex align-items-start gap-3 mb-4 pb-3 border-bottom"
                style="border-color: var(--border-color) !important;">
                <div class="bg-dark rounded text-center p-2" style="min-width: 60px;">
                    <div class="text-uppercase small text-muted fw-bold">NOV</div>
                    <div class="fs-4 fw-bold" style="color: var(--admin-accent);">15</div>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">Meja Mawar (4 Orang)</h6>
                    <p class="text-muted small mb-1"><i class="bi bi-clock me-1"></i> 18:00 - 20:00 WIB</p>
                    <span class="badge bg-secondary mb-0">A/N: Bapak Rian</span>
                </div>
            </div>

            <div class="d-flex align-items-start gap-3 mb-4 pb-3 border-bottom"
                style="border-color: var(--border-color) !important;">
                <div class="bg-dark rounded text-center p-2" style="min-width: 60px;">
                    <div class="text-uppercase small text-muted fw-bold">NOV</div>
                    <div class="fs-4 fw-bold" style="color: var(--admin-accent);">16</div>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">Paket Komunitas</h6>
                    <p class="text-muted small mb-1"><i class="bi bi-clock me-1"></i> 14:00 - 17:00 WIB</p>
                    <span class="badge bg-secondary mb-0">A/N: Ibu Siska</span>
                </div>
            </div>

            <a href="{{ url('/admin/reservasi') }}" class="btn btn-outline-admin w-100 mt-2">Lihat Jadwal Lengkap</a>
        </div>
    </div>
</div>
@endsection
