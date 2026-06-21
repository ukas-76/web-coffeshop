@extends('layouts.admin')

@section('title', 'Manajemen Promo & Event | Portal Admin')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0">Promo & Event</h3>
        <p class="text-muted mb-0 small">Kelola program potongan harga dan acara spesial kafe.</p>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show bg-success text-white border-0 mb-4" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<ul class="nav nav-tabs mb-4 border-bottom" id="promoEventTab" role="tablist" style="border-color: rgba(255,255,255,0.1) !important;">
    <li class="nav-item" role="presentation">
        <button class="nav-link active fw-bold text-uppercase px-4 py-2" id="promo-tab" data-bs-toggle="tab" data-bs-target="#promo-pane" type="button" role="tab" aria-controls="promo-pane" aria-selected="true" style="color: inherit; background: transparent; border: none;">
            <i class="bi bi-tags-fill me-2"></i> Daftar Promo
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link fw-bold text-uppercase px-4 py-2" id="event-tab" data-bs-toggle="tab" data-bs-target="#event-pane" type="button" role="tab" aria-controls="event-pane" aria-selected="false" style="color: inherit; background: transparent; border: none;">
            <i class="bi bi-calendar-event-fill me-2"></i> Daftar Event
        </button>
    </li>
</ul>

<div class="tab-content" id="promoEventTabContent">
    
    <div class="tab-pane fade show active" id="promo-pane" role="tabpanel" aria-labelledby="promo-tab" tabindex="0">
        <div class="admin-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Data Promo Aktif</h5>
                <button class="btn btn-admin btn-sm px-3 rounded-pill" data-bs-toggle="modal" data-bs-target="#modalTambahPromo">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Promo
                </button>
            </div>
            
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Banner</th>
                            <th width="20%">Judul Promo</th>
                            <th width="15%">Badge Teks</th>
                            <th width="25%">Deskripsi</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allPromo as $index => $promo)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if($promo->gambar)
                                    <img src="{{ asset($promo->gambar) }}" alt="Promo" class="img-fluid rounded" style="max-height: 50px; object-fit: cover;">
                                @else
                                    <span class="text-muted small">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td class="fw-bold">{{ $promo->judul }}</td>
                            <td><span class="badge bg-secondary">{{ $promo->badge_teks }}</span></td>
                            <td>{{ Str::limit($promo->deskripsi, 50) }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-admin" data-bs-toggle="modal" data-bs-target="#modalEditPromo{{ $promo->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalHapusPromo{{ $promo->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada data promo saat ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="event-pane" role="tabpanel" aria-labelledby="event-tab" tabindex="0">
        <div class="admin-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Jadwal Event Mendatang</h5>
                <button class="btn btn-admin btn-sm px-3 rounded-pill" data-bs-toggle="modal" data-bs-target="#modalTambahEvent">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Event
                </button>
            </div>
            
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Banner</th>
                            <th width="20%">Judul Event</th>
                            <th width="15%">Badge Teks</th>
                            <th width="25%">Deskripsi</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allEvent as $index => $event)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if($event->gambar)
                                    <img src="{{ asset($event->gambar) }}" alt="Event" class="img-fluid rounded" style="max-height: 50px; object-fit: cover;">
                                @else
                                    <span class="text-muted small">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td class="fw-bold">{{ $event->judul }}</td>
                            <td><span class="badge bg-info text-dark">{{ $event->badge_teks }}</span></td>
                            <td>{{ Str::limit($event->deskripsi, 50) }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-admin" data-bs-toggle="modal" data-bs-target="#modalEditEvent{{ $event->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalHapusEvent{{ $event->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada jadwal event saat ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="modalTambahPromo" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold"><i class="bi bi-tags-fill text-warning me-2"></i>Tambah Promo Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('promo.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Judul Promo</label>
                        <input type="text" name="judul" class="form-control bg-secondary text-white border-0" required placeholder="Contoh: Diskon Akhir Tahun">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="form-control bg-secondary text-white border-0" required placeholder="Detail syarat & ketentuan promo..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Badge Teks</label>
                        <input type="text" name="badge_teks" class="form-control bg-secondary text-white border-0" value="Promo Terbatas" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Link Aksi</label>
                        <input type="text" name="link_aksi" class="form-control bg-secondary text-white border-0" value="/order" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Gambar Banner Promo (Opsional)</label>
                        <input type="file" name="gambar" class="form-control bg-secondary text-white border-0">
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-sm btn-outline-secondary text-white" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-admin px-3">Simpan Promo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahEvent" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold"><i class="bi bi-calendar-event-fill text-info me-2"></i>Tambah Event Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Judul Event</label>
                        <input type="text" name="judul" class="form-control bg-secondary text-white border-0" required placeholder="Contoh: Live Music Akustik">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="form-control bg-secondary text-white border-0" required placeholder="Detail mengenai event..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Badge Teks</label>
                        <input type="text" name="badge_teks" class="form-control bg-secondary text-white border-0" value="Sabtu Malam" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Link Aksi</label>
                        <input type="text" name="link_aksi" class="form-control bg-secondary text-white border-0" value="/reservasi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Gambar Banner Event (Opsional)</label>
                        <input type="file" name="gambar" class="form-control bg-secondary text-white border-0">
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-sm btn-outline-secondary text-white" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-admin px-3">Simpan Event</button>
                </div>
            </form>
        </div>
    </div>
</div>


@foreach($allPromo as $promo)
<div class="modal fade" id="modalEditPromo{{ $promo->id }}" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square text-warning me-2"></i>Edit Promo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('promo.update', $promo->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Judul Promo</label>
                        <input type="text" name="judul" class="form-control bg-secondary text-white border-0" value="{{ $promo->judul }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="form-control bg-secondary text-white border-0" required>{{ $promo->deskripsi }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Badge Teks</label>
                        <input type="text" name="badge_teks" class="form-control bg-secondary text-white border-0" value="{{ $promo->badge_teks }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Link Aksi</label>
                        <input type="text" name="link_aksi" class="form-control bg-secondary text-white border-0" value="{{ $promo->link_aksi }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Ubah Gambar Banner (Kosongkan jika tidak diganti)</label>
                        <input type="file" name="gambar" class="form-control bg-secondary text-white border-0">
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

<div class="modal fade" id="modalHapusPromo{{ $promo->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content bg-dark text-white border-danger">
            <div class="modal-body text-center pt-4">
                <i class="bi bi-exclamation-triangle-fill text-danger display-5 mb-3"></i>
                <p class="mb-4">Apakah kamu yakin ingin menghapus promo <strong>{{ $promo->judul }}</strong>?</p>
                <form action="{{ route('promo.destroy', $promo->id) }}" method="POST">
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


@foreach($allEvent as $event)
<div class="modal fade" id="modalEditEvent{{ $event->id }}" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square text-info me-2"></i>Edit Event</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('event.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Judul Event</label>
                        <input type="text" name="judul" class="form-control bg-secondary text-white border-0" value="{{ $event->judul }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="form-control bg-secondary text-white border-0" required>{{ $event->deskripsi }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Badge Teks</label>
                        <input type="text" name="badge_teks" class="form-control bg-secondary text-white border-0" value="{{ $event->badge_teks }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Link Aksi</label>
                        <input type="text" name="link_aksi" class="form-control bg-secondary text-white border-0" value="{{ $event->link_aksi }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Ubah Gambar Banner (Kosongkan jika tidak diganti)</label>
                        <input type="file" name="gambar" class="form-control bg-secondary text-white border-0">
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

<div class="modal fade" id="modalHapusEvent{{ $event->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content bg-dark text-white border-danger">
            <div class="modal-body text-center pt-4">
                <i class="bi bi-exclamation-triangle-fill text-danger display-5 mb-3"></i>
                <p class="mb-4">Apakah kamu yakin ingin menghapus event <strong>{{ $event->judul }}</strong>?</p>
                <form action="{{ route('event.destroy', $event->id) }}" method="POST">
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

@push('admin_styles')
<style>
    .nav-tabs .nav-link.active {
        border-bottom: 3px solid #f5d5b8 !important;
        color: #f5d5b8 !important;
    }
    .nav-tabs .nav-link:hover {
        color: #ffffff;
    }
    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.4) !important;
    }
</style>
@endpush

@endsection