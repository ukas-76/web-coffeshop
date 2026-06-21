@extends('layouts.app')

@section('title', 'Reservasi Meja | Roastory')

@push('styles')
<style>
/* General Header */
.page-header {
    background: linear-gradient(to right, rgba(45, 36, 32, 0.9), rgba(92, 61, 46, 0.8)), url('https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=1200&q=80&ixlib=rb-4.0.3');
    background-size: cover;
    background-position: center;
    color: white;
    padding: 80px 0;
    text-align: center;
    border-radius: 0 0 40px 40px;
    box-shadow: 0 10px 30px rgba(92, 61, 46, 0.15);
}

/* Sidebar/Booking Summary Form */
.cart-sidebar {
    background: white; border-radius: 20px;
    border: 1px solid rgba(0,0,0,0.05);
    padding: 24px; position: sticky; top: 100px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.form-control, .form-select {
    border-radius: 12px;
    padding: 12px 16px;
    border: 1px solid #dee2e6;
    background-color: var(--bg-warm);
}
.form-control:focus, .form-select:focus {
    border-color: var(--primary-coffee);
    box-shadow: 0 0 0 0.25rem rgba(92, 61, 46, 0.25);
    background-color: white;
}

/* Table Grid Radios */
.btn-check:checked + .table-card {
    border-color: var(--primary-coffee) !important;
    box-shadow: 0 0 0 3px rgba(92, 61, 46, 0.2) !important;
    background-color: rgba(92, 61, 46, 0.05) !important;
}

.btn-check:checked + .table-card .check-icon {
    display: flex !important;
}

.table-card {
    cursor: pointer;
    transition: all 0.2s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 2px solid transparent;
    background-color: white;
}
.table-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
}

.check-icon {
    position: absolute;
    top: 10px; right: 10px;
    background-color: var(--primary-coffee);
    color: white; border-radius: 50%; width: 32px; height: 32px;
    display: none; align-items: center; justify-content: center;
    z-index: 10;
}

/* Menu Item DP List */
.product-card {
    background: white; border-radius: 16px; padding: 12px;
    border: 1px solid rgba(0,0,0,0.05);
    display: flex; align-items: center; gap: 16px;
    transition: box-shadow 0.2s;
    margin-bottom: 12px;
}
.product-img { width: 80px; height: 80px; object-fit: cover; border-radius: 12px; }

.qty-btn {
    width: 32px; height: 32px; padding: 0;
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-weight: bold; border: 1px solid var(--primary-coffee);
    background-color: white; color: var(--primary-coffee);
}
.qty-btn:hover { background-color: var(--primary-coffee); color: white; }
.qty-val { width: 30px; text-align: center; font-weight: bold; }

/* Login Overlay */
.login-overlay {
    position: absolute; top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(8px);
    z-index: 999; display: flex; flex-direction: column;
    justify-content: center; align-items: center; border-radius: 20px;
}
</style>
@endpush

@section('content')
<div class="page-header mb-5" style="margin-top: 76px;">
    <div class="container">
        <h1 class="fw-bold display-5 mb-3">Reservasi Meja & Ruang</h1>
        <p class="lead opacity-90 mx-auto" style="max-width: 600px;">Nikmati perpaduan rasa yang kaya dan aroma yang memikat dalam setiap cangkir, diseduh khusus untuk menemani setiap momen spesial Anda.</p>
    </div>
</div>

