@extends('layouts.admin')

@section('title', 'Daftar Pesanan | Portal Admin')

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
        <h3 class="fw-bold mb-0">Daftar Pesanan</h3>
        <p class="text-muted mb-0 small">Kelola seluruh transaksi pesanan (Delivery/Pick-up).</p>
    </div>
    <div class="d-flex gap-2">
        <select id="filterStatus" class="form-select bg-dark text-white shadow-none" style="border: 1px solid var(--border-color) !important; width: auto;">
            <option value="all">Semua Status</option>
            <option value="menunggu">Menunggu</option>
            <option value="diproses">Diproses</option>
            <option value="selesai">Selesai</option>
            <option value="dibatalkan">Dibatalkan</option>
        </select>
    </div>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Tanggal & Waktu</th>
                    <th>Pelanggan</th>
                    <th>Jenis Pesanan</th>
                    <th>Total Transaksi</th>
                    <th>Status</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dataPesanan as $pesanan)
                <tr class="baris-pesanan" data-status="{{ strtolower($pesanan->status ?? 'menunggu') }}">
                    {{-- ID digenerate otomatis dengan padding nol agar terlihat seperti format nota --}}
                    <td class="fw-bold text-white">#ORD-{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}</td>
                    
                    {{-- Format tanggal menggunakan Carbon bawaan Laravel --}}
                    <td class="text-muted small">{{ $pesanan->created_at ? $pesanan->created_at->format('d M Y, H:i') : '-' }}</td>
                    
                    {{-- Mengambil data nama dan nomor telepon dari relasi tabel pengguna --}}
                    <td>
                        <div class="fw-bold text-white">{{ $pesanan->pengguna->nama ?? 'Pelanggan Tamu' }}</div>
                        <div class="small text-muted">{{ $pesanan->pengguna->nomor_telepon ?? '-' }}</div>
                    </td>
                    
                    {{-- Logika warna badge berdasarkan jenis pesanan --}}
                    <td>
                        @if($pesanan->jenis_pesanan == 'delivery')
                            <span class="badge bg-info text-dark">Delivery</span>
                        @else
                            <span class="badge bg-secondary">Pick-up</span>
                        @endif
                    </td>
                    
                    {{-- Harga sementara menampilkan ongkir (nanti disambung ke tabel pembayaran) --}}
                    <td class="fw-bold">Rp {{ number_format($pesanan->ongkir ?? 0, 0, ',', '.') }}</td>
                    
                    {{-- Logika warna badge berdasarkan status --}}
                    <td>
                        @if($pesanan->status == 'selesai')
                            <span class="badge-status badge-completed">Selesai</span>
                        @elseif($pesanan->status == 'dibatalkan')
                            <span class="badge bg-danger text-white border-0">Dibatalkan</span>
                        @else
                            {{-- Status menunggu / dikonfirmasi --}}
                            <span class="badge-status badge-pending">{{ ucfirst($pesanan->status ?? 'Diproses') }}</span>
                        @endif
                    </td>
                    
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $pesanan->id }}" title="Lihat Detail">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-primary ms-1" data-bs-toggle="modal" data-bs-target="#editStatusModal{{ $pesanan->id }}" title="Edit Status">
                            <i class="bi bi-pencil"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                        Belum ada pesanan Delivery atau Pick-up.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top" style="border-color: var(--border-color) !important;">
        <span class="text-muted small">Menampilkan 1 hingga 5 dari 45 pesanan</span>
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm mb-0" data-bs-theme="dark">
                <li class="page-item disabled"><a class="page-link bg-dark text-muted border-secondary" href="#">Sebelumnya</a></li>
                <li class="page-item active"><a class="page-link" style="background-color: var(--admin-accent); color: var(--admin-dark); border-color: var(--admin-accent);" href="#">1</a></li>
                <li class="page-item"><a class="page-link bg-dark text-white border-secondary" href="#">2</a></li>
                <li class="page-item"><a class="page-link bg-dark text-white border-secondary" href="#">3</a></li>
                <li class="page-item"><a class="page-link bg-dark text-white border-secondary" href="#">Selanjutnya</a></li>
            </ul>
        </nav>
    </div>
</div>

{{-- MODAL EDIT STATUS PESANAN --}}
@foreach($dataPesanan as $pesanan)
<div class="modal fade" id="editStatusModal{{ $pesanan->id }}" tabindex="-1" data-bs-theme="dark">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content" style="background-color: var(--admin-card); border: 1px solid var(--border-color);">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold text-white">Update Status</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="/admin/pesanan/{{ $pesanan->id }}/status" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body py-1">
                    <p class="small text-muted mb-2">Pesanan: #ORD-{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}</p>
                    <select name="status" class="form-select bg-dark text-white border-secondary">
                        <option value="menunggu" {{ $pesanan->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diproses" {{ $pesanan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ $pesanan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ $pesanan->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL DETAIL PESANAN (Tombol Mata) --}}
<div class="modal fade" id="detailModal{{ $pesanan->id }}" tabindex="-1" data-bs-theme="dark">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: var(--admin-card); border: 1px solid var(--border-color);">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold text-white">Detail Pesanan #ORD-{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-0">
                <div class="p-3 rounded mb-3" style="background-color: rgba(0,0,0,0.2);">
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted d-block">Pelanggan</small>
                            <span class="text-white fw-bold">{{ $pesanan->pengguna->nama ?? 'Tamu' }}</span>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Telepon</small>
                            <span class="text-white">{{ $pesanan->pengguna->nomor_telepon ?? '-' }}</span>
                        </div>
                    </div>
                    <hr class="border-secondary">
                    <div class="row">
                        <div class="col-12">
                            <small class="text-muted d-block">Alamat Pengiriman</small>
                            <span class="text-white">{{ $pesanan->alamat_pengiriman ?? 'Ambil di Toko (Pick-up)' }}</span>
                        </div>
                    </div>
                </div>
                
                <h6 class="text-white mb-2">Daftar Menu:</h6>
                <div class="text-center py-4 text-muted border border-secondary rounded mb-3" style="border-style: dashed !important;">
                    <i class="bi bi-cart4 fs-3 d-block mb-2"></i>
                    <small>Daftar pesanan menu akan segera disambungkan ke tabel detail_reservasi.</small>
                </div>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endforeach

{{-- SCRIPT JAVASCRIPT UNTUK FILTER DROPDOWN --}}
@push('admin_scripts')
<script>
    document.getElementById('filterStatus').addEventListener('change', function() {
        let selectedStatus = this.value;
        let rows = document.querySelectorAll('.baris-pesanan');
        
        rows.forEach(row => {
            let rowStatus = row.getAttribute('data-status');
            // Jika pilih 'all' atau statusnya cocok, tampilkan. Jika tidak, sembunyikan.
            if (selectedStatus === 'all' || selectedStatus === rowStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endpush

@endsection
