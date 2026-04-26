<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin | Kopi Kenangan Kita')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --admin-dark: #1e1b1a;
            --admin-darker: #151312;
            --admin-accent: #d4b59d;
            --admin-card: #2d2420;
            --text-muted: rgba(255, 255, 255, 0.6);
            --border-color: rgba(255, 255, 255, 0.05);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--admin-dark);
            color: rgba(255, 255, 255, 0.9);
            min-height: 100vh;
            display: flex;
        }

        /* Sidebar Styling */
        #sidebar {
            width: 250px;
            background-color: var(--admin-darker);
            border-right: 1px solid var(--border-color);
            transition: all 0.3s;
            position: fixed;
            height: 100vh;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .nav-link {
            color: var(--text-muted);
            padding: 0.8rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--admin-accent);
            background-color: rgba(212, 181, 157, 0.05);
            border-right: 3px solid var(--admin-accent);
        }

        /* Main Content Wrapper */
        #main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
            min-height: 100vh;
            transition: all 0.3s;
        }

        /* Top Navbar */
        .top-navbar {
            background-color: var(--admin-dark);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid var(--admin-accent);
        }

        /* Cards & Components */
        .admin-card {
            background-color: var(--admin-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            height: 100%;
            transition: transform 0.3s ease;
        }

        .admin-card:hover {
            transform: translateY(-5px);
        }

        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .icon-box.primary {
            background-color: rgba(212, 181, 157, 0.1);
            color: var(--admin-accent);
        }

        .icon-box.success {
            background-color: rgba(25, 135, 84, 0.1);
            color: #20c997;
        }

        .icon-box.warning {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .icon-box.info {
            background-color: rgba(13, 202, 240, 0.1);
            color: #0dcaf0;
        }

        /* Tables */
        .table-dark {
            background-color: transparent;
            color: rgba(255, 255, 255, 0.8);
        }

        .table-dark th {
            border-bottom-color: var(--border-color);
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .table-dark td {
            border-bottom-color: var(--border-color);
            vertical-align: middle;
        }

        .badge-status {
            padding: 0.4rem 0.8rem;
            border-radius: 50rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-completed {
            background-color: rgba(25, 135, 84, 0.2);
            color: #20c997;
        }

        .badge-pending {
            background-color: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }

        .btn-admin {
            background-color: var(--admin-accent);
            color: var(--admin-dark);
            border: 2px solid var(--admin-accent);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-admin:hover {
            background-color: transparent;
            color: var(--admin-accent);
        }

        .btn-outline-admin {
            background-color: transparent;
            color: var(--admin-accent);
            border: 1px solid var(--admin-accent);
            transition: all 0.3s ease;
        }

        .btn-outline-admin:hover {
            background-color: var(--admin-accent);
            color: var(--admin-dark);
        }

        /* Mobile Sidebar Toggle */
        #sidebar-toggle {
            display: none;
            background: transparent;
            border: none;
            color: var(--admin-accent);
            font-size: 1.5rem;
        }

        @media (max-width: 991px) {
            #sidebar {
                transform: translateX(-250px);
            }

            #sidebar.show {
                transform: translateX(0);
            }

            #main-content {
                margin-left: 0;
                width: 100%;
            }

            #sidebar-toggle {
                display: block;
            }
        }
    </style>
    @stack('admin_styles')
</head>

<body>

    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <a href="{{ url('/admin/dashboard') }}" class="text-decoration-none d-flex align-items-center gap-2">
                <i class="bi bi-cpu-fill fs-3" style="color: var(--admin-accent);"></i>
                <span class="fs-5 fw-bold text-white">Portal Admin</span>
            </a>
        </div>
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ url('/admin/dashboard') }}"><i class="bi bi-grid-1x2-fill"></i> Ringkasan Utama</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/pesanan') ? 'active' : '' }}" href="{{ url('/admin/pesanan') }}"><i class="bi bi-bag-check"></i> Pesanan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/reservasi') ? 'active' : '' }}" href="{{ url('/admin/reservasi') }}"><i class="bi bi-calendar2-check"></i> Reservasi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/katalog-menu') ? 'active' : '' }}" href="{{ url('/admin/katalog-menu') }}"><i class="bi bi-journal-richtext"></i> Katalog Menu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/pengguna') ? 'active' : '' }}" href="{{ url('/admin/pengguna') }}"><i class="bi bi-people"></i> Daftar Pengguna</a>
            </li>
        </ul>

        <div class="position-absolute bottom-0 w-100 p-3">
            <a class="btn btn-outline-admin w-100 d-flex justify-content-center align-items-center gap-2"
                href="{{ url('/') }}">
                <i class="bi bi-box-arrow-left"></i> Keluar
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main id="main-content">
        <!-- Topbar -->
        <header class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button id="sidebar-toggle">
                    <i class="bi bi-list"></i>
                </button>
                <div class="d-none d-md-flex align-items-center bg-dark rounded-pill px-3 py-2"
                    style="border: 1px solid var(--border-color);">
                    <i class="bi bi-search text-muted me-2"></i>
                    <input type="text" placeholder="Cari data..." class="bg-transparent border-0 text-white shadow-none"
                        style="outline: none;">
                </div>
            </div>

            <div class="d-flex align-items-center gap-4">
                <a href="#" class="text-muted position-relative hover-white transition-colors">
                    <i class="bi bi-bell fs-5"></i>
                    <span
                        class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-dark rounded-circle">
                        <span class="visually-hidden">New alerts</span>
                    </span>
                </a>
                <div class="user-profile d-flex align-items-center gap-2 cursor-pointer">
                    <img src="https://ui-avatars.com/api/?name=Admin+Kopi&background=d4b59d&color=1e1b1a"
                        alt="Admin Profile">
                    <div class="d-none d-md-block">
                        <p class="mb-0 fw-bold fs-6 lh-sm">Admin Utama</p>
                        <small class="text-muted" style="font-size: 0.7rem;">Superadmin</small>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="container-fluid p-4">
            @yield('admin_content')
        </div>
    </main>

    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle Sidebar on Mobile
        document.getElementById('sidebar-toggle').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('show');
        });
    </script>
    @stack('admin_scripts')
</body>

</html>
