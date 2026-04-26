@extends('layouts.app')

@section('title', 'Kopi Kenangan Kita | Profil Saya')

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

.avatar-edit-btn {
    position: absolute;
    bottom: 10px;
    right: calc(50% - 60px);
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

.tier-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 15px;
    background: linear-gradient(135deg, #ffd700, #ffb300);
    color: #4a3500;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.85rem;
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
.b-status { font-size: 0.8rem; padding: 4px 8px; border-radius: 6px; font-weight: bold; }
.b-success { background-color: #d4edda; color: #155724; }
.b-warning { background-color: #fff3cd; color: #856404; }
</style>
@endpush

@section('content')
<main class="container my-5 flex-grow-1">
    
    <!-- Profile Header -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="profile-cover shadow-sm"></div>
            <div class="profile-avatar-container">
                <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=5c3d2e&color=fff&size=150" alt="Profil Pengguna" class="profile-avatar">
                <div class="avatar-edit-btn" title="Ubah Foto Profil">
                    <i class="bi bi-camera-fill"></i>
                </div>
                <h2 class="fw-bold mt-3 mb-1">Budi Santoso</h2>
                <p class="text-secondary mb-2">budi.santoso@example.com <span class="mx-2">•</span> +628123456789</p>
                <div class="tier-badge">
                    <i class="bi bi-star-fill"></i> Gold Member
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
                        <a href="{{ url('/') }}" class="profile-menu-link text-danger" id="logoutBtnProfile">
                            <i class="bi bi-box-arrow-right text-danger"></i> Keluar
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Content Area -->
        <div class="col-lg-9">
            
            <!-- TAB: INFO -->
            <div id="tab-info" class="profile-tab-pane active">
                <!-- Highlight Stats -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4"><div class="stat-badge"><div class="stat-value">1,250</div><div class="stat-label">Poin Kenangan</div></div></div>
                    <div class="col-md-4"><div class="stat-badge"><div class="stat-value">24</div><div class="stat-label">Total Pesanan</div></div></div>
                    <div class="col-md-4"><div class="stat-badge"><div class="stat-value">5</div><div class="stat-label">Reservasi Tuntas</div></div></div>
                </div>

                <!-- Form Profile -->
                <div class="card-custom p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                        <h4 class="fw-bold mb-0 text-kopi">Informasi Pribadi</h4>
                        <button class="btn btn-outline-kopi rounded-pill px-4 py-2 btn-sm"><i class="bi bi-pencil-square me-2"></i>Edit</button>
                    </div>
                    <form>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary text-uppercase" style="font-size: 0.8rem;">Nama Depan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" value="Budi" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary text-uppercase" style="font-size: 0.8rem;">Nama Belakang</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" value="Santoso" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary text-uppercase" style="font-size: 0.8rem;">Email Registrasi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" value="budi.santoso@example.com" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary text-uppercase" style="font-size: 0.8rem;">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="tel" class="form-control" value="+628123456789" readonly>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TAB: ORDERS -->
            <div id="tab-orders" class="profile-tab-pane">
                <div class="card-custom p-4 p-md-5">
                    <h4 class="fw-bold mb-4 pb-3 border-bottom text-kopi">Riwayat Pesanan (Delivery/Pick-up)</h4>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Tanggal</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold">#ORD-9088</td>
                                    <td class="text-muted small">24 Apr 2026</td>
                                    <td>2x Kopsus Aren, 1x Croissant</td>
                                    <td class="fw-bold">Rp 68.000</td>
                                    <td><span class="b-status b-success">Selesai</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">#ORD-8942</td>
                                    <td class="text-muted small">12 Mar 2026</td>
                                    <td>1x Matcha Sakura Latte</td>
                                    <td class="fw-bold">Rp 28.000</td>
                                    <td><span class="b-status b-success">Selesai</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">#ORD-8110</td>
                                    <td class="text-muted small">20 Feb 2026</td>
                                    <td>3x Cappuccino Hangat</td>
                                    <td class="fw-bold">Rp 78.000</td>
                                    <td><span class="b-status b-success">Selesai</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB: RESERVATIONS -->
            <div id="tab-reservations" class="profile-tab-pane">
                <div class="card-custom p-4 p-md-5">
                    <h4 class="fw-bold mb-4 pb-3 border-bottom text-kopi">Riwayat Reservasi Meja</h4>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode Booking</th>
                                    <th>Waktu Temu</th>
                                    <th>Lokasi Meja</th>
                                    <th>DP Dibayar</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold">#RES-2933</td>
                                    <td>
                                        <div class="fw-bold">Besok, 18:00</div>
                                        <div class="small text-muted">27 Apr 2026</div>
                                    </td>
                                    <td>Indoor Sofa Premium (4 Org)</td>
                                    <td class="fw-bold text-success">Rp 100.000</td>
                                    <td><span class="b-status b-warning text-dark">Akan Datang</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">#RES-1402</td>
                                    <td>
                                        <div class="fw-bold">14:00</div>
                                        <div class="small text-muted">05 Jan 2026</div>
                                    </td>
                                    <td>Outdoor Balcony (2 Org)</td>
                                    <td class="fw-bold text-success">Rp 100.000</td>
                                    <td><span class="b-status b-success">Selesai</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // Tab Switcher Logic
        const menuLinks = document.querySelectorAll('.profile-menu-link[data-target]');
        const tabPanes = document.querySelectorAll('.profile-tab-pane');

        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                // Remove active classes
                menuLinks.forEach(l => l.classList.remove('active'));
                tabPanes.forEach(t => t.classList.remove('active'));

                // Add active to clicked link
                this.classList.add('active');
                
                // Show targeted tab
                const targetId = this.getAttribute('data-target');
                document.getElementById(targetId).classList.add('active');
            });
        });

        // Logout Logic
        const logoutBtnProfile = document.getElementById('logoutBtnProfile');
        if (logoutBtnProfile) {
            logoutBtnProfile.addEventListener('click', function(e) {
                e.preventDefault();
                localStorage.setItem('isLoggedIn', 'false');
                window.location.href = "{{ url('/') }}";
            });
        }
    });
</script>
@endpush
@endsection
