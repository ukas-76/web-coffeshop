<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pelanggan | Kopi Kenangan Kita</title>

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
            background-image: linear-gradient(rgba(45, 36, 32, 0.2), rgba(45, 36, 32, 0.4)), url('https://images.unsplash.com/photo-1541167760496-1628856ab772?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80');
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
            padding: 14px 16px;
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

                <!-- Kolom Gambar (Hanya tampil di layar besar) -->
                <div class="col-md-6 d-none d-md-block login-image">
                    <div class="login-image-content">
                        <div class="badge bg-white text-dark mb-3 rounded-pill px-3 py-2 fw-bold shadow-sm">
                            <i class="bi bi-star-fill text-warning me-1"></i> Member Eksklusif
                        </div>
                        <h2 class="fw-bold mb-2">Kopi Kenangan Kita</h2>
                        <p class="opacity-75 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>

                <!-- Kolom Formulir -->
                <div class="col-md-6 p-4 p-lg-5 d-flex flex-column justify-content-center">
                    <div class="text-center mb-5">
                        <a href="{{ url('/') }}" class="text-decoration-none d-inline-block">
                            <div class="bg-kopi text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 shadow-sm" style="width: 60px; height: 60px;">
                                <i class="bi bi-cup-hot-fill fs-3"></i>
                            </div>
                        </a>
                        <h3 class="fw-bold text-dark">Login Account</h3>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    </div>

                    <form action="{{ url('/') }}">
                        <!-- Input Email -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold text-dark">Alamat Email</label>
                            <input type="email" class="form-control" id="email" placeholder="contoh: nama@email.com" required>
                        </div>

                        <!-- Input Password -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label for="password" class="form-label fw-bold text-dark mb-0">Kata Sandi</label>
                                <a href="#" class="text-kopi text-decoration-none small fw-semibold">Lupa Sandi?</a>
                            </div>
                            <input type="password" class="form-control" id="password" placeholder="Masukkan kata sandi Anda" required>
                        </div>

                        <!-- Ingat Saya -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="ingatSaya">
                            <label class="form-check-label text-muted" for="ingatSaya">
                                Ingat masuk di perangkat ini
                            </label>
                        </div>

                        <!-- Tombol Login -->
                        <button type="submit" class="btn btn-kopi w-100 py-3 mb-4 rounded-pill fw-bold fs-6 shadow-sm">
                            Masuk <i class="bi bi-box-arrow-in-right ms-2"></i>
                        </button>
                    </form>

                    <div class="text-center mt-auto">
                        <p class="text-muted mb-2">Belum menjadi anggota? <a href="{{ url('/register') }}" class="text-kopi fw-bold text-decoration-none">Daftar sekarang</a></p>
                        <a href="{{ url('/') }}" class="text-secondary text-decoration-none small"><i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda</a>
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
                    e.preventDefault();
                    localStorage.setItem('isLoggedIn', 'true');
                    window.location.href = "{{ url('/reservasi') }}";
                });
            }
        });
    </script>
</body>
</html>
