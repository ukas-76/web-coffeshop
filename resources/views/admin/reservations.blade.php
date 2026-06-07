@extends('layouts.admin')

@section('title', 'Daftar Reservasi | Portal Admin')

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
        <h3 class="fw-bold mb-0">Manajemen Reservasi</h3>
        <p class="text-muted mb-0 small">Kelola ketersediaan meja dan jadwal reservasi pengunjung.</p>
    </div>
    <div class="d-flex gap-2">
        <input type="date" id="filterTanggal" value="{{ $tanggal }}" class="form-control bg-dark text-white border-0 shadow-none" style="border: 1px solid var(--border-color) !important;">
        <button class="btn btn-admin btn-sm px-3 rounded-pill text-nowrap" data-bs-toggle="modal" data-bs-target="#tambahReservasiModal">
            <i class="bi bi-plus-lg me-1"></i> Buat Reservasi
        </button>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="admin-card p-3 d-flex align-items-center gap-3">
            <div class="icon-box info"><i class="bi bi-journal-check"></i></div>
            <div>
                <h6 class="text-muted text-uppercase small fw-bold mb-1">Total Reservasi Tanggal Ini</h6>
                <h4 class="fw-bold mb-0">{{ $totalHariIni }} Meja</h4> </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card p-3 d-flex align-items-center gap-3">
            <div class="icon-box warning"><i class="bi bi-clock-history"></i></div>
            <div>
                <h6 class="text-muted text-uppercase small fw-bold mb-1">Menunggu Kedatangan</h6>
                <h4 class="fw-bold mb-0">{{ $menunggu }} Meja</h4> </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card p-3 d-flex align-items-center gap-3">
            <div class="icon-box success"><i class="bi bi-check2-circle"></i></div>
            <div>
                <h6 class="text-muted text-uppercase small fw-bold mb-1">Telah Hadir</h6>
                <h4 class="fw-bold mb-0">{{ $hadir }} Meja</h4> </div>
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
                @forelse($dataReservasi as $reservasi)
                <tr>
                    {{-- Waktu & Tanggal Reservasi --}}
                    <td>
                        <div class="fw-bold text-white">
                            {{ \Carbon\Carbon::parse($reservasi->jam_mulai)->format('H:i') }} - 
                            {{ \Carbon\Carbon::parse($reservasi->jam_selesai)->format('H:i') }} WIB
                        </div>
                        <div class="text-muted small">
                            {{ \Carbon\Carbon::parse($reservasi->tanggal_reservasi)->translatedFormat('l, d M Y') }}
                        </div>
                    </td>
                    
                    {{-- Data Pelanggan --}}
                    <td>
                        <div class="fw-bold text-white">{{ $reservasi->pengguna->nama ?? 'Tamu Walk-in' }}</div>
                        <div class="small text-muted">{{ $reservasi->pengguna->nomor_telepon ?? '-' }}</div>
                    </td>
                    
                    {{-- Lokasi Meja --}}
                    <td class="text-white">{{ $reservasi->meja->nama ?? 'Belum Ditentukan' }}</td>
                    
                    {{-- Jumlah Orang (Pax) --}}
                    <td><i class="bi bi-people-fill text-muted me-1"></i> {{ $reservasi->total_tamu ?? 0 }} Orang</td>
                    
                    {{-- DP Dibayar (Sementara statis atau ambil dari relasi pembayaran jika sudah ada) --}}
                    <td class="fw-bold text-success">
                        Rp {{ number_format($reservasi->ongkir ?? 0, 0, ',', '.') }} {{-- Asumsi DP masuk ke kolom ongkir sementara, sesuaikan dengan logicmu --}}
                    </td>
                    
                    {{-- Status Badge --}}
                    <td>
                        @if($reservasi->status == 'selesai' || $reservasi->status == 'hadir')
                            <span class="badge-status badge-completed">Hadir</span>
                        @elseif($reservasi->status == 'dibatalkan')
                            <span class="badge bg-danger text-white border-0">Batal</span>
                        @else
                            <span class="badge-status badge-pending">Menunggu</span>
                        @endif
                    </td>
                    
                    {{-- Tombol Aksi --}}
                    <td class="text-end">
                        <form action="/admin/reservations/{{ $reservasi->id }}/status" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="selesai">
                            <button type="submit" class="btn btn-sm btn-outline-success" title="Tandai Hadir" {{ ($reservasi->status == 'selesai' || $reservasi->status == 'dibatalkan') ? 'disabled' : '' }}>
                                <i class="bi bi-check-lg"></i>
                            </button>
                        </form>

                        <button class="btn btn-sm btn-outline-info ms-1" data-bs-toggle="modal" data-bs-target="#detailReservasiModal{{ $reservasi->id }}" title="Lihat Detail">
                            <i class="bi bi-eye"></i>
                        </button>

                        <form action="/admin/reservations/{{ $reservasi->id }}/status" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin membatalkan reservasi meja ini?');">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="dibatalkan">
                            <button type="submit" class="btn btn-sm btn-outline-danger ms-1" title="Batalkan Reservasi" {{ ($reservasi->status == 'selesai' || $reservasi->status == 'dibatalkan') ? 'disabled' : '' }}>
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-calendar-x fs-3 d-block mb-2"></i>
                        Belum ada reservasi meja (Dine-in) untuk saat ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 pt-3 border-top text-center" style="border-color: var(--border-color) !important;">
        <button class="btn btn-sm btn-outline-secondary">Muat Lebih Banyak...</button>
    </div>
