<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'ToyStore') | ToyStore Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #6558e8;
            --primary-dark: #5042d0;
            --sidebar: #201d3b;
            --background: #f5f6fc;
            --text: #292744;
            --muted: #85849b;
            --radius: 15px;
        }

        * {
            font-family: 'Nunito', sans-serif;
        }

        body {
            background: var(--background);
            color: var(--text);
            margin: 0;
        }

        .sidebar {
            width: 255px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--sidebar);
            color: white;
            padding: 25px 16px;
            z-index: 1050;
            overflow-y: auto;
            transition: .3s ease;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 5px 12px 30px;
        }

        .brand-icon {
            width: 45px;
            height: 45px;
            border-radius: 13px;
            background: #7669f2;
            display: grid;
            place-items: center;
            font-size: 22px;
        }

        .brand h4 {
            font-weight: 900;
            margin: 0;
        }

        .menu-label {
            color: #9290b0;
            font-size: 11px;
            font-weight: 800;
            padding: 12px 13px 8px;
            letter-spacing: 1.2px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 13px;
            color: #c2c0d7;
            text-decoration: none;
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 5px;
            font-weight: 700;
            transition: .25s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: var(--primary);
            color: white;
            transform: translateX(3px);
        }

        .sidebar a i {
            width: 20px;
            text-align: center;
        }

        .main-content {
            margin-left: 255px;
            min-height: 100vh;
        }

        .topbar {
            height: 75px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            box-shadow: 0 2px 15px rgba(0,0,0,.035);
        }

        .page-content {
            padding: 30px;
        }

        .page-heading {
            font-size: 25px;
            font-weight: 900;
        }

        .page-subtitle {
            color: var(--muted);
            font-size: 13px;
        }

        .custom-card {
            background: white;
            border: none;
            border-radius: var(--radius);
            padding: 22px;
            box-shadow: 0 5px 25px rgba(30,30,70,.045);
            height: 100%;
        }

        .stat-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .stat-icon {
            width: 53px;
            height: 53px;
            border-radius: 15px;
            display: grid;
            place-items: center;
            font-size: 22px;
        }

        .stat-card h3 {
            font-size: 24px;
            font-weight: 900;
            margin: 8px 0 0;
        }

        .stat-card p {
            color: var(--muted);
            font-size: 13px;
            margin: 0;
            font-weight: 700;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            box-shadow: 0 5px 15px rgba(101,88,232,.3);
        }

        .table thead th {
            background: #f8f8fc;
            color: #77758e;
            font-size: 12px;
            padding: 15px;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 14px;
            vertical-align: middle;
            font-size: 13px;
        }

        .product-thumb {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            object-fit: cover;
            background: #f2f2f8;
        }

        .form-control, .form-select {
            padding: 11px 13px;
            border-radius: 9px;
            border-color: #e8e8f0;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 .2rem rgba(101,88,232,.1);
        }

        .table-responsive {
            border-radius: 10px;
        }

        .mobile-menu {
            display: none;
        }

        .sidebar-overlay {
            display: none;
        }

        @media(max-width: 991px) {
            .sidebar {
                left: -270px;
            }

            .sidebar.show {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu {
                display: inline-block;
            }

            .sidebar-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,.45);
                z-index: 1040;
            }

            .page-content {
                padding: 20px 15px;
            }

            .topbar {
                padding: 0 15px;
            }
        }

        @media(max-width: 576px) {
            .page-heading {
                font-size: 21px;
            }

            .custom-card {
                padding: 16px;
            }

            .stat-card h3 {
                font-size: 20px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<aside class="sidebar" id="sidebar">

    <div class="brand">
        <div class="brand-icon">
            <i class="fas fa-cube"></i>
        </div>

        <div>
            <h4>ToyStore</h4>
            <small class="text-white-50">Management System</small>
        </div>
    </div>

    <div class="menu-label">MENU UTAMA</div>

    <a href="{{ route('dashboard') }}"
       class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fas fa-chart-pie"></i> Dashboard
    </a>

    <div class="menu-label">MASTER DATA</div>

    <a href="{{ route('categories.index') }}"
       class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
        <i class="fas fa-layer-group"></i> Kategori Mainan
    </a>

    <a href="{{ route('products.index') }}"
       class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
        <i class="fas fa-box-open"></i> Produk Mainan
    </a>

    <a href="{{ route('customers.index') }}"
       class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Pelanggan
    </a>

    <div class="menu-label">TRANSAKSI</div>

    <a href="{{ route('sales.index') }}"
       class="{{ request()->routeIs('sales.*') ? 'active' : '' }}">
        <i class="fas fa-shopping-cart"></i> Penjualan
    </a>

    <a href="{{ route('reports.index') }}"
       class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
        <i class="fas fa-chart-line"></i> Laporan
    </a>

</aside>

<div class="main-content">

    <header class="topbar">

        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-light mobile-menu" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>

            <div>
                <strong>Admin Panel</strong>
                <div class="page-subtitle">Kelola toko mainan Anda</div>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <div class="text-end">
                <strong>{{ auth()->user()->name ?? 'Administrator' }}</strong>
                <div class="page-subtitle">Administrator</div>
            </div>

            <div class="stat-icon" style="background:#eeeaff;color:#6558e8;">
                <i class="fas fa-user"></i>
            </div>
        </div>

    </header>

    <main class="page-content">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Periksa kembali data Anda:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')

    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
        document.getElementById('sidebarOverlay').classList.toggle('show');
    }
</script>

@stack('scripts')

</body>
</html>