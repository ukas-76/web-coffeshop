@extends('layouts.app')

@section('title', 'Roastory | Profil Saya')

@push('styles')
<style>
/* Profile Layout */
.profile-cover {
    height: 200px;
    background: linear-gradient(135deg, var(--secondary-coffee), var(--primary-coffee));
    border-radius: 20px;
    margin-bottom: -80px;
    position: relative;
    overflow: hidden;
    margin-top: 50px;
}

.profile-cover::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');
}

.profile-avatar-container {
    text-align: center;
    position: relative;
    z-index: 2;
}

.profile-avatar {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 6px solid var(--bg-warm);
    object-fit: cover;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    background-color: white;
}

.avatar-edit-label {
    position: absolute;
    bottom: 5px;
    right: 5px;
    background-color: var(--primary-coffee);
    color: white;
    border: 3px solid var(--bg-warm);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.avatar-edit-label:hover {
    background-color: var(--secondary-coffee);
    transform: scale(1.05);
}

.card-custom {
    border: none;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(92, 61, 46, 0.05);
    background-color: white;
}

/* Profile Menu */
.profile-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.profile-menu li {
    margin-bottom: 0.5rem;
}

.profile-menu-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 20px;
    color: var(--text-dark);
    text-decoration: none;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
}

.profile-menu-link i {
    font-size: 1.25rem;
    color: var(--accent-coffee);
    transition: all 0.3s ease;
}

.profile-menu-link:hover, .profile-menu-link.active {
    background-color: var(--bg-warm);
    color: var(--primary-coffee);
}

.profile-menu-link:hover i, .profile-menu-link.active i {
    color: var(--primary-coffee);
}

/* Forms */
.form-control, .form-select {
    border-radius: 12px;
    padding: 12px 15px;
    border: 1px solid rgba(92, 61, 46, 0.15);
}

.input-group-text {
    border-radius: 12px;
    border: 1px solid rgba(92, 61, 46, 0.15);
    background-color: var(--bg-warm);
    color: var(--primary-coffee);
}

/* Stats Badge */
.stat-badge {
    background-color: var(--bg-warm);
    border: 1px solid rgba(92, 61, 46, 0.1);
    border-radius: 16px;
    padding: 15px;
    text-align: center;
}
.stat-value {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--primary-coffee);
    margin-bottom: 5px;
}
.stat-label {
    font-size: 0.85rem;
    color: #6c757d;
    font-weight: 600;
}

