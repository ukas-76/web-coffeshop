@extends('layouts.admin')

@section('title', 'Daftar Pengguna | Portal Admin')

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
        <h3 class="fw-bold mb-0">Daftar Pengguna Aktif</h3>
        <p class="text-muted mb-0 small">Pantau status pendaftaran anggota dan riwayat pelanggan.</p>
    </div>
    <div class="d-flex align-items-center gap-2 bg-dark rounded-pill px-3 py-1" style="border: 1px solid var(--border-color);">
        <i class="bi bi-search text-muted"></i>
        <input type="text" placeholder="Cari nama atau nomor HP..." class="bg-transparent border-0 text-white shadow-none form-control form-control-sm" style="outline: none; box-shadow: none;">
    </div>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Pelanggan</th>
                    <th>Kontak Email</th>
                    <th>No. WhatsApp</th>
                    <th>Member Tier</th>
                    <th>Total Poin</th>
                    <th>Bergabung Sejak</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dataPengguna as $pengguna)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($pengguna->nama) }}&background=d4b59d&color=1e1b1a" alt="User" class="rounded-circle" width="40" height="40">
                            <div>
                                <div class="fw-bold text-white">{{ $pengguna->nama }}</div>
                                <div class="small text-muted">Pelanggan</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-white small">{{ $pengguna->email }}</td>
                    <td class="text-white small">{{ $pengguna->nomor_telepon ?? '-' }}</td>
                    <td>
                        @if($pengguna->poin >= 300)
                            <span class="badge text-dark" style="background-color: #ffd700;">Gold Member</span>
                        @elseif($pengguna->poin >= 100)
                            <span class="badge text-dark bg-light">Silver Member</span>
                        @else
                            <span class="badge text-white" style="background-color: #a87d60;">Bronze Member</span>
                        @endif
                    </td>
                    <td class="fw-bold text-white">{{ number_format($pengguna->poin, 0, ',', '.') }} Pts</td>
                    <td class="text-muted small">{{ $pengguna->created_at ? $pengguna->created_at->format('d M Y') : '-' }}</td>
                    <td class="text-end">
                        <form action="/admin/users/{{ $pengguna->id }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pelanggan bernama {{ $pengguna->nama }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Pengguna"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                        Belum ada pelanggan yang mendaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top" style="border-color: var(--border-color) !important;">
        <span class="text-muted small">Total: <strong>{{ $dataPengguna->count() }}</strong> pelanggan terdaftar</span>
    </div>
</div>
@endsection
