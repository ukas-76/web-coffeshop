@extends('layouts.app')

@section('title', 'Pesanan Saya | Roastory')

@push('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, var(--primary-coffee) 0%, var(--accent-coffee) 100%);
        color: white;
        padding: 60px 0 40px;
        text-align: center;
        border-radius: 0 0 40px 40px;
        margin-bottom: 40px;
    }
    
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    
    .status-menunggu { background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
    .status-diproses { background-color: #cce5ff; color: #004085; border: 1px solid #b8daff; }
    .status-selesai { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .status-dibatalkan { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

    .order-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: 1px solid rgba(0,0,0,0.08);
        border-radius: 16px;
    }
    .order-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="container">
        <h1 class="fw-bold mb-2"><i class="bi bi-bag-check me-2"></i>Pesanan Saya</h1>
        <p class="opacity-75">Pantau status pesanan dan reservasi Anda di sini.</p>
    </div>
</div>

<div class="container mb-5 pb-5" style="min-height: 50vh;">
    @if($pesanan->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-receipt text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
            <h4 class="mt-4 text-secondary">Belum Ada Pesanan</h4>
            <p class="text-muted">Anda belum melakukan pesanan apa pun. Yuk, mulai pesan kopi favorit Anda!</p>
            <a href="{{ url('/order') }}" class="btn btn-kopi px-4 py-2 mt-3 rounded-pill">Pesan Sekarang</a>
        </div>
    @else
        <div class="row g-4">
            @foreach($pesanan as $item)
                <div class="col-md-6 col-lg-4">
                    <div class="card order-card h-100 bg-white">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <span class="text-muted small"><i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }}</span>
                                
                                @if($item->status == 'menunggu')
                                    <span class="status-badge status-menunggu"><i class="bi bi-clock me-1"></i>Menunggu</span>
                                @elseif($item->status == 'diproses')
                                    <span class="status-badge status-diproses"><i class="bi bi-arrow-repeat me-1"></i>Diproses</span>
                                @elseif($item->status == 'ready_diambil')
                                    <span class="status-badge" style="background-color: #d1e7dd; color: #0f5132; border: 1px solid #badbcc;"><i class="bi bi-bag-check me-1"></i>Siap Diambil</span>
                                @elseif($item->status == 'sedang_diantar')
                                    <span class="status-badge" style="background-color: #cff4fc; color: #055160; border: 1px solid #b6effb;"><i class="bi bi-truck me-1"></i>Sedang Diantar</span>
                                @else
                                    <span class="status-badge status-dibatalkan"><i class="bi bi-x-circle me-1"></i>{{ ucfirst(str_replace('_', ' ', $item->status)) }}</span>
                                @endif
                            </div>
                            
                            <h5 class="fw-bold mb-1">
                                @if($item->jenis_pesanan == 'dine-in')
                                    <i class="bi bi-shop me-2 text-kopi"></i> Makan di Tempat (Dine-in)
                                @elseif($item->jenis_pesanan == 'delivery')
                                    <i class="bi bi-motorcycle me-2 text-kopi"></i> Pesan Antar (Delivery)
                                @else
                                    <i class="bi bi-bag me-2 text-kopi"></i> Ambil Sendiri (Pickup)
                                @endif
                            </h5>
                            
                            <div class="text-secondary small mb-3">
                                ID Transaksi: <span class="fw-bold">#RST-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </div>

                            @if($item->detailReservasi->isNotEmpty())
                            <div class="mb-3">
                                <button type="button" class="btn btn-sm btn-outline-dark w-100" data-bs-toggle="modal" data-bs-target="#detailPesananModal{{ $item->id }}">
                                    <i class="bi bi-card-list me-1"></i> Lihat Detail Menu
                                </button>
                            </div>
                            @endif
                            
                            <div class="bg-light p-3 rounded-3 mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Total Pembayaran</span>
                                    <span class="fw-bold text-kopi">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</span>
                                </div>
                                @if($item->jenis_pesanan == 'dine-in' && $item->tanggal_reservasi)
                                <div class="d-flex justify-content-between small">
                                    <span class="text-muted">Jadwal</span>
                                    <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($item->tanggal_reservasi)->format('d M Y') }} ({{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }})</span>
                                </div>
                                @endif
                            </div>
                            
                            @if($item->status == 'menunggu')
                                <div class="alert alert-warning py-2 px-3 small mb-0 border-0 bg-warning bg-opacity-10 text-warning" style="color: #856404 !important;">
                                    <i class="bi bi-info-circle me-1"></i> Menunggu konfirmasi dari admin.
                                </div>
                            @elseif($item->status == 'diproses')
                                <div class="alert alert-info py-2 px-3 small mb-0 border-0 bg-info bg-opacity-10 text-primary">
                                    <i class="bi bi-info-circle me-1"></i> Pesanan Anda sedang disiapkan.
                                </div>
                            @elseif($item->status == 'ready_diambil')
                                <div class="alert alert-success py-2 px-3 small mb-0 border-0 bg-success bg-opacity-10 text-success">
                                    <i class="bi bi-info-circle me-1"></i> Pesanan Anda sudah siap diambil di kasir!
                                </div>
                            @elseif($item->status == 'sedang_diantar')
                                <div class="alert alert-primary py-2 px-3 small mb-3 border-0 bg-primary bg-opacity-10 text-primary">
                                    <i class="bi bi-info-circle me-1"></i> Kurir kami sedang dalam perjalanan mengantar pesanan.
                                </div>
                                @if($item->jenis_pesanan == 'delivery')
                                    <form action="{{ route('pesanan.saya.selesai', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success w-100 fw-bold rounded-pill shadow-sm" onclick="return confirm('Apakah Anda yakin pesanan telah diterima dengan baik?')">
                                            <i class="bi bi-check2-circle me-2"></i>Pesanan Diterima
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- MODAL DETAIL PESANAN --}}
@if($pesanan && $pesanan->isNotEmpty())
    @foreach($pesanan as $item)
        @if($item->detailReservasi->isNotEmpty())
        <div class="modal fade" id="detailPesananModal{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-light border-bottom-0">
                        <h5 class="modal-title fw-bold text-dark">Detail Menu #RST-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-unstyled mb-0">
                            @foreach($item->detailReservasi as $detail)
                            <li class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                                <div>
                                    <span class="fw-bold text-dark d-block">{{ $detail->menu->nama ?? 'Menu Terhapus' }}</span>
                                    <small class="text-secondary">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga_saat_reservasi, 0, ',', '.') }}</small>
                                </div>
                                <span class="fw-bold text-kopi">Rp {{ number_format($detail->subtotal ?? ($detail->jumlah * $detail->harga_saat_reservasi), 0, ',', '.') }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="modal-footer border-top-0 bg-light">
                        <button type="button" class="btn btn-secondary rounded-pill w-100" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endforeach
@endif

@endsection
