@extends('layouts.admin')
@section('title', 'Hasil Pencarian | Portal Admin')

@section('admin_content')
<div class="mb-4">
    <h3 class="fw-bold mb-1">Hasil Pencarian</h3>
    <p class="text-muted small">Menampilkan hasil untuk kata kunci: <span class="text-white fw-bold">"{{ $keyword }}"</span></p>
</div>

<div class="row g-4">
    <!-- HASIL RESERVASI & PESANAN -->
    <div class="col-12">
        <div class="admin-card">
            <h5 class="fw-bold mb-3" style="color: var(--admin-accent);"><i class="bi bi-cart me-2"></i>Pesanan & Reservasi ({{ $hasilReservasi->count() }})</h5>
            @if($hasilReservasi->count() > 0)
                <div class="table-responsive">
                    <table class="table table-dark mb-0">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Jenis</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hasilReservasi as $res)
                            <tr>
                                <td>#ORD-{{ str_pad($res->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $res->pengguna->nama ?? 'Tamu Walk-in' }}</td>
                                <td>{{ ucfirst($res->jenis_pesanan) }}</td>
                                <td><span class="badge bg-secondary">{{ ucfirst($res->status) }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mb-0 small">Tidak ada data pesanan/reservasi yang cocok.</p>
            @endif
        </div>
    </div>

    <!-- HASIL MENU -->
    <div class="col-md-6">
        <div class="admin-card">
            <h5 class="fw-bold mb-3" style="color: var(--admin-accent);"><i class="bi bi-cup-hot me-2"></i>Katalog Menu ({{ $hasilMenu->count() }})</h5>
            @if($hasilMenu->count() > 0)
                <ul class="list-group list-group-flush rounded border-secondary">
                    @foreach($hasilMenu as $menu)
                    <li class="list-group-item bg-dark text-white border-secondary d-flex justify-content-between">
                        <span>{{ $menu->nama }}</span>
                        <span class="fw-bold text-success">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                    </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted mb-0 small">Tidak ada menu yang cocok.</p>
            @endif
        </div>
    </div>

    <!-- HASIL PENGGUNA -->
    <div class="col-md-6">
        <div class="admin-card">
            <h5 class="fw-bold mb-3" style="color: var(--admin-accent);"><i class="bi bi-people me-2"></i>Pengguna / Pelanggan ({{ $hasilPengguna->count() }})</h5>
            @if($hasilPengguna->count() > 0)
                <ul class="list-group list-group-flush rounded border-secondary">
                    @foreach($hasilPengguna as $user)
                    <li class="list-group-item bg-dark text-white border-secondary d-flex justify-content-between">
                        <span>{{ $user->nama }}</span>
                        <span class="text-muted">{{ $user->nomor_telepon }}</span>
                    </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted mb-0 small">Tidak ada pengguna yang cocok.</p>
            @endif
        </div>
    </div>
</div>
@endsection