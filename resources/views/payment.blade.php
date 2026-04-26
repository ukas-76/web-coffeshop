@extends('layouts.app')

@section('title', 'Pembayaran | Kopi Kenangan Kita')

@push('styles')
<style>
/* Payment Styles */
.payment-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(92, 61, 46, 0.08);
    border: 1px solid rgba(0,0,0,0.05);
    overflow: hidden;
}

.payment-header {
    background: var(--bg-warm);
    padding: 24px;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.payment-body {
    padding: 32px;
}

.payment-method-card {
    border: 2px solid rgba(0,0,0,0.1);
    border-radius: 12px;
    padding: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 12px;
}

.payment-method-card:hover {
    background-color: var(--bg-warm);
}

.payment-method-card.selected {
    border-color: var(--primary-coffee);
    background-color: rgba(92, 61, 46, 0.05);
}

.payment-icon {
    width: 48px;
    height: 48px;
    background: white;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.btn-pay {
    background-color: var(--primary-coffee);
    color: white;
    border: none;
    padding: 16px;
    font-weight: 700;
    font-size: 1.1rem;
    border-radius: 12px;
    width: 100%;
    transition: all 0.3s ease;
}

.btn-pay:hover {
    background-color: var(--accent-coffee);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(92, 61, 46, 0.2);
}

.btn-pay:disabled {
    background-color: #cccccc;
    transform: none;
    box-shadow: none;
    cursor: not-allowed;
}

/* Success Modal Overlay */
#successOverlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255, 255, 255, 0.95);
    z-index: 1050;
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.success-icon-wrapper {
    width: 100px; height: 100px;
    background-color: #28a745;
    color: white;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 3rem;
    margin-bottom: 24px;
    animation: scaleIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

@keyframes scaleIn {
    0% { transform: scale(0); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}
</style>
@endpush

@section('content')
<main class="container py-5" style="margin-top: 80px; min-height: 80vh;">
    
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="payment-card">
                
                <div class="payment-header text-center">
                    <h5 class="fw-bold mb-1 text-kopi">Selesaikan Pembayaran</h5>
                    <p class="text-muted small mb-0">ID Transaksi: TRX-{{ mt_rand(10000, 99999) }}</p>
                </div>

                <div class="payment-body">
                    <!-- Ringkasan Tagihan -->
                    <div class="bg-light p-4 rounded-3 mb-4 text-center">
                        <span class="d-block text-muted small fw-bold mb-2">TOTAL TAGIHAN</span>
                        <h2 class="fw-bold text-dark mb-0" id="displayTotal">Rp 0</h2>
                    </div>

                    <h6 class="fw-bold mb-3">Pilih Metode Pembayaran</h6>

                    <!-- Metode 1: QRIS -->
                    <div class="payment-method-card" data-method="qris">
                        <div class="payment-icon text-kopi"><i class="bi bi-qr-code"></i></div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0">QRIS (Gopay, OVO, Dana)</h6>
                            <small class="text-muted">Pindai kode QR melalui aplikasi e-wallet Anda</small>
                        </div>
                        <div class="method-radio">
                            <i class="bi bi-circle text-muted fs-4"></i>
                        </div>
                    </div>

                    <!-- Metode 2: Virtual Account -->
                    <div class="payment-method-card" data-method="va">
                        <div class="payment-icon text-kopi"><i class="bi bi-bank"></i></div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0">Transfer Bank (Virtual Account)</h6>
                            <small class="text-muted">BCA, Mandiri, BNI, BRI</small>
                        </div>
                        <div class="method-radio">
                            <i class="bi bi-circle text-muted fs-4"></i>
                        </div>
                    </div>

                    <!-- Metode 3: Kartu Kredit -->
                    <div class="payment-method-card" data-method="cc">
                        <div class="payment-icon text-kopi"><i class="bi bi-credit-card"></i></div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-0">Kartu Kredit / Debit</h6>
                            <small class="text-muted">Visa, Mastercard, JCB</small>
                        </div>
                        <div class="method-radio">
                            <i class="bi bi-circle text-muted fs-4"></i>
                        </div>
                    </div>

                    <!-- Tombol Bayar -->
                    <button class="btn-pay mt-4" id="btnProsesBayar" disabled>
                        Pilih Metode Pembayaran
                    </button>
                    
                    <div class="text-center mt-3">
                        <a href="{{ url('/') }}" class="text-decoration-none text-muted small"><i class="bi bi-arrow-left me-1"></i> Batalkan & Kembali</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Overlay Sukses -->
    <div id="successOverlay">
        <div class="success-icon-wrapper shadow-lg">
            <i class="bi bi-check-lg"></i>
        </div>
        <h2 class="fw-bold text-dark mb-2">Pembayaran Berhasil!</h2>
        <p class="text-secondary mb-4 text-center px-4" style="max-width: 400px;">Terima kasih, tagihan Anda telah lunas. Pesanan/Reservasi Anda sedang kami proses.</p>
        <div class="spinner-border text-kopi" role="status" style="width: 1.5rem; height: 1.5rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="small text-muted mt-3">Mengarahkan ke dashboard...</p>
    </div>

</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Ambil nominal tagihan dari parameter URL atau gunakan default jika tidak ada
        const urlParams = new URLSearchParams(window.location.search);
        let tagihan = urlParams.get('amount');
        
        if (!tagihan) {
            // Default simulasi
            tagihan = Math.floor(Math.random() * (200000 - 50000 + 1) + 50000); 
        }

        document.getElementById('displayTotal').textContent = 'Rp ' + parseInt(tagihan).toLocaleString('id-ID');

        const methodCards = document.querySelectorAll('.payment-method-card');
        const btnProsesBayar = document.getElementById('btnProsesBayar');
        let selectedMethod = null;

        methodCards.forEach(card => {
            card.addEventListener('click', () => {
                // Reset semua
                methodCards.forEach(c => {
                    c.classList.remove('selected');
                    c.querySelector('.method-radio i').classList.replace('bi-check-circle-fill', 'bi-circle');
                    c.querySelector('.method-radio i').classList.replace('text-kopi', 'text-muted');
                });

                // Set yang dipilih
                card.classList.add('selected');
                card.querySelector('.method-radio i').classList.replace('bi-circle', 'bi-check-circle-fill');
                card.querySelector('.method-radio i').classList.replace('text-muted', 'text-kopi');

                selectedMethod = card.getAttribute('data-method');
                
                btnProsesBayar.disabled = false;
                btnProsesBayar.innerHTML = 'Bayar Sekarang <i class="bi bi-shield-lock-fill ms-2"></i>';
            });
        });

        btnProsesBayar.addEventListener('click', () => {
            if(!selectedMethod) return;

            // Efek Loading
            btnProsesBayar.disabled = true;
            btnProsesBayar.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Memproses...';

            // Simulasi proses API gateway (2 detik)
            setTimeout(() => {
                document.getElementById('successOverlay').style.display = 'flex';
                
                // Redirect setelah sukses (3 detik)
                setTimeout(() => {
                    window.location.href = "{{ url('/profile') }}";
                }, 3000);

            }, 2000);
        });
    });
</script>
@endpush
