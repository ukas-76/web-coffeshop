@extends('layouts.admin')

@section('title', 'Ringkasan Utama | Portal Admin')

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
    
    .icon-box.primary {
        background-color: rgba(212, 181, 157, 0.2) !important;
        color: #f5d5b8 !important;
    }
    
    .icon-box.success {
        background-color: rgba(25, 135, 84, 0.25) !important;
        color: #51dd9f !important;
    }
    
    .icon-box.warning {
        background-color: rgba(255, 193, 7, 0.25) !important;
        color: #ffd60a !important;
    }
    
    .icon-box.info {
        background-color: rgba(13, 202, 240, 0.25) !important;
        color: #48d3ff !important;
    }
    
    .badge-completed {
        background-color: rgba(25, 135, 84, 0.35) !important;
        color: #4cef9f !important;
    }
    
    .badge-pending {
        background-color: rgba(255, 193, 7, 0.35) !important;
        color: #ffd60a !important;
    }
</style>
@endpush

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0">Ringkasan Utama</h3>
        <p class="text-muted mb-0 small">Pantau aktivitas kafe hari ini.</p>
    </div>
    <div>
        <a href="{{ url('/admin/export-laporan') }}" class="btn btn-admin btn-sm px-3 rounded-pill">
            <i class="bi bi-download me-1"></i> Unduh Laporan
        </a>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="admin-card">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <p class="text-muted mb-1 text-uppercase small fw-bold">Pendapatan (Hari Ini)</p>
                    <h4 class="fw-bold mb-0">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h4>
                </div>
                <div class="icon-box primary"><i class="bi bi-currency-dollar"></i></div>
            </div>
            <div class="small"><span class="text-success fw-bold">Live Data</span> <span class="text-muted">dari transaksi selesai</span></div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="admin-card">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <p class="text-muted mb-1 text-uppercase small fw-bold">Pesanan Baru</p>
                    <h4 class="fw-bold mb-0">{{ $pesananBaru }}</h4>
                </div>
                <div class="icon-box success"><i class="bi bi-basket-fill"></i></div>
            </div>
            <div class="small"><span class="text-muted">Total transaksi hari ini</span></div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="admin-card">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <p class="text-muted mb-1 text-uppercase small fw-bold">Reservasi Menunggu</p>
                    <h4 class="fw-bold mb-0">{{ $reservasiMenunggu }}</h4>
                </div>
                <div class="icon-box warning"><i class="bi bi-calendar-event"></i></div>
            </div>
            <div class="small"><span class="text-warning fw-bold">Perlu konfirmasi hadir</span></div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="admin-card">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <p class="text-muted mb-1 text-uppercase small fw-bold">Total Pelanggan</p>
                    <h4 class="fw-bold mb-0">{{ $totalPelanggan }}</h4>
                </div>
                <div class="icon-box info"><i class="bi bi-people-fill"></i></div>
            </div>
            <div class="small"><span class="text-muted">User terdaftar di sistem</span></div>
        </div>
    </div>
</div>

<!-- Table Row -->
<div class="row g-4">
    <div class="col-12 col-lg-8">
        <div class="admin-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Daftar Pesanan Terbaru</h5>
                <a href="{{ url('/admin/orders') }}" class="text-decoration-none small" style="color: var(--admin-accent);">Lihat Semua</a>
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
                        @foreach($recentOrders as $order)
                        <tr>
                            <td class="fw-bold">#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $order->pengguna->nama ?? 'Tamu' }}</td>
                            <td>Rp {{ number_format($order->ongkir, 0, ',', '.') }}</td>
                            <td>
                                @if($order->status == 'selesai')
                                    <span class="badge-status badge-completed">Selesai</span>
                                @else
                                    <span class="badge-status badge-pending">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('/admin/orders') }}" class="btn btn-sm btn-outline-admin"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4">
        <div class="admin-card">
            <h5 class="fw-bold mb-4">Jadwal Reservasi Terdekat</h5>

            @foreach($upcomingReservations as $res)
            <div class="d-flex align-items-start gap-3 mb-4 pb-3 border-bottom" style="border-color: var(--border-color) !important;">
                <div class="bg-dark rounded text-center p-2" style="min-width: 60px;">
                    <div class="text-uppercase small text-muted fw-bold">{{ \Carbon\Carbon::parse($res->tanggal_reservasi)->format('M') }}</div>
                    <div class="fs-4 fw-bold" style="color: var(--admin-accent);">{{ \Carbon\Carbon::parse($res->tanggal_reservasi)->format('d') }}</div>
                </div>
            <div>
                <h6 class="fw-bold mb-1">{{ $res->meja->nama ?? 'Meja Umum' }} ({{ $res->total_tamu }} Orang)</h6>
                <p class="text-muted small mb-1"><i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($res->jam_mulai)->format('H:i') }} WIB</p>
                <span class="badge bg-secondary mb-0">A/N: {{ $res->pengguna->nama ?? 'Tamu' }}</span>
                </div>
            </div>
            @endforeach

            <a href="{{ url('/admin/reservations') }}" class="btn btn-outline-admin w-100 mt-2">Lihat Jadwal Lengkap</a>
        </div>
    </div>
</div>
@endsection
