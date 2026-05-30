<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>E-Rapor SMK Arrasyadiyyah — Admin Panel</title>
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <style>
        /* ===== DESIGN TOKENS ===== */
        :root {
            --canvas:         #f4f5f7;
            --sidebar-bg:     #ffffff;
            --sidebar-border: #dce8f5;
            --topbar-bg:      #ffffff;
            --topbar-border:  #e5e7eb;
            --text-primary:   #0a1628;
            --text-secondary: #1e3a5f;
            --text-muted:     #6b8ab0;
            --accent:         #1e3a5f;
            --accent-light:   #e8f2fc;
            --accent-lime:    #c2ef4e;
            --lime-ink:       #1f1633;
            --card-bg:        #ffffff;
            --card-border:    #e5e7eb;
            --nav-active-bg:  #e8f2fc;
            --nav-active-text:#1e3a5f;
            --nav-hover-bg:   #f0f6fd;
            --scrollbar-thumb:#c5d8ef;
            --footer-bg:      #ffffff;
            --shadow-sm:      0 1px 3px rgba(30,58,95,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md:      0 4px 12px rgba(30,58,95,0.1), 0 2px 4px rgba(0,0,0,0.04);
            --radius-md:      8px;
            --radius-lg:      12px;
            --radius-xl:      16px;
        }
        [data-theme="dark"] {
            --canvas:         #111827;
            --sidebar-bg:     #1f2937;
            --sidebar-border: rgba(255,255,255,0.1);
            --topbar-bg:      #1f2937;
            --topbar-border:  rgba(255,255,255,0.1);
            --text-primary:   #f9fafb;
            --text-secondary: #d1d5db;
            --text-muted:     #9ca3af;
            --accent:         #3b82f6;
            --accent-light:   rgba(59,130,246,0.15);
            --accent-lime:    #3b82f6;
            --lime-ink:       #f9fafb;
            --card-bg:        #1f2937;
            --card-border:    rgba(255,255,255,0.12);
            --nav-active-bg:  rgba(59,130,246,0.15);
            --nav-active-text:#93c5fd;
            --nav-hover-bg:   rgba(255,255,255,0.05);
            --scrollbar-thumb:#374151;
            --footer-bg:      #1f2937;
            --shadow-sm:      0 1px 3px rgba(0,0,0,0.4);
            --shadow-md:      0 4px 12px rgba(0,0,0,0.5);
        }

        /* ===== RESET & BASE ===== */
        * { transition: background-color 0.25s, color 0.2s, border-color 0.2s; }
        body {
            font-family: 'Rubik', system-ui, sans-serif;
            background: var(--canvas);
            color: var(--text-primary);
        }

        /* ===== SIDEBAR ===== */
        #accordionSidebar {
            background: var(--sidebar-bg) !important;
            border-right: 1px solid var(--sidebar-border);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            width: 240px;
            box-shadow: 2px 0 12px rgba(66,32,130,0.06);
            transition: width 0.3s ease;
        }

        /* Brand */
        .sidebar-brand {
            padding: 1.2rem 1.5rem;
            display: flex; align-items: center; gap: 0.75rem;
            text-decoration: none;
            border-bottom: 1px solid var(--sidebar-border);
        }
        .sidebar-brand .logo-img {
            width: 42px; height: 42px;
            object-fit: contain;
            border-radius: 8px;
            flex-shrink: 0;
        }
        .brand-text { display: flex; flex-direction: column; }
        .brand-name {
            font-size: 0.92rem; font-weight: 700;
            color: var(--text-primary); line-height: 1.2;
        }
        .brand-sub {
            font-size: 0.68rem; font-weight: 400;
            color: var(--text-secondary);
        }

        /* Nav sections */
        .nav-section-label {
            font-size: 0.62rem; font-weight: 700;
            letter-spacing: 1.2px; text-transform: uppercase;
            color: var(--text-muted);
            padding: 1rem 1.25rem 0.4rem;
        }
        .nav-divider {
            height: 1px;
            background: var(--sidebar-border);
            margin: 0.5rem 1rem;
        }

        /* Nav items */
        #accordionSidebar .nav-item { list-style: none; }
        #accordionSidebar .nav-link {
            display: flex; align-items: center; gap: 0.7rem;
            padding: 0.6rem 1.25rem;
            font-size: 0.82rem; font-weight: 500;
            color: var(--text-secondary);
            border-radius: var(--radius-md);
            margin: 1px 0.5rem;
            text-decoration: none;
            transition: all 0.18s;
        }
        #accordionSidebar .nav-link:hover {
            background: var(--nav-hover-bg);
            color: var(--text-primary);
        }
        #accordionSidebar .nav-link i {
            width: 18px; text-align: center;
            font-size: 0.85rem; flex-shrink: 0;
        }
        #accordionSidebar .nav-link span { font-weight: 500; }

        /* Active nav */
        #accordionSidebar .nav-item.active .nav-link {
            background: var(--nav-active-bg) !important;
            color: var(--nav-active-text) !important;
            font-weight: 600;
        }
        #accordionSidebar .nav-item.active .nav-link i {
            color: var(--nav-active-text) !important;
        }

        /* Collapse toggle button */
        .sidebar-toggle-btn {
            width: 28px; height: 28px;
            border-radius: 50%;
            background: var(--card-border);
            border: none; cursor: pointer;
            margin: 1rem auto;
            display: block;
            display: flex; align-items: center; justify-content: center;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            background: var(--topbar-bg) !important;
            border-bottom: 1px solid var(--topbar-border);
            box-shadow: var(--shadow-sm) !important;
            height: 60px;
            padding: 0 1.5rem;
        }
        .topbar .nav-link { color: var(--text-secondary) !important; }
        .topbar .topbar-divider {
            border-right: 1px solid var(--topbar-border);
            height: 32px; margin: auto 1rem;
        }
        .topbar-user-name {
            font-size: 0.83rem; font-weight: 500;
            color: var(--text-secondary);
        }
        .avatar-circle {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6a5fc1, #422082);
            color: #fff; font-weight: 700; font-size: 14px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .dropdown-menu {
            background: var(--card-bg) !important;
            border: 1px solid var(--card-border) !important;
            border-radius: var(--radius-lg) !important;
            box-shadow: var(--shadow-md) !important;
            padding: 0.5rem !important;
        }
        .dropdown-item {
            color: var(--text-primary) !important;
            border-radius: var(--radius-md);
            font-size: 0.83rem; font-weight: 500;
        }
        .dropdown-item:hover { background: var(--nav-hover-bg) !important; }
        .dropdown-divider { border-color: var(--card-border) !important; }

        /* Theme toggle */
        .theme-toggle-btn {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: var(--accent-light);
            border: 1px solid var(--card-border);
            color: var(--accent);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 0.9rem;
            transition: all 0.2s;
            margin-right: 0.5rem;
        }
        .theme-toggle-btn:hover {
            background: var(--accent);
            color: #fff;
            transform: scale(1.05);
        }

        /* ===== CONTENT ===== */
        #content-wrapper { background: var(--canvas); }
        #content { padding-top: 0; }
        .container-fluid { padding: 1.5rem; }

        /* Cards override */
        .card {
            background: var(--card-bg) !important;
            border: 1px solid var(--card-border) !important;
            border-radius: var(--radius-lg) !important;
            box-shadow: var(--shadow-sm) !important;
        }
        .card-header {
            background: var(--card-bg) !important;
            border-bottom: 1px solid var(--card-border) !important;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0 !important;
        }
        .card-footer {
            background: var(--card-bg) !important;
            border-top: 1px solid var(--card-border) !important;
        }
        .card h6 { color: var(--text-primary); font-weight: 600; font-size: 0.88rem; }

        /* Tables */
        .table { color: var(--text-primary) !important; }
        .table thead th {
            background: var(--accent) !important;
            color: #fff !important;
            font-size: 0.75rem; font-weight: 600;
            letter-spacing: 0.5px; text-transform: uppercase;
            border: none !important;
        }
        .table tbody tr:hover td { background: var(--accent-light) !important; }
        .table td, .table th { border-color: var(--card-border) !important; vertical-align: middle; }
        .table-bordered { border-color: var(--card-border) !important; }

        /* Buttons */
        .btn-primary   { background: var(--accent) !important; border-color: var(--accent) !important; }
        .btn-primary:hover { opacity: 0.88; }

        /* Badges */
        .border-left-primary   { border-left: 4px solid #422082 !important; }
        .border-left-success   { border-left: 4px solid #1cc88a !important; }
        .border-left-warning   { border-left: 4px solid #f6c23e !important; }
        .border-left-info      { border-left: 4px solid #36b9cc !important; }
        .border-left-danger    { border-left: 4px solid #e74a3b !important; }

        /* Alerts */
        .alert {
            border-radius: var(--radius-md) !important;
            border: none !important;
            animation: slideDown 0.3s ease-out;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Footer */
        .sticky-footer {
            background: var(--footer-bg) !important;
            border-top: 1px solid var(--topbar-border) !important;
        }
        .sticky-footer .copyright {
            color: var(--text-muted);
            font-size: 0.78rem;
        }

        /* Scroll-to-top */
        .scroll-to-top {
            background: var(--accent) !important;
            color: #fff !important;
        }

        /* Page heading helper */
        .page-title {
            font-size: 1.25rem; font-weight: 700;
            color: var(--text-primary); margin-bottom: 0;
        }
        .page-sub {
            font-size: 0.8rem; color: var(--text-muted); font-weight: 400;
        }

        /* Collapsed sidebar */
        .sidebar-toggled #accordionSidebar { width: 88px !important; overflow: hidden; }
        .sidebar-toggled .brand-text,
        .sidebar-toggled .nav-link span,
        .sidebar-toggled .nav-section-label { display: none; }
        .sidebar-toggled .nav-link { justify-content: center; padding: 0.65rem; }
        .sidebar-toggled .sidebar-brand { justify-content: center; }

        /* ===== DARK MODE — Override Komprehensif ===== */
        [data-theme="dark"] body,
        [data-theme="dark"] #content-wrapper,
        [data-theme="dark"] #content,
        [data-theme="dark"] .wrapper {
            background-color: var(--canvas) !important;
            color: var(--text-primary) !important;
        }
        [data-theme="dark"] .container-fluid {
            background: var(--canvas) !important;
        }
        /* Text overrides */
        [data-theme="dark"] h1, [data-theme="dark"] h2, [data-theme="dark"] h3,
        [data-theme="dark"] h4, [data-theme="dark"] h5, [data-theme="dark"] h6,
        [data-theme="dark"] .h1, [data-theme="dark"] .h2, [data-theme="dark"] .h3,
        [data-theme="dark"] .h4, [data-theme="dark"] .h5, [data-theme="dark"] .h6 {
            color: var(--text-primary) !important;
        }
        [data-theme="dark"] .text-gray-800,
        [data-theme="dark"] .text-gray-700,
        [data-theme="dark"] .text-gray-600,
        [data-theme="dark"] .text-gray-900,
        [data-theme="dark"] .text-dark {
            color: var(--text-primary) !important;
        }
        [data-theme="dark"] .text-muted {
            color: var(--text-muted) !important;
        }
        [data-theme="dark"] p, [data-theme="dark"] span:not(.badge):not(.nav-section-label) {
            color: var(--text-primary);
        }
        [data-theme="dark"] small { color: var(--text-secondary) !important; }
        /* Table overrides */
        [data-theme="dark"] .table td {
            color: var(--text-primary) !important;
            background-color: var(--card-bg) !important;
            border-color: rgba(255,255,255,0.15) !important;
        }
        [data-theme="dark"] .table th { border-color: rgba(255,255,255,0.15) !important; }
        [data-theme="dark"] .table tr { border-color: rgba(255,255,255,0.15) !important; }
        [data-theme="dark"] .table-bordered { border-color: rgba(255,255,255,0.15) !important; }
        [data-theme="dark"] .table-striped tbody tr:nth-of-type(odd) td {
            background-color: rgba(255,255,255,0.03) !important;
        }
        [data-theme="dark"] .table tbody tr:hover td { background-color: rgba(255,255,255,0.06) !important; }
        [data-theme="dark"] .table-hover tbody tr:hover { background-color: rgba(255,255,255,0.05) !important; }
        [data-theme="dark"] .table thead th {
            background: #374151 !important;
            color: #f9fafb !important;
            border-color: rgba(255,255,255,0.2) !important;
        }
        [data-theme="dark"] .thead-dark th,
        [data-theme="dark"] .thead-light th {
            background: #374151 !important;
            color: #f9fafb !important;
            border-color: rgba(255,255,255,0.2) !important;
        }
        [data-theme="dark"] .bg-info.text-white th {
            background: #374151 !important;
            color: #f9fafb !important;
        }
        /* Form controls */
        [data-theme="dark"] .form-control {
            background-color: #374151 !important;
            border-color: rgba(255,255,255,0.15) !important;
            color: var(--text-primary) !important;
        }
        [data-theme="dark"] .form-control:focus {
            background-color: #4b5563 !important;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.2) !important;
        }
        /* Modals */
        [data-theme="dark"] .modal-content {
            background: var(--card-bg) !important;
            border-color: var(--card-border) !important;
            color: var(--text-primary) !important;
        }
        [data-theme="dark"] .modal-header,
        [data-theme="dark"] .modal-footer {
            border-color: var(--card-border) !important;
        }
        [data-theme="dark"] label { color: var(--text-secondary) !important; }
        [data-theme="dark"] .input-group-text {
            background: #374151 !important;
            border-color: rgba(255,255,255,0.15) !important;
            color: var(--text-primary) !important;
        }
        /* Select */
        [data-theme="dark"] select.form-control {
            background-color: #374151 !important;
            color: var(--text-primary) !important;
        }
        /* Nav tabs */
        [data-theme="dark"] .nav-tabs {
            border-color: var(--card-border) !important;
        }
        [data-theme="dark"] .nav-tabs .nav-link {
            color: var(--text-secondary) !important;
        }
        [data-theme="dark"] .nav-tabs .nav-link.active {
            background: var(--card-bg) !important;
            border-color: var(--card-border) !important;
            color: var(--accent) !important;
        }
        /* Avatar */
        [data-theme="dark"] .avatar-circle {
            background: linear-gradient(135deg, #3b82f6, #60a5fa) !important;
            color: #fff !important;
        }
        /* Border-left helpers */
        [data-theme="dark"] .border-left-primary   { border-left-color: #60a5fa !important; }
        [data-theme="dark"] .border-left-success   { border-left-color: #6be89e !important; }
        [data-theme="dark"] .border-left-warning   { border-left-color: #ffd96a !important; }
        [data-theme="dark"] .border-left-info      { border-left-color: #6dd5e8 !important; }
        /* bg overrides */
        [data-theme="dark"] .bg-light { background: #374151 !important; }
        [data-theme="dark"] .bg-white { background: var(--card-bg) !important; }
        /* Pagination */
        [data-theme="dark"] .page-item .page-link {
            background: var(--card-bg) !important;
            border-color: rgba(255,255,255,0.15) !important;
            color: var(--text-primary) !important;
        }
        [data-theme="dark"] .page-item.active .page-link { background: #3b82f6 !important; color: #fff !important; }
    </style>
</head>

<body id="page-top">
<div id="wrapper">

    <!-- ===== SIDEBAR ===== -->
    <ul class="navbar-nav" id="accordionSidebar">

        <a class="sidebar-brand" href="/dashboard-admin">
            <img src="{{ asset('img/logo-smk.png') }}" alt="Logo SMK" class="logo-img">
            <div class="brand-text">
                <span class="brand-name">SMK Arrasyadiyyah</span>
                <span class="brand-sub">Admin Panel</span>
            </div>
        </a>

        <li class="nav-item {{ request()->is('dashboard-admin') ? 'active' : '' }}">
            <a class="nav-link" href="/dashboard-admin">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <div class="nav-divider"></div>
        <div class="nav-section-label">Kelola Pengguna</div>

        <li class="nav-item {{ request()->is('dashboard-admin/guru*') ? 'active' : '' }}">
            <a class="nav-link" href="/dashboard-admin/guru">
                <i class="fas fa-fw fa-chalkboard-teacher"></i>
                <span>Data Guru</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('dashboard-admin/siswa*') ? 'active' : '' }}">
            <a class="nav-link" href="/dashboard-admin/siswa">
                <i class="fas fa-fw fa-user-graduate"></i>
                <span>Data Siswa</span>
            </a>
        </li>

        <div class="nav-divider"></div>
        <div class="nav-section-label">Data Master Sekolah</div>

        <li class="nav-item {{ request()->is('dashboard-admin/jurusan*') ? 'active' : '' }}">
            <a class="nav-link" href="/dashboard-admin/jurusan">
                <i class="fas fa-fw fa-building"></i>
                <span>Data Jurusan</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('dashboard-admin/kelas*') ? 'active' : '' }}">
            <a class="nav-link" href="/dashboard-admin/kelas">
                <i class="fas fa-fw fa-door-open"></i>
                <span>Data Kelas</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('dashboard-admin/mapel*') ? 'active' : '' }}">
            <a class="nav-link" href="/dashboard-admin/mapel">
                <i class="fas fa-fw fa-book"></i>
                <span>Data Mata Pelajaran</span>
            </a>
        </li>

        <div class="nav-divider"></div>
        <div class="nav-section-label">Manajemen Akademik</div>

        <li class="nav-item {{ request()->is('dashboard-admin/tahun-akademik*') ? 'active' : '' }}">
            <a class="nav-link" href="/dashboard-admin/tahun-akademik">
                <i class="fas fa-fw fa-calendar-alt"></i>
                <span>Tahun Ajaran Aktif</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('dashboard-admin/rombel*') ? 'active' : '' }}">
            <a class="nav-link" href="/dashboard-admin/rombel">
                <i class="fas fa-fw fa-users-cog"></i>
                <span>Pembagian Kelas &amp; Wali</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('dashboard-admin/jadwal*') ? 'active' : '' }}">
            <a class="nav-link" href="/dashboard-admin/jadwal">
                <i class="fas fa-fw fa-calendar-check"></i>
                <span>Jadwal Mengajar</span>
            </a>
        </li>

        <div class="nav-divider" style="margin-top:auto;"></div>
        <div class="text-center py-2">
            <button class="sidebar-toggle-btn" id="sidebarToggle" title="Collapse Sidebar">
                <i class="fas fa-angle-left" style="font-size:0.7rem; color:var(--text-muted);"></i>
            </button>
        </div>
    </ul>
    <!-- End Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars" style="color:var(--text-secondary);"></i>
                </button>

                <ul class="navbar-nav ml-auto align-items-center">
                    <!-- Theme Toggle -->
                    <button class="theme-toggle-btn" id="themeToggle" title="Toggle Dark/Light Mode">
                        <i class="fas fa-moon" id="themeIcon"></i>
                    </button>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                           href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="topbar-user-name d-none d-lg-inline mr-2">
                                {{ Auth::user()->name ?? 'Admin' }}
                            </span>
                            <div class="avatar-circle">
                                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('admin.profil') }}">
                                <i class="fas fa-user fa-sm fa-fw mr-2" style="color:var(--text-muted);"></i>
                                Profil Saya
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- End Topbar -->

            <!-- Page Content -->
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>

        <!-- Footer -->
        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; SMK Arrasyadiyyah 2026</span>
                </div>
            </div>
        </footer>
    </div>
</div>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="background:var(--card-bg);border:1px solid var(--card-border);border-radius:16px;">
            <div class="modal-header" style="border-bottom:1px solid var(--card-border);">
                <h5 class="modal-title" style="color:var(--text-primary);font-weight:700;">Konfirmasi Logout</h5>
                <button class="close" type="button" data-dismiss="modal" style="color:var(--text-muted);">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="color:var(--text-secondary);">Apakah Anda yakin ingin keluar dari sistem E-Rapor?</div>
            <div class="modal-footer" style="border-top:1px solid var(--card-border);">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_role" value="admin">
                    <button type="submit" class="btn btn-primary font-weight-bold">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
<script>
    // ===== THEME TOGGLE =====
    const html       = document.documentElement;
    const themeIcon  = document.getElementById('themeIcon');
    const themeBtn   = document.getElementById('themeToggle');
    const savedTheme = localStorage.getItem('erapor_theme') || 'light';
    html.setAttribute('data-theme', savedTheme);
    updateIcon(savedTheme);

    themeBtn.addEventListener('click', function() {
        const current = html.getAttribute('data-theme');
        const next    = current === 'light' ? 'dark' : 'light';
        html.setAttribute('data-theme', next);
        localStorage.setItem('erapor_theme', next);
        updateIcon(next);
    });
    function updateIcon(theme) {
        themeIcon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
    }

    // Auto-dismiss alerts
    setTimeout(function() { $('.alert').fadeOut('slow'); }, 4000);
</script>
</body>
</html>