</div>

{{-- MODAL TAMBAH RESERVASI MANUAL --}}
<div class="modal fade" id="tambahReservasiModal" tabindex="-1" data-bs-theme="dark">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background-color: var(--admin-card); border: 1px solid var(--border-color);">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold text-white">Buat Reservasi Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="/admin/reservations" method="POST">
                @csrf
                <div class="modal-body py-0">
                    <div class="row g-3">
                        {{-- Data Pelanggan --}}
                        <div class="col-md-6">
                            <label class="form-label text-white small mb-1">Nama Pemesan</label>
                            <input type="text" name="nama_pelanggan" class="form-control bg-dark text-white border-secondary" placeholder="Contoh: Bapak Rian" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white small mb-1">Nomor Telepon / WA</label>
                            <input type="text" name="nomor_telepon" class="form-control bg-dark text-white border-secondary" placeholder="Contoh: 08123456789" required>
                        </div>

                        {{-- Waktu Reservasi --}}
                        <div class="col-md-4">
                            <label class="form-label text-white small mb-1">Tanggal</label>
                            <input type="date" name="tanggal_reservasi" class="form-control bg-dark text-white border-secondary" value="{{ \Carbon\Carbon::today()->toDateString() }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-white small mb-1">Jam Datang</label>
                            <input type="time" name="jam_mulai" class="form-control bg-dark text-white border-secondary" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-white small mb-1">Selesai (Estimasi)</label>
                            <input type="time" name="jam_selesai" class="form-control bg-dark text-white border-secondary">
                        </div>

                        {{-- Meja & Kapasitas --}}
                        <div class="col-md-8">
                            <label class="form-label text-white small mb-1">Pilih Meja</label>
                            <select name="meja_id" class="form-select bg-dark text-white border-secondary" required>
                                <option value="" disabled selected>-- Pilih Lokasi Meja --</option>
                                {{-- Melakukan looping data meja dari controller --}}
                                @if(isset($dataMeja) && $dataMeja->count() > 0)
                                    @foreach($dataMeja as $meja)
                                        <option value="{{ $meja->id }}">{{ $meja->nama }} (Kapasitas: {{ $meja->kapasitas }} Orang)</option>
                                    @endforeach
                                @else
                                    <option value="" disabled>Belum ada data meja di database</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-white small mb-1">Jumlah Orang (Pax)</label>
                            <div class="input-group">
                                <input type="number" name="total_tamu" class="form-control bg-dark text-white border-secondary" min="1" value="2" required>
                                <span class="input-group-text bg-secondary text-white border-secondary">Orang</span>
                            </div>
                        </div>
                        
                        {{-- DP / Nominal (Opsional) --}}
                        <div class="col-md-12 mb-2">
                            <label class="form-label text-white small mb-1">Uang Muka / DP (Opsional)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-secondary text-white border-secondary">Rp</span>
                                <input type="number" name="dp_dibayar" class="form-control bg-dark text-white border-secondary" placeholder="0" min="0">
                            </div>
                            <small class="text-muted" style="font-size: 0.7rem;">Kosongkan jika tamu tidak membayar DP (Walk-in).</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 mt-3">
                    <button type="button" class="btn btn-outline-secondary btn-sm px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-admin btn-sm px-4">Simpan Reservasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL DETAIL RESERVASI (Mata) --}}
@foreach($dataReservasi as $reservasi)
<div class="modal fade" id="detailReservasiModal{{ $reservasi->id }}" tabindex="-1" data-bs-theme="dark">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: var(--admin-card); border: 1px solid var(--border-color);">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold text-white">Detail Reservasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-0">
                <ul class="list-group list-group-flush mb-3 rounded" style="border: 1px solid var(--border-color);">
                    <li class="list-group-item bg-dark text-white border-secondary d-flex justify-content-between align-items-center">
                        <span class="small text-muted">Nama Pelanggan</span>
                        <span class="fw-bold">{{ $reservasi->pengguna->nama ?? 'Tamu Manual / Walk-in' }}</span>
                    </li>
                    <li class="list-group-item bg-dark text-white border-secondary d-flex justify-content-between align-items-center">
                        <span class="small text-muted">Telepon / WA</span>
                        <span>{{ $reservasi->pengguna->nomor_telepon ?? '-' }}</span>
                    </li>
                    <li class="list-group-item bg-dark text-white border-secondary d-flex justify-content-between align-items-center">
                        <span class="small text-muted">Jadwal</span>
                        <span>{{ \Carbon\Carbon::parse($reservasi->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($reservasi->jam_selesai)->format('H:i') }} WIB</span>
                    </li>
                    <li class="list-group-item bg-dark text-white border-secondary d-flex justify-content-between align-items-center">
                        <span class="small text-muted">Lokasi Meja</span>
                        <span class="text-info">{{ $reservasi->meja->nama ?? 'Belum Ditentukan' }}</span>
                    </li>
                    <li class="list-group-item bg-dark text-white border-secondary d-flex justify-content-between align-items-center">
                        <span class="small text-muted">Kapasitas Tamu</span>
                        <span>{{ $reservasi->total_tamu ?? 0 }} Pax</span>
                    </li>
                    <li class="list-group-item bg-dark text-white border-secondary d-flex justify-content-between align-items-center">
                        <span class="small text-muted">Uang Muka (DP)</span>
                        <span class="text-success fw-bold">Rp {{ number_format($reservasi->ongkir ?? 0, 0, ',', '.') }}</span>
                    </li>
                </ul>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