/* TIER BADGE DYNAMIC STYLE */
.tier-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 18px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.85rem;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}
.tier-gold {
    background: linear-gradient(135deg, #ffd700, #ffb300);
    color: #4a3500;
}
.tier-silver {
    background: linear-gradient(135deg, #e3e4e5, #cbd5e1);
    color: #334155;
}
.tier-bronze {
    background: linear-gradient(135deg, #cd7f32, #b45309);
    color: #ffffff;
}

/* Dynamic Tabs */
.profile-tab-pane {
    display: none;
    animation: fadeIn 0.4s;
}
.profile-tab-pane.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Badge Status in Tables */
.b-status { font-size: 0.8rem; padding: 4px 8px; border-radius: 6px; font-weight: bold; text-transform: capitalize; }
.b-success { background-color: #d4edda; color: #155724; }
.b-warning { background-color: #fff3cd; color: #856404; }
.b-danger { background-color: #f8d7da; color: #721c24; }
</style>
@endpush

@section('content')
<main class="container my-5 flex-grow-1">
    
    <!-- Flash Message Notification -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Profile Header -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="profile-cover shadow-sm"></div>
            <div class="profile-avatar-container">
                <div style="position: relative; display: inline-block;">
                    
                    <!-- Avatar Preview Image -->
                    <img id="avatarPreview" 
                         src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->nama) . '&background=5c3d2e&color=fff&size=150' }}" 
                         alt="Profil Pengguna" 
                         class="profile-avatar">
                    
                    <!-- Form Hidden File Upload khusus Avatar -->
                    <form id="avatarForm" action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label for="avatarInput" class="avatar-edit-label" title="Ubah Foto Profil">
                            <i class="bi bi-camera-fill"></i>
                        </label>
                        <input type="file" id="avatarInput" name="avatar" accept="image/*" class="d-none">
                    </form>

                </div>
                <h2 class="fw-bold mt-3 mb-1">{{ $user->nama }}</h2>
                <p class="text-secondary mb-2">{{ $user->email }} <span class="mx-2">•</span> {{ $user->nomor_telepon ?? '-' }}</p>
                
                <!-- BADGE TIER MEMBER DINAMIS BERUBAH WARNA -->
                <div class="tier-badge {{ $tierBadgeClass }}">
                    <i class="bi bi-star-fill"></i> {{ $tierMember }}
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sidebar Navigation -->
        <div class="col-lg-3">
            <div class="card-custom p-3 h-100">
                <ul class="profile-menu">
                    <li>
                        <a class="profile-menu-link active" data-target="tab-info">
                            <i class="bi bi-person-fill"></i> Informasi Pribadi
                        </a>
                    </li>
                    <li>
                        <a class="profile-menu-link" data-target="tab-orders">
                            <i class="bi bi-bag-heart-fill"></i> Riwayat Pesanan
                        </a>
                    </li>
                    <li>
                        <a class="profile-menu-link" data-target="tab-reservations">
                            <i class="bi bi-calendar-check-fill"></i> Riwayat Reservasi
                        </a>
                    </li>
                    <li class="mt-4 border-top pt-3">
                        <a href="#" class="profile-menu-link text-danger" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right text-danger"></i> Keluar
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Content Area -->
        <div class="col-lg-9">
            
            <!-- TAB: INFO -->
            <div id="tab-info" class="profile-tab-pane active">
                <!-- Highlight Stats Dinamis -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4"><div class="stat-badge"><div class="stat-value">{{ number_format($poinRoastory) }}</div><div class="stat-label">Poin Roastory</div></div></div>
                    <div class="col-md-4"><div class="stat-badge"><div class="stat-value">{{ $totalPesanan }}</div><div class="stat-label">Total Pesanan</div></div></div>
                    <div class="col-md-4"><div class="stat-badge"><div class="stat-value">{{ $reservasiTuntas }}</div><div class="stat-label">Reservasi Tuntas</div></div></div>
                </div>

                <!-- Form Profile Info -->
                <div class="card-custom p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                        <h4 class="fw-bold mb-0" style="color: var(--primary-coffee);">Informasi Pribadi</h4>
                    </div>
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-secondary text-uppercase" style="font-size: 0.8rem;">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="name" class="form-control" value="{{ $user->nama }}" placeholder="Masukkan Nama Lengkap" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary text-uppercase" style="font-size: 0.8rem;">Email Registrasi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary text-uppercase" style="font-size: 0.8rem;">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="text" name="phone" class="form-control" value="{{ $user->nomor_telepon }}" placeholder="Masukkan Nomor Telepon">
                                </div>
                            </div>
                            <div class="col-12 text-end mt-4">
                                <button type="submit" class="btn btn-dark rounded-pill px-4 py-2" style="background-color: var(--primary-coffee); border: none;">
                                    <i class="bi bi-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TAB: ORDERS (Riwayat Pesanan) -->
            <div id="tab-orders" class="profile-tab-pane">
                <div class="card-custom p-4 p-md-5">
                    <h4 class="fw-bold mb-4 pb-3 border-bottom" style="color: var(--primary-coffee);">Riwayat Pesanan (Delivery/Pick-up)</h4>
                    <div class="table-responsive">
                        @if($riwayatPesanan->isEmpty())
                            <p class="text-muted text-center my-4">Belum ada riwayat pesanan online.</p>
                        @else
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID Pesanan</th>
                                        <th>Jenis</th>
                                        <th>Tanggal</th>
                                        <th>Total Belanja</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayatPesanan as $pesanan)
                                    <tr>
                                        <td class="fw-bold">#ORD-{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td><span class="badge bg-secondary text-capitalize">{{ $pesanan->jenis_pesanan }}</span></td>
                                        <td class="text-muted small">{{ $pesanan->created_at->format('d M Y, H:i') }}</td>
                                        <!-- Menggunakan total_tamu sesuai penamaan kolom databasemu -->
                                        <td class="fw-bold">Rp {{ number_format($pesanan->total_tamu, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="b-status 
                                                {{ $pesanan->status == 'selesai' ? 'b-success' : ($pesanan->status == 'dibatalkan' ? 'b-danger' : 'b-warning') }}">
                                                {{ $pesanan->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>

            <!-- TAB: RESERVATIONS (Riwayat Reservasi) -->
            <div id="tab-reservations" class="profile-tab-pane">
                <div class="card-custom p-4 p-md-5">
                    <h4 class="fw-bold mb-4 pb-3 border-bottom" style="color: var(--primary-coffee);">Riwayat Reservasi Meja (Dine In)</h4>
                    <div class="table-responsive">
                        @if($riwayatReservasi->isEmpty())
                            <p class="text-muted text-center my-4">Belum ada riwayat reservasi meja.</p>
                        @else
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kode Booking</th>
                                        <th>Tanggal Reservasi</th>
                                        <th>Jam Mulai</th>
                                        <th>Total DP / Biaya</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayatReservasi as $res)
                                    <tr>
                                        <td class="fw-bold">#RES-{{ str_pad($res->id, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td class="text-muted small">{{ \Carbon\Carbon::parse($res->tanggal_reservasi)->format('d M Y') }}</td>
                                        <td class="fw-bold">{{ $res->jam_mulai }} WIB</td>
                                        <!-- Menggunakan total_tamu sesuai penamaan kolom databasemu -->
                                        <td class="fw-bold">Rp {{ number_format($res->total_tamu, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="b-status 
                                                {{ $res->status == 'selesai' ? 'b-success' : ($res->status == 'dibatalkan' ? 'b-danger' : 'b-warning') }}">
                                                {{ $res->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. Tab Switcher Logic
        const menuLinks = document.querySelectorAll('.profile-menu-link[data-target]');
        const tabPanes = document.querySelectorAll('.profile-tab-pane');

        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                menuLinks.forEach(l => l.classList.remove('active'));
                tabPanes.forEach(t => t.classList.remove('active'));

                this.classList.add('active');
                const targetId = this.getAttribute('data-target');
                document.getElementById(targetId).classList.add('active');
            });
        });

        // 2. Avatar Instant Preview & Auto Submit
        const avatarInput = document.getElementById('avatarInput');
        const avatarPreview = document.getElementById('avatarPreview');
        const avatarForm = document.getElementById('avatarForm');

        if (avatarInput) {
            avatarInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    if (!file.type.startsWith('image/')) {
                        alert('Silakan pilih file gambar yang valid.');
                        return;
                    }
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        avatarPreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);

                    avatarForm.submit();
                }
            });
        }
    });
</script>
@endpush
@endsection