<main class="container mb-5 position-relative">
    
    @guest
    <div class="login-overlay text-center p-4" id="loginProtectOverlay">
        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm mx-auto mb-4" style="width: 80px; height: 80px;">
            <i class="bi bi-lock-fill fs-1 text-kopi"></i>
        </div>
        <h3 class="fw-bold text-dark mb-3">Login Diperlukan</h3>
        <p class="text-secondary mb-4" style="max-width: 400px;">Anda harus masuk ke akun Anda terlebih dahulu untuk dapat melakukan reservasi meja.</p>
        <a href="{{ url('/login') }}" class="btn btn-kopi px-5 py-3 fw-bold rounded-pill btn-lg shadow-sm">Masuk Sekarang</a>
        <button class="btn btn-link text-muted mt-3 small text-decoration-none" onclick="document.getElementById('loginProtectOverlay').style.display = 'none';">
            [Mode Pratinjau: Sembunyikan Dialog]
        </button>
    </div>
    @endguest

    <div class="row g-4">
        <div class="col-lg-7 col-xl-8">
            
            <h3 class="fw-bold text-kopi d-flex align-items-center gap-2 mb-2 pb-2">
                <i class="bi bi-geo-alt"></i> 1. Pilih Lokasi Meja
            </h3>
            <p class="text-muted small mb-4">Silakan pilih lokasi tempat duduk Anda. Setiap meja memiliki ketentuan minimum DP pembelian yang berbeda.</p>

            <div class="row g-3 mb-5" id="tableGrid">
                @forelse($daftarMeja as $key => $meja)
                <div class="col-md-6">
                    <input type="radio" class="btn-check table-radio" name="mejaSelect" id="meja_{{ $meja->id }}" 
                           value="{{ $meja->nomor_meja }}" 
                           data-min="{{ $meja->min_dp ?? 0 }}" 
                           data-cap="{{ (int) filter_var($meja->kapasitas, FILTER_SANITIZE_NUMBER_INT) ?: 4 }}" 
                           autocomplete="off" {{ $key == 0 ? 'checked' : '' }}>
                    <label class="table-card p-0 text-start border rounded-4 overflow-hidden position-relative shadow-sm" for="meja_{{ $meja->id }}">
                        <div class="check-icon shadow-sm"><i class="bi bi-check-lg fs-5"></i></div>
                        
                        {{-- Menggunakan gambar default apabila kolom foto kosong --}}
                        <img src="{{ $meja->foto ? asset('storage/' . $meja->foto) : 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?w=800&q=80' }}" 
                             class="w-100 object-fit-cover" style="height: 160px;" alt="{{ $meja->nomor_meja }}">
                        
                        <div class="p-3 bg-white flex-grow-1 d-flex flex-column">
                            <h5 class="fw-bold mb-1">Meja {{ $meja->nomor_meja }}</h5>
                            <p class="text-muted small mb-3">Nikmati fasilitas area terbaik kami yang bersih, nyaman, dan ramah untuk menemani aktivitas produktif maupun waktu bersantai Anda.</p>
                            <ul class="list-unstyled small text-secondary mb-0 mt-auto">
                                <li class="mb-1"><i class="bi bi-people d-inline-block text-kopi me-2" style="width:16px"></i>Kapasitas: {{ $meja->kapasitas }}</li>
                                <li class="mb-1 fw-bold text-dark"><i class="bi bi-tag d-inline-block text-kopi me-2" style="width:16px"></i>Min. DP: Rp {{ number_format($meja->min_dp, 0, ',', '.') }}</li>
                            </ul>
                        </div>
                    </label>
                </div>
                @empty
                <div class="col-12 text-center py-4">
                    <p class="text-muted">Maaf, saat ini tidak ada meja yang berstatus tersedia.</p>
                </div>
                @endforelse
            </div>

            <h3 class="fw-bold text-kopi d-flex align-items-center gap-2 mb-2 pb-2 mt-5 border-top pt-4">
                <i class="bi bi-basket2"></i> 2. Menu Dihidangkan Pertama
            </h3>
            <p class="text-muted small mb-4">Tambahkan item untuk mencapai batas minimum DP meja Anda.</p>

            <h5 class="fw-bold fs-6 mb-3 mt-2 text-dark border-bottom pb-2">Daftar Menu Kafe</h5>
            
            @forelse($daftarMenu as $menu)
            <div class="product-card">
                <img src="{{ $menu->foto ? asset('storage/' . $menu->foto) : 'https://images.unsplash.com/photo-1541167760496-1628856ab772?w=600&q=80' }}" 
                     alt="{{ $menu->nama_menu }}" class="product-img">
                <div class="flex-grow-1 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-1">{{ $menu->nama_menu }}</h6>
                        <p class="text-muted small mb-1 d-none d-sm-block">{{ $menu->deskripsi ?? 'Pilihan hidangan spesial dari Roastory.' }}</p>
                        <span class="text-kopi fw-bold">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn qty-btn dp-minus" type="button"><i class="bi bi-dash"></i></button>
                        <span class="qty-val dp-val" data-price="{{ $menu->harga }}">0</span>
                        <button class="btn qty-btn dp-plus" type="button"><i class="bi bi-plus"></i></button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-3">
                <p class="text-muted">Menu belum tersedia.</p>
            </div>
            @endforelse

        </div>

        <div class="col-lg-5 col-xl-4">
            <div class="cart-sidebar">
                <h4 class="fw-bold border-bottom pb-3 mb-4">Status Reservasi</h4>
                
                <div class="bg-light p-3 rounded-3 mb-4 border">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="text-muted small">Spot:</span>
                        <span class="fw-bold text-end" id="sumMeja">-</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="text-muted small">Target DP:</span>
                        <span class="fw-bold text-danger text-end" id="sumMinDp">Rp 0</span>
                    </div>
                    <hr class="my-2 border-secondary">
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span class="fw-bold text-dark">DP Terkumpul:</span>
                        <span class="fw-bold fs-5 text-kopi" id="sumDpTotal">Rp 0</span>
                    </div>
                </div>

                <div id="dpAlert" class="alert alert-warning py-2 small fw-bold d-flex align-items-center mb-4">
                    <i class="bi bi-exclamation-triangle me-2 fs-5"></i> Nilai pesanan DP Anda belum memenuhi batas minimum meja!
                </div>

                <form id="reservationForm">
                    <p class="fw-bold mb-3 d-block"><i class="bi bi-person-lines-fill me-2"></i> 3. Data Diri & Waktu</p>
                    
                    <div class="mb-3">
                        <input type="text" class="form-control form-control-sm py-2 px-3 fs-6" 
                               placeholder="Nama Pemesan" 
                               value="{{ auth()->check() ? auth()->user()->nama : '' }}" 
                               required>
                    </div>
                    <div class="mb-3">
                        <input type="tel" class="form-control form-control-sm py-2 px-3 fs-6" 
                               placeholder="Nomor WhatsApp Aktif" 
                               value="{{ auth()->check() ? auth()->user()->nomor_telepon : '' }}" 
                               required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="small fw-semibold text-muted text-uppercase" style="font-size: 0.75rem;">Tanggal</label>
                            <input type="date" class="form-control form-control-sm py-2 px-3" min="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-6">
                            <label class="small fw-semibold text-muted text-uppercase" style="font-size: 0.75rem;">Waktu Kedatangan</label>
                            <input type="time" class="form-control form-control-sm py-2 px-3" required>
                        </div>
                        <div class="col-12 mt-2">
                            <label class="small fw-semibold text-muted text-uppercase" style="font-size: 0.75rem;">Berapa Orang?</label>
                            <input type="number" class="form-control form-control-sm py-2 px-3" id="jumlahOrang" placeholder="Jumlah Orang" min="1" required>
                            <div class="form-text mt-1" style="font-size: 0.75rem;" id="kapasitasText">Silakan pilih meja terlebih dahulu.</div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-kopi w-100 py-3 mt-2 rounded-pill fw-bold shadow-sm d-flex align-items-center justify-content-center" id="btnSubmit" disabled>
                        Bayar DP & Selesaikan <i class="bi bi-credit-card ms-2"></i>
                    </button>
                </form>
            </div>
        </div>

    </div>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const overlay = document.getElementById('loginProtectOverlay');
        const isUserLoggedIn = '{{ Auth::check() ? "true" : "false" }}' === 'true';
    
        if (isUserLoggedIn) {
            if (overlay) overlay.style.display = 'none';
        } else {
            if (overlay) overlay.style.display = 'flex';
        }

        const radios = document.querySelectorAll('.table-radio');
        const sumMeja = document.getElementById('sumMeja');
        const sumMinDp = document.getElementById('sumMinDp');
        const sumDpTotal = document.getElementById('sumDpTotal');
        const dpAlert = document.getElementById('dpAlert');
        const btnSubmit = document.getElementById('btnSubmit');
        const jumlahOrangInput = document.getElementById('jumlahOrang');
        const kapasitasText = document.getElementById('kapasitasText');

        let currentMinDP = 0;
        let currentTotalDP = 0;
        let currentCap = 1;

        function updateTableSelection() {
            const selected = document.querySelector('.table-radio:checked');
            if(!selected) return;

            const name = selected.value;
            currentMinDP = parseInt(selected.getAttribute('data-min')) || 0;
            currentCap = parseInt(selected.getAttribute('data-cap')) || 4;

            sumMeja.textContent = "Meja " + name;
            sumMinDp.textContent = 'Rp ' + currentMinDP.toLocaleString('id-ID');
            
            jumlahOrangInput.max = currentCap;
            if(parseInt(jumlahOrangInput.value) > currentCap) {
                jumlahOrangInput.value = currentCap;
            }
            kapasitasText.textContent = `Meja ini berkapasitas maksimal ${currentCap} orang.`;

            validateCheckout();
        }

        function calculateDPTotal() {
            let total = 0;
            document.querySelectorAll('.dp-val').forEach(el => {
                const price = parseInt(el.getAttribute('data-price')) || 0;
                const qty = parseInt(el.textContent) || 0;
                total += (price * qty);
            });
            currentTotalDP = total;
            sumDpTotal.textContent = 'Rp ' + currentTotalDP.toLocaleString('id-ID');
            
            validateCheckout();
        }

        function validateCheckout() {
            if(currentTotalDP >= currentMinDP) {
                dpAlert.className = 'alert alert-success py-2 small fw-bold d-flex align-items-center mb-4';
                dpAlert.innerHTML = '<i class="bi bi-check-circle-fill me-2 fs-5"></i> Syarat minimum uang muka terpenuhi!';
                btnSubmit.disabled = false;
            } else {
                dpAlert.className = 'alert alert-warning py-2 small fw-bold d-flex align-items-center mb-4';
                dpAlert.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i> Uang muka Anda belum memenuhi batas minimum meja (Kurang Rp ' + (currentMinDP - currentTotalDP).toLocaleString('id-ID') + ').';
                btnSubmit.disabled = true;
            }
        }

        radios.forEach(r => r.addEventListener('change', updateTableSelection));

        document.querySelectorAll('.dp-plus').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const valEl = e.currentTarget.parentElement.querySelector('.dp-val');
                let qty = parseInt(valEl.textContent) || 0;
                valEl.textContent = qty + 1;
                calculateDPTotal();
            });
        });

        document.querySelectorAll('.dp-minus').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const valEl = e.currentTarget.parentElement.querySelector('.dp-val');
                let qty = parseInt(valEl.textContent) || 0;
                if(qty > 0) {
                    valEl.textContent = qty - 1;
                    calculateDPTotal();
                }
            });
        });

        document.getElementById('reservationForm').addEventListener('submit', (e) => {
            e.preventDefault();
            window.location.href = "{{ url('/payment') }}?amount=" + currentTotalDP;
        });

        // Inisialisasi awal
        updateTableSelection();
        calculateDPTotal();
    });
</script>
@endpush