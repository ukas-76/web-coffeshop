    @extends('layouts.app')

    @section('title', 'Pesan Online | Roastory')

    @push('styles')
    <style>
    /* General Header */
    .page-header {
        background: linear-gradient(135deg, var(--text-dark) 0%, var(--primary-coffee) 100%);
        color: white;
        padding: 60px 0;
        text-align: center;
        border-radius: 0 0 30px 30px;
        position: relative;
        box-shadow: 0 10px 20px rgba(92, 61, 46, 0.1);
    }

    /* Order Box */
    .product-card {
        background: white; border-radius: 16px; padding: 16px;
        border: 1px solid rgba(0,0,0,0.05);
        display: flex; align-items: stretch; gap: 16px;
        transition: transform 0.2s, box-shadow 0.2s;
        margin-bottom: 16px;
    }
    .product-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(92, 61, 46, 0.08); }
    .product-img { width: 100px; height: 100px; object-fit: cover; border-radius: 12px; }
    .product-info { flex: 1; display: flex; flex-direction: column; justify-content: center; }
    .product-title { font-weight: 700; margin-bottom: 4px; font-size: 1.1rem; }
    .product-desc { font-size: 0.85rem; color: #6c757d; margin-bottom: 8px; line-height: 1.3;}
    .product-price { font-weight: 800; color: var(--primary-coffee); }

    .qty-btn {
        width: 32px; height: 32px; padding: 0;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-weight: bold; border: 1px solid var(--primary-coffee);
        background-color: white; color: var(--primary-coffee);
        transition: all 0.2s;
    }
    .qty-btn:hover { background-color: var(--primary-coffee); color: white; }
    .qty-val { width: 30px; text-align: center; font-weight: bold; }

    /* Cart Sidebar */
    .cart-sidebar {
        background: white; border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.05);
        padding: 24px; position: sticky; top: 100px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .cart-item { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.95rem; }
    .cart-item-title { font-weight: 600; }
    .cart-item-price { color: #666; font-size: 0.9rem; }

    .login-overlay {
        position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(8px);
        z-index: 999; display: flex; flex-direction: column;
        justify-content: center; align-items: center; border-radius: 20px;
    }
    </style>
    @endpush

    @section('content')
    <!-- Header Halaman -->
    <div class="page-header mb-5" style="margin-top: 76px;">
        <div class="container">
            <h1 class="fw-bold display-5 mb-2">Layanan Delivery & Pick-Up</h1>
            <p class="lead opacity-75">Nikmati perpaduan rasa yang kaya dan aroma yang memikat dalam setiap cangkir, diseduh khusus untuk menemani setiap momen spesial Anda.</p>
        </div>
    </div>

    <!-- Konten Utama: Order Online -->
    <main class="container mb-5 position-relative">
        <div class="login-overlay text-center p-4" id="loginProtectOverlay">
            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm mx-auto mb-4" style="width: 80px; height: 80px;">
                <i class="bi bi-lock-fill fs-1 text-kopi"></i>
            </div>
            <h3 class="fw-bold text-dark mb-3">Login Diperlukan</h3>
            <p class="text-secondary mb-4" style="max-width: 400px;">Anda harus masuk ke akun Anda terlebih dahulu untuk dapat melakukan pemesanan online.</p>
            <a href="{{ url('/login') }}" class="btn btn-kopi px-5 py-3 fw-bold rounded-pill btn-lg shadow-sm">Masuk Sekarang</a>
            <button class="btn btn-link text-muted mt-3 small text-decoration-none" onclick="document.getElementById('loginProtectOverlay').style.display = 'none';">
                [Mode Pratinjau: Sembunyikan Dialog]
            </button>
        </div>

        <div class="row g-4">
            
            <!-- Daftar Produk -->
    <!-- Daftar Produk Dinamis dari Database -->
    <div class="col-lg-8">
        
        <!-- Bagian Kopi / Semua Menu -->
        <div class="d-flex justify-content-between align-items-end mb-4 border-bottom pb-2">
            <h3 class="fw-bold text-kopi mb-0"><i class="bi bi-cup-hot me-2"></i> Menu Roastory</h3>
        </div>

        @foreach($daftarMenu as $menu)
            <div class="product-card" data-id="{{ $menu->id }}" data-price="{{ $menu->harga }}" data-name="{{ $menu->nama_menu }}">
                <!-- Pastikan kolom gambar sesuai dengan nama kolom di database kamu (misal: gambar/foto) -->
                <img src="{{ $menu->gambar ? asset('storage/' . $menu->gambar) : 'https://images.unsplash.com/photo-1559525839-b184a4d698c7?ixlib=rb-4.0.3&w=600&q=80&auto=format&fit=crop' }}" alt="{{ $menu->nama_menu }}" class="product-img">
                
                <div class="product-info">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="product-title">{{ $menu->nama_menu }}</h4>
                            <p class="product-desc d-none d-sm-block">{{ $menu->deskripsi }}</p>
                        </div>
                    </div>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <span class="product-price fs-5">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                        <div class="d-flex align-items-center">
                            <button class="btn qty-btn minus-btn" type="button"><i class="bi bi-dash"></i></button>
                            <span class="qty-val">0</span>
                            
                            <!-- Kita bisa manfaatkan kolom 'stok' baru untuk membatasi tombol tambah -->
                            <button class="btn qty-btn plus-btn" type="button"><i class="bi bi-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

            <!-- Keranjang -->
            <div class="col-lg-4">
                <div class="cart-sidebar">
                    <h4 class="fw-bold mb-4 d-flex align-items-center gap-2 border-bottom pb-3">
                        <i class="bi bi-bag-check text-kopi"></i> Keranjang Anda
                    </h4>
                    
                    <div id="cart-items" class="mb-4">
                        <div class="text-center text-muted py-4 small" id="empty-cart-msg">
                            <i class="bi bi-cart-x fs-1 d-block mb-2 opacity-50"></i>
                            Belum ada pesanan dalam keranjang Anda.
                        </div>
                        <!-- Items injected by JS -->
                    </div>

                    <div class="border-top pt-3 mb-4 d-none" id="cart-summary">
                        <div class="d-flex justify-content-between mb-2 text-muted small">
                            <span>Subtotal</span>
                            <span id="cart-subtotal">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 text-muted small">
                            <span>Pajak (10%)</span>
                            <span id="cart-tax">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 text-muted small">
                            <span>Biaya Layanan</span>
                            <span>Rp 3.000</span>
                        </div>
                        <div class="d-flex justify-content-between mt-3 pt-3 border-top">
                            <span class="fw-bold fs-5 text-dark">Total</span>
                            <span class="fw-bold fs-5 text-kopi" id="cart-total">Rp 0</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-2">Opsi Pengiriman</label>
                        <select class="form-select mb-3 rounded-3 bg-light" id="opsi-pengiriman">
                            <option value="pickup">Ambil di Toko (Pick-up)</option>
                            <option value="delivery">Kirim ke Alamat (Delivery)</option>
                        </select>
                    </div>

                    <button class="btn btn-kopi w-100 py-3 rounded-pill fw-bold shadow-sm" id="checkout-btn" disabled>
                        Pesan Sekarang <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </div>
            </div>

        </div>
    </main>
    @endsection

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // 1. Ambil elemen overlay lock login
            const overlay = document.getElementById('loginProtectOverlay');
            
            // 2. Ambil status login asli langsung dari server Laravel Auth
            const isUserLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
            
            // 3. Logika Kunci Otomatis Real-Time
            if (isUserLoggedIn) {
                if (overlay) overlay.style.display = 'none';
            } else {
                if (overlay) overlay.style.display = 'flex';
            }

            // --- Sisa Logika Fitur Keranjang Belanja ---
            const products = document.querySelectorAll('.product-card');
            const cartItemsContainer = document.getElementById('cart-items');
            const emptyCartMsg = document.getElementById('empty-cart-msg');
            const cartSummary = document.getElementById('cart-summary');
            const subtotalEl = document.getElementById('cart-subtotal');
            const taxEl = document.getElementById('cart-tax');
            const totalEl = document.getElementById('cart-total');
            const checkoutBtn = document.getElementById('checkout-btn');
            const opsiPengirimanSelect = document.getElementById('opsi-pengiriman');

            let cart = {};

            products.forEach(p => {
                const minusBtn = p.querySelector('.minus-btn');
                const plusBtn = p.querySelector('.plus-btn');
                const qtyVal = p.querySelector('.qty-val');
                const name = p.dataset.name;
                const id = p.dataset.id; // Ambil ID Menu dari database
                const price = parseInt(p.dataset.price);

                plusBtn.addEventListener('click', () => {
                    let qty = parseInt(qtyVal.textContent);
                    

                    qty++;
                    qtyVal.textContent = qty;
                    updateCart(id, name, price, qty);
                });

                minusBtn.addEventListener('click', () => {
                    let qty = parseInt(qtyVal.textContent);
                    if(qty > 0) {
                        qty--;
                        qtyVal.textContent = qty;
                        updateCart(id, name, price, qty);
                    }
                });
            });

            function updateCart(id, name, price, qty) {
                if(qty === 0) {
                    delete cart[id]; // Hapus berdasarkan ID unik menu
                } else {
                    cart[id] = { name, price, qty };
                }
                renderCart();
            }

            function renderCart() {
                cartItemsContainer.innerHTML = '';
                let subtotal = 0;
                
                const ids = Object.keys(cart);
                if(ids.length === 0) {
                    cartItemsContainer.appendChild(emptyCartMsg);
                    emptyCartMsg.style.display = 'block';
                    cartSummary.classList.add('d-none');
                    checkoutBtn.disabled = true;
                    return;
                }

                emptyCartMsg.style.display = 'none';
                cartSummary.classList.remove('d-none');
                checkoutBtn.disabled = false;

                ids.forEach(id => {
                    const item = cart[id];
                    const itemTotal = item.price * item.qty;
                    subtotal += itemTotal;
                    
                    const div = document.createElement('div');
                    div.className = 'cart-item align-items-center pb-2 border-bottom mb-2';
                    div.innerHTML = `
                        <div class="lh-sm">
                            <div class="cart-item-title">${item.name}</div>
                            <div class="cart-item-price text-kopi fw-bold">${item.qty} x Rp ${item.price.toLocaleString('id-ID')}</div>
                        </div>
                        <div class="fw-bold">Rp ${itemTotal.toLocaleString('id-ID')}</div>
                    `;
                    cartItemsContainer.appendChild(div);
                });

                const tax = subtotal * 0.10;
                const total = subtotal + tax + 3000;

                subtotalEl.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
                taxEl.textContent = 'Rp ' + tax.toLocaleString('id-ID');
                totalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
            }

            // KODE BARU: Kirim data asli ke database backend (Menuju Tabel Reservasi)
            checkoutBtn.addEventListener('click', () => {
                checkoutBtn.disabled = true;
                checkoutBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...`;

                const rawTotal = parseInt(totalEl.textContent.replace(/[^0-9]/g, ''));
                const jenisPesanan = opsiPengirimanSelect.value; // 'delivery' atau 'pickup'

                // Bungkus data menu yang dibeli untuk disimpan ke detail_reservasi nanti
                const itemsOrdered = Object.keys(cart).map(id => ({
                    menu_id: id,
                    jumlah: cart[id].qty,
                    subtotal: cart[id].price * cart[id].qty
                }));

                const payload = {
                    jenis_pesanan: jenisPesanan,
                    total_tamu: rawTotal, // Menyimpan total bayar di field total_tamu sesuai rancangan terpadu kamu
                    items: itemsOrdered,
                    _token: '{{ csrf_token() }}' // Wajib disertakan untuk keamanan Laravel
                };

                // Kirim data transaksi via AJAX POST ke controller
                fetch("{{ route('order.checkout') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify(payload)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Redirect langsung ke halaman pembayaran dengan membawa nominal total bayar asli
                        window.location.href = "{{ url('/payment') }}?amount=" + rawTotal + "&reservasi_id=" + data.reservasi_id;
                    } else {
                        alert('Gagal menyimpan pesanan: ' + (data.message || 'Silakan coba lagi.'));
                        checkoutBtn.disabled = false;
                        checkoutBtn.innerHTML = `Pesan Sekarang <i class="bi bi-arrow-right ms-2"></i>`;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan jaringan.');
                    checkoutBtn.disabled = false;
                    checkoutBtn.innerHTML = `Pesan Sekarang <i class="bi bi-arrow-right ms-2"></i>`;
                });
            });
        });
    </script>
    @endpush
