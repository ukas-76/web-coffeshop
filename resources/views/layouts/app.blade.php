<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Roastory')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @stack('styles')

    <style>
        :root {
            --primary-coffee: #5c3d2e;
            --secondary-coffee: #d4b59d;
            --accent-coffee: #8c6239;
            --bg-warm: #fdfbf7;
            --text-dark: #2d2420;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-warm);
            color: var(--text-dark);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Utilities */
        .text-kopi { color: var(--primary-coffee) !important; }
        .bg-kopi { background-color: var(--primary-coffee) !important; color: white; }
        .bg-kopi-light { background-color: var(--secondary-coffee) !important; color: var(--text-dark); }
        
        /* Navbar */
        .navbar-custom {
            background-color: rgba(253, 251, 247, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(92, 61, 46, 0.1);
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            font-weight: 800;
            letter-spacing: -0.5px;
            font-size: 1.5rem;
        }
        
        .nav-link {
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0.5rem;
            position: relative;
            transition: color 0.3s;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary-coffee);
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: var(--primary-coffee);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after, .nav-link.active::after {
            width: 80%;
        }

        /* Buttons */
        .btn-kopi {
            background-color: var(--primary-coffee);
            color: white;
            border: 2px solid var(--primary-coffee);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-kopi:hover {
            background-color: transparent;
            color: var(--primary-coffee);
        }
        
        .btn-outline-kopi {
            background-color: transparent;
            color: var(--primary-coffee);
            border: 2px solid var(--primary-coffee);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-kopi:hover {
            background-color: var(--primary-coffee);
            color: white;
        }

        /* Footer */
        footer {
            background-color: var(--text-dark);
            color: rgba(255,255,255,0.8);
            margin-top: auto;
            border-top: 5px solid var(--primary-coffee);
            padding-top: 4rem !important;
        }
        
        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.1);
            color: white;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .social-links a:hover {
            background-color: var(--primary-coffee);
            transform: translateY(-3px);
        }

        /* Ruang spasi agar konten tidak tertutup fixed-top navbar */
        .main-content {
            padding-top: 90px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-custom py-3 fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand text-kopi d-flex align-items-center gap-2" href="{{ url('/') }}">
                <i class="bi bi-cup-hot-fill fs-3"></i>
                Roastory
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list fs-1 text-kopi"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Beranda</a>
                    </td>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('/about') }}">Tentang Kami</a>
                    </td>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('menu') ? 'active' : '' }}" href="{{ url('/menu') }}">Katalog Menu</a>
                    </td>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('reservasi') ? 'active' : '' }}" href="{{ url('/reservasi') }}">Reservasi</a>
                    </td>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('order') ? 'active' : '' }}" href="{{ url('/order') }}">Pesan Online</a>
                    </td>
                </ul>
                
                <div class="d-flex mt-3 mt-lg-0 align-items-center gap-3">
                    @guest
                        <a class="btn btn-kopi px-4 py-2 rounded-pill shadow-sm" href="{{ url('/login') }}">Masuk</a>
                    @endguest

                    @auth
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                                @if(Auth::user()->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists(Auth::user()->avatar))
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" width="40" height="40" class="rounded-circle  border-2 border-white shadow-sm" style="object-fit: cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama) }}&background=5c3d2e&color=fff&size=40" alt="Avatar" width="40" height="40" class="rounded-circle border border-2 border-white shadow-sm">
                                @endif
                                <span class="ms-2 fw-bold text-dark d-none d-lg-inline">{{ Auth::user()->nama }}</span>
                            </a>
                            
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 rounded-4 p-2" aria-labelledby="dropdownUser">
                                <li><a class="dropdown-item rounded-3 mb-1 bg-kopi-light text-kopi fw-bold" href="{{ url('/profile') }}"><i class="bi bi-person-circle me-2"></i>Profil Saya</a></li>
                                <li><a class="dropdown-item rounded-3 mb-1" href="{{ url('/order') }}"><i class="bi bi-bag-check me-2 text-secondary"></i>Pesanan Saya</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" id="logoutForm" class="d-none">
                                        @csrf
                                    </form>
                                    <a class="dropdown-item rounded-3 text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endauth
                </div> </div> </div> </nav>
    <main class="main-content flex-grow-1">
        @yield('content')
    </main>

    <footer class="py-5 mt-5">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-4 col-md-6 text-center text-md-start">
                    <h4 class="fw-bold mb-3 text-white d-flex align-items-center justify-content-center justify-content-md-start gap-2">
                        <i class="bi bi-cup-hot-fill"></i> Roastory
                    </h4>
                    <p class="text-white-50">Dibuat dari biji kopi pilihan terbaik yang dipanggang dengan sempurna, menghadirkan keseimbangan rasa dan kelembutan di setiap tegukan.</p>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 mb-md-0 d-flex flex-column align-items-md-center justify-content-start text-start text-md-center mx-auto">
                    <h5 class="text-white mb-3 fw-bold">Lokasi & Jam Operasional</h5>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-2"><i class="bi bi-geo-alt me-2"></i> Jl. Sudirman No 123, Kota Kopi</li>
                        <li class="mb-2"><i class="bi bi-clock me-2"></i> Buka Setiap Hari: 08.00 - 23.00 WIB</li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-12 text-center text-lg-end">
                    <h5 class="fw-bold text-white mb-3">Ikuti & Kontak Kami</h5>
                    <div class="social-links d-flex justify-content-center justify-content-lg-end">
                        <a href="https://instagram.com/roastory.co" target="_blank" rel="noopener noreferrer"
                            class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px; transition: all 0.3s;" title="Instagram Roastory">
                            <i class="bi bi-instagram"></i>
                        </a>

                        <a href="https://wa.me/6281234567890?text=Halo%20Roastory,%20saya%20ingin%20bertanya" target="_blank" rel="noopener noreferrer"
                            class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px; transition: all 0.3s;" title="WhatsApp Roastory">
                            <i class="bi bi-whatsapp"></i>
                        </a>

                        <a href="https://tiktok.com/@roastory.coffee.pwt" target="_blank" rel="noopener noreferrer"
                            class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px; transition: all 0.3s;" title="TikTok Roastory">
                            <i class="bi bi-tiktok"></i>
                        </a>

                        <a href="https://youtube.com/@roastory" target="_blank" rel="noopener noreferrer"
                            class="btn btn-outline-light rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px; transition: all 0.3s;" title="YouTube Roastory">
                            <i class="bi bi-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>

            <hr class="border-secondary opacity-25">
            <div class="text-center mt-4 pb-0 mb-0">
                <br>
                <small class="text-white-50">
                    &copy; 2026 Roastory. Dibuat dengan <i class="bi bi-suit-heart-fill text-danger"></i> untuk Anda.
                </small>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-sm');
                navbar.style.backgroundColor = 'rgba(253, 251, 247, 1)';
            } else {
                navbar.classList.remove('shadow-sm');
                navbar.style.backgroundColor = 'rgba(253, 251, 247, 0.95)';
            }
        });
    </script>

    @stack('scripts')
</body>

</html>