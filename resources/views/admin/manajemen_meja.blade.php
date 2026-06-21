@extends('layouts.admin')

@section('title', 'Manajemen Meja | Portal Admin')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0">Manajemen Meja</h3>
        <p class="text-muted mb-0 small">Atur nomor meja, kapasitas, serta pantau status dan lokasi denah meja kafe.</p>
    </div>
    <button class="btn btn-admin btn-sm px-3 rounded-pill" data-bs-toggle="modal" data-bs-target="#modalTambahMeja">
        <i class="bi bi-plus-lg me-1"></i> Tambah Meja
    </button>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show bg-success text-white border-0 mb-4" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Nomor Meja</th>
                    <th width="15%">Kapasitas</th>
                    <th width="15%">Minimal DP</th>
                    <th width="15%">Status</th>
                    <th width="20%">Foto / Denah Lokasi</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($allMeja as $index => $meja)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="fw-bold">{{ $meja->nomor_meja }}</td>
                    <td>{{ $meja->kapasitas }} Kursi</td>
                    <td class="text-warning fw-bold">Rp {{ number_format($meja->min_dp ?? 0, 0, ',', '.') }}</td>
                    <td>
                        @if($meja->status == 'tersedia')
                            <span class="badge bg-success text-white px-3 py-2 rounded-pill">Tersedia</span>
                        @elseif($meja->status == 'dipesan')
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Dipesan</span>
                        @else
                            <span class="badge bg-danger text-white px-3 py-2 rounded-pill">Rusak</span>
                        @endif
                    </td>
                    <td>
                        @if($meja->gambar_lokasi)
                            <a href="{{ asset($meja->gambar_lokasi) }}" target="_blank">
                                <img src="{{ asset($meja->gambar_lokasi) }}" alt="Lokasi {{ $meja->nomor_meja }}" class="img-fluid rounded border border-secondary" style="max-height: 60px; object-fit: cover;">
                            </a>
                        @else
                            <span class="text-muted small italic"><i class="bi bi-image me-1"></i> Belum ada gambar</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-admin" data-bs-toggle="modal" data-bs-target="#modalEditMeja{{ $meja->id }}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalHapusMeja{{ $meja->id }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Belum ada data meja terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ==================== AREA GLOBAL MODAL (DILUAR TABEL) ==================== -->

<!-- MODAL TAMBAH MEJA -->
<div class="modal fade" id="modalTambahMeja" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle-fill text-warning me-2"></i>Tambah Meja Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('meja.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nomor Meja</label>
                        <input type="text" name="nomor_meja" class="form-control bg-secondary text-white border-0" required placeholder="Contoh: Meja 01, Meja VIP 3">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Kapasitas (Kursi)</label>
                        <input type="number" name="kapasitas" class="form-control bg-secondary text-white border-0" required min="1" placeholder="Contoh: 4">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Minimal DP Pembelian (Rupiah)</label>
                        <input type="number" name="min_dp" class="form-control bg-secondary text-white border-0" required min="0" placeholder="Contoh: 100000">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Status</label>
                        <select name="status" class="form-select bg-secondary text-white border-0" required>
                            <option value="tersedia" selected>Tersedia</option>
                            <option value="dipesan">Dipesan</option>
                            <option value="rusak">Rusak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Gambar / Denah Lokasi Meja</label>
                        <input type="file" name="gambar_lokasi" class="form-control bg-secondary text-white border-0">
                        <div class="form-text text-muted small">Format: png, jpg, jpeg (Maks. 2MB).</div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-sm btn-outline-secondary text-white" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-admin px-3">Simpan Meja</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- LOOPING MODAL EDIT & HAPUS -->
@foreach($allMeja as $meja)
<!-- MODAL EDIT MEJA -->
<div class="modal fade" id="modalEditMeja{{ $meja->id }}" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square text-warning me-2"></i>Edit Data Meja</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('meja.update', $meja->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nomor Meja</label>
                        <input type="text" name="nomor_meja" class="form-control bg-secondary text-white border-0" value="{{ $meja->nomor_meja }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Kapasitas (Kursi)</label>
                        <input type="number" name="kapasitas" class="form-control bg-secondary text-white border-0" value="{{ $meja->kapasitas }}" required min="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Minimal DP Pembelian (Rupiah)</label>
                        <input type="number" name="min_dp" class="form-control bg-secondary text-white border-0" value="{{ $meja->min_dp ?? 0 }}" required min="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Status Meja</label>
                        <select name="status" class="form-select bg-secondary text-white border-0" required>
                            <option value="tersedia" {{ $meja->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="dipesan" {{ $meja->status == 'dipesan' ? 'selected' : '' }}>Dipesan</option>
                            <option value="rusak" {{ $meja->status == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Ubah Gambar/Denah Lokasi (Kosongkan jika tidak diganti)</label>
                        <input type="file" name="gambar_lokasi" class="form-control bg-secondary text-white border-0">
                        @if($meja->gambar_lokasi)
                            <div class="mt-2">
                                <span class="d-block small text-muted mb-1">Gambar Saat Ini:</span>
                                <img src="{{ asset($meja->gambar_lokasi) }}" class="rounded img-fluid" style="max-height: 80px;">
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-sm btn-outline-secondary text-white" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-admin px-3">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL HAPUS MEJA -->
<div class="modal fade" id="modalHapusMeja{{ $meja->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content bg-dark text-white border-danger">
            <div class="modal-body text-center pt-4">
                <i class="bi bi-exclamation-triangle-fill text-danger display-5 mb-3"></i>
                <p class="mb-4">Apakah kamu yakin ingin menghapus <strong>{{ $meja->nomor_meja }}</strong> dari sistem?</p>
                <form action="{{ route('meja.destroy', $meja->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-sm btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-danger px-3">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection