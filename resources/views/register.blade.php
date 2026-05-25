<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru | Roastory</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-coffee: #5c3d2e;
            --secondary-coffee: #d4b59d;
            --bg-warm: #fdfbf7;
            --text-dark: #2d2420;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-warm);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }

        .login-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(92, 61, 46, 0.08);
            border: 1px solid rgba(0,0,0,0.05);
            overflow: hidden;
            width: 100%;
            max-width: 1000px;
        }

        /* Warna khas Cafe */
        .text-kopi { color: var(--primary-coffee); }
        .bg-kopi { background-color: var(--primary-coffee); color: white; }

        .btn-kopi {
            background-color: var(--primary-coffee);
            color: white;
            border: 2px solid var(--primary-coffee);
            transition: all 0.3s ease;
        }

        .btn-kopi:hover {
            background-color: transparent;
            color: var(--primary-coffee);
            transform: translateY(-2px);
        }

        .login-image {
            background-image: linear-gradient(rgba(45, 36, 32, 0.4), rgba(45, 36, 32, 0.6)), url('https://images.unsplash.com/photo-1511920170033-f8396924c348?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80');
            background-size: cover;
            background-position: center;
            min-height: 100%;
            position: relative;
        }

        .login-image-content {
            position: absolute;
            bottom: 40px;
            left: 40px;
            right: 40px;
            color: white;
            z-index: 2;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            border: 1px solid #dee2e6;
            background-color: var(--bg-warm);
        }
        
        .form-control:focus {
            border-color: var(--primary-coffee);
            box-shadow: 0 0 0 0.25rem rgba(92, 61, 46, 0.25);
            background-color: white;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="login-card mx-auto">
            <div class="row g-0 align-items-stretch">

                <!-- Kolom Formulir -->
                <div class="col-md-7 p-4 p-lg-5 order-2 order-md-1 d-flex flex-column justify-content-center">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-dark">Buat Akun Baru</h3>
                        <p class="text-muted small">Gabung sekarang dan nikmati berbagai promo menarik.</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger pb-0 rounded-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="/register" method="POST">
                        @csrf 

                        <div class="mb-3">
                            <label for="nama" class="form-label fw-bold text-dark small">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Sesuai KTP" value="{{ old('nama') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold text-dark small">Alamat Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="contoh: nama@email.com" value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold text-dark small">Nomor Handphone (WhatsApp)</label>
                            <input type="tel" class="form-control" id="phone" name="nomor_telepon" placeholder="0812xxxxxx" value="{{ old('nomor_telepon') }}" required>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <label for="password" class="form-label fw-bold text-dark small">Kata Sandi</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 Karakter" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="confirm" class="form-label fw-bold text-dark small">Konfirmasi Sandi</label>
                                <input type="password" class="form-control" id="confirm" name="password_confirmation" placeholder="Ulangi Sandi" required>
                            </div>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label text-muted small" for="terms">
                                Saya setuju dengan <a href="#" class="text-kopi text-decoration-none">Syarat & Ketentuan</a> serta <a href="#" class="text-kopi text-decoration-none">Kebijakan Privasi</a>.
                            </label>
                        </div>

                        <button type="submit" class="btn btn-kopi w-100 py-3 mb-4 rounded-pill fw-bold fs-6 shadow-sm">
                            Daftar Sekarang <i class="bi bi-person-plus ms-2"></i>
                        </button>
                    </form>

                    <div class="text-center mt-auto">
                        <p class="text-muted mb-2">Sudah punya akun? <a href="{{ route('login') }}" class="text-kopi fw-bold text-decoration-none">Masuk di sini</a></p>
                        <a href="{{ url('/') }}" class="text-secondary text-decoration-none small"><i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda</a>
                    </div>
                </div>

                <!-- Kolom Gambar (Hanya tampil di layar besar) -->
                <div class="col-md-5 d-none d-md-block login-image order-1 order-md-2">
                    <div class="login-image-content text-end">
                        <div class="badge bg-white text-dark mb-3 rounded-pill px-3 py-2 fw-bold shadow-sm d-inline-block">
                            <i class="bi bi-gift-fill text-danger me-1"></i> Poin Gratis Pertama!
                        </div>
                        <h2 class="fw-bold mb-2">Member Roastory</h2>
                        <p class="opacity-75 mb-0 ms-auto" style="max-width: 250px;">Bergabunglah dengan komunitas kami dan nikmati berbagai keuntungan serta promo eksklusif.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const formObj = document.querySelector('form');
            if (formObj) {
                formObj.addEventListener('submit', function (e) {
                    const pass = document.getElementById('password').value;
                    const confirm = document.getElementById('confirm').value;
                    
                    if(pass !== confirm) {
                        e.preventDefault(); // Cegah submit hanya jika password tidak sama
                        alert('Kata sandi dan konfirmasi sandi tidak cocok!');
                    }
                    // Jika sama, biarkan form terkirim ke server Laravel (action="/register")
                });
            }
        });
    </script>
</body>
</html>

