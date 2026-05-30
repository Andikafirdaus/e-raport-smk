<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Panel Guru — SMK Arrasyadiyyah</title>
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <style>
        :root {
            --canvas:         #f4f5f7;
            --sidebar-bg:     #ffffff;
            --sidebar-border: #e0f0e8;
            --topbar-bg:      #ffffff;
            --topbar-border:  #e5e7eb;
            --text-primary:   #0d2818;
            --text-secondary: #2e7d52;
            --text-muted:     #7aaa8c;
            --accent:         #1b6b3a;
            --accent-light:   #edf7f1;
            --accent-lime:    #c2ef4e;
            --card-bg:        #ffffff;
            --card-border:    #e5e7eb;
            --nav-active-bg:  #edf7f1;
            --nav-active-text:#1b6b3a;
            --nav-hover-bg:   #f4fbf7;
            --footer-bg:      #ffffff;
            --shadow-sm:      0 1px 3px rgba(27,107,58,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md:      0 4px 12px rgba(27,107,58,0.08);
            --radius-md:      8px;
            --radius-lg:      12px;
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
            --accent:         #22c55e;
            --accent-light:   rgba(34,197,94,0.15);
            --card-bg:        #1f2937;
            --card-border:    rgba(255,255,255,0.12);
            --nav-active-bg:  rgba(34,197,94,0.15);
            --nav-active-text:#86efac;
            --nav-hover-bg:   rgba(255,255,255,0.05);
            --footer-bg:      #1f2937;
        }

        * { transition: background-color 0.25s, color 0.2s, border-color 0.2s; }
        body { font-family: 'Rubik', system-ui, sans-serif; background: var(--canvas); color: var(--text-primary); }

        /* Sidebar */
        #accordionSidebar {
            background: var(--sidebar-bg) !important;
            border-right: 1px solid var(--sidebar-border);
            min-height: 100vh; width: 240px;
            box-shadow: 2px 0 12px rgba(27,107,58,0.06);
            transition: width 0.3s;
        }
        .sidebar-brand {
            padding: 1.2rem 1.5rem;
            display: flex; align-items: center; gap: 0.75rem;
            text-decoration: none;
            border-bottom: 1px solid var(--sidebar-border);
        }
        .sidebar-brand .logo-img { width: 42px; height: 42px; object-fit: contain; border-radius: 8px; flex-shrink: 0; }
        .brand-text { display: flex; flex-direction: column; }
        .brand-name { font-size: 0.92rem; font-weight: 700; color: var(--text-primary); line-height: 1.2; }
        .brand-sub  { font-size: 0.68rem; font-weight: 400; color: var(--text-secondary); }
        .nav-section-label {
            font-size: 0.62rem; font-weight: 700; letter-spacing: 1.2px;
            text-transform: uppercase; color: var(--text-muted);
            padding: 1rem 1.25rem 0.4rem;
        }
        .nav-divider { height: 1px; background: var(--sidebar-border); margin: 0.5rem 1rem; }
        #accordionSidebar .nav-item { list-style: none; }
        #accordionSidebar .nav-link {
            display: flex; align-items: center; gap: 0.7rem;
            padding: 0.6rem 1.25rem; font-size: 0.82rem; font-weight: 500;
            color: var(--text-secondary); border-radius: var(--radius-md);
            margin: 1px 0.5rem; text-decoration: none; transition: all 0.18s;
        }
        #accordionSidebar .nav-link:hover { background: var(--nav-hover-bg); color: var(--text-primary); }
        #accordionSidebar .nav-link i { width: 18px; text-align: center; font-size: 0.85rem; }
        #accordionSidebar .nav-item.active .nav-link {
            background: var(--nav-active-bg) !important;
            color: var(--nav-active-text) !important; font-weight: 600;
        }
        .sidebar-toggle-btn {
            width: 28px; height: 28px; border-radius: 50%;
            background: var(--card-border); border: none; cursor: pointer;
            margin: 1rem auto; display: flex; align-items: center; justify-content: center;
        }

        /* Topbar */
        .topbar {
            background: var(--topbar-bg) !important;
            border-bottom: 1px solid var(--topbar-border);
            box-shadow: var(--shadow-sm) !important; height: 60px; padding: 0 1.5rem;
        }
        .topbar-divider { border-right: 1px solid var(--topbar-border); height: 32px; margin: auto 1rem; }
        .topbar-user-name { font-size: 0.83rem; font-weight: 500; color: var(--text-secondary); }
        .avatar-circle {
            width: 34px; height: 34px; border-radius: 50%;
            background: linear-gradient(135deg, #2e9950, #1b6b3a);
            color: #fff; font-weight: 700; font-size: 14px;
            display: flex; align-items: center; justify-content: center;
        }
        .dropdown-menu {
            background: var(--card-bg) !important; border: 1px solid var(--card-border) !important;
            border-radius: var(--radius-lg) !important; box-shadow: var(--shadow-md) !important; padding: 0.5rem !important;
        }
        .dropdown-item { color: var(--text-primary) !important; border-radius: var(--radius-md); font-size: 0.83rem; font-weight: 500; }
        .dropdown-item:hover { background: var(--nav-hover-bg) !important; }
        .dropdown-divider { border-color: var(--card-border) !important; }
        .theme-toggle-btn {
            width: 36px; height: 36px; border-radius: 50%;
            background: var(--accent-light); border: 1px solid var(--card-border);
            color: var(--accent); display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 0.9rem; transition: all 0.2s; margin-right: 0.5rem;
        }
        .theme-toggle-btn:hover { background: var(--accent); color: #fff; transform: scale(1.05); }

        /* Content */
        #content-wrapper { background: var(--canvas); }
        .container-fluid { padding: 1.5rem; }
        .card {
            background: var(--card-bg) !important; border: 1px solid var(--card-border) !important;
            border-radius: var(--radius-lg) !important; box-shadow: var(--shadow-sm) !important;
        }
        .card-header { background: var(--card-bg) !important; border-bottom: 1px solid var(--card-border) !important; border-radius: var(--radius-lg) var(--radius-lg) 0 0 !important; }
        .card-footer { background: var(--card-bg) !important; border-top: 1px solid var(--card-border) !important; }
        .table { color: var(--text-primary) !important; }
        .table thead th { background: var(--accent) !important; color: #fff !important; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase; border: none !important; }
        .table td, .table th { border-color: var(--card-border) !important; vertical-align: middle; }
        .btn-primary   { background: var(--accent) !important; border-color: var(--accent) !important; }
        .btn-success   { background: #1b6b3a !important; border-color: #1b6b3a !important; }
        .alert { border-radius: var(--radius-md) !important; border: none !important; animation: slideDown 0.3s ease-out; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }
        .sticky-footer { background: var(--footer-bg) !important; border-top: 1px solid var(--topbar-border) !important; }
        .sticky-footer .copyright { color: var(--text-muted); font-size: 0.78rem; }
        .scroll-to-top { background: var(--accent) !important; color: #fff !important; }
        .border-left-success { border-left: 4px solid #1cc88a !important; }
        .border-left-primary { border-left: 4px solid var(--accent) !important; }
        .border-left-warning { border-left: 4px solid #f6c23e !important; }
        .border-left-info    { border-left: 4px solid #36b9cc !important; }

        /* ===== DARK MODE — Override Komprehensif ===== */
        [data-theme="dark"] body,
        [data-theme="dark"] #content-wrapper,
        [data-theme="dark"] #content,
        [data-theme="dark"] .wrapper { background-color: var(--canvas) !important; color: var(--text-primary) !important; }
        [data-theme="dark"] .container-fluid { background: var(--canvas) !important; }
        [data-theme="dark"] h1,[data-theme="dark"] h2,[data-theme="dark"] h3,
        [data-theme="dark"] h4,[data-theme="dark"] h5,[data-theme="dark"] h6 { color: var(--text-primary) !important; }
        [data-theme="dark"] .text-gray-800,[data-theme="dark"] .text-gray-700,
        [data-theme="dark"] .text-gray-600,[data-theme="dark"] .text-dark { color: var(--text-primary) !important; }
        [data-theme="dark"] .text-muted { color: var(--text-muted) !important; }
        [data-theme="dark"] p,[data-theme="dark"] span:not(.badge) { color: var(--text-primary); }
        [data-theme="dark"] small { color: var(--text-secondary) !important; }
        /* Table dark mode */
        [data-theme="dark"] .table td { color: var(--text-primary) !important; background-color: var(--card-bg) !important; border-color: rgba(255,255,255,0.15) !important; }
        [data-theme="dark"] .table th { border-color: rgba(255,255,255,0.15) !important; }
        [data-theme="dark"] .table tr { border-color: rgba(255,255,255,0.15) !important; }
        [data-theme="dark"] .table-bordered { border-color: rgba(255,255,255,0.15) !important; }
        [data-theme="dark"] .table thead th { background: #374151 !important; color: #f9fafb !important; border-color: rgba(255,255,255,0.2) !important; }
        [data-theme="dark"] .table tbody tr:hover td { background-color: rgba(255,255,255,0.06) !important; }
        [data-theme="dark"] .table-hover tbody tr:hover { background-color: rgba(255,255,255,0.05) !important; }
        [data-theme="dark"] .thead-dark th,[data-theme="dark"] .thead-light th { background: #374151 !important; color: #f9fafb !important; border-color: rgba(255,255,255,0.2) !important; }
        [data-theme="dark"] .bg-info.text-white th { background: #374151 !important; color: #f9fafb !important; }
        /* Form */
        [data-theme="dark"] .form-control { background-color: #374151 !important; border-color: rgba(255,255,255,0.15) !important; color: var(--text-primary) !important; }
        [data-theme="dark"] .form-control:focus { background-color: #4b5563 !important; box-shadow: 0 0 0 3px rgba(34,197,94,0.2) !important; }
        [data-theme="dark"] .modal-content { background: var(--card-bg) !important; border-color: var(--card-border) !important; color: var(--text-primary) !important; }
        [data-theme="dark"] .modal-header,[data-theme="dark"] .modal-footer { border-color: var(--card-border) !important; }
        [data-theme="dark"] label { color: var(--text-secondary) !important; }
        [data-theme="dark"] .input-group-text { background: #374151 !important; border-color: rgba(255,255,255,0.15) !important; color: var(--text-primary) !important; }
        [data-theme="dark"] select.form-control { background-color: #374151 !important; color: var(--text-primary) !important; }
        [data-theme="dark"] .bg-light { background: #374151 !important; }
        [data-theme="dark"] .bg-white { background: var(--card-bg) !important; }
        [data-theme="dark"] .page-item .page-link { background: var(--card-bg) !important; border-color: rgba(255,255,255,0.15) !important; color: var(--text-primary) !important; }
        [data-theme="dark"] .page-item.active .page-link { background: #22c55e !important; color: #fff !important; }
    </style>
</head>

<body id="page-top">
<div id="wrapper">

    <!-- SIDEBAR GURU -->
    <ul class="navbar-nav" id="accordionSidebar">

        <a class="sidebar-brand" href="/dashboard-guru">
            <img src="{{ asset('img/logo-smk.png') }}" alt="Logo SMK" class="logo-img">
            <div class="brand-text">
                <span class="brand-name">SMK Arrasyadiyyah</span>
                <span class="brand-sub">Panel Guru</span>
            </div>
        </a>

        <li class="nav-item {{ request()->is('dashboard-guru') ? 'active' : '' }}">
            <a class="nav-link" href="/dashboard-guru">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard Guru</span>
            </a>
        </li>

        <div class="nav-divider"></div>
        <div class="nav-section-label">Menu Akademik</div>

        <li class="nav-item {{ request()->routeIs('guru.jadwal_mingguan') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('guru.jadwal_mingguan') }}">
                <i class="fas fa-fw fa-calendar-alt"></i>
                <span>Jadwal Mengajar</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('nilai.pilih_kelas') || request()->routeIs('guru.input_nilai') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('nilai.pilih_kelas') }}">
                <i class="fas fa-fw fa-edit"></i>
                <span>Input Nilai Siswa</span>
            </a>
        </li>

        @php
            $isWaliKelas = \App\Models\Rombel::where('guru_id', Auth::guard('guru')->user()->id)->exists();
        @endphp
        @if($isWaliKelas)
            <div class="nav-divider"></div>
            <div class="nav-section-label">Wali Kelas</div>
            <li class="nav-item {{ request()->routeIs('walikelas.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('walikelas.index') }}">
                    <i class="fas fa-fw fa-user-check"></i>
                    <span>Panel Wali Kelas</span>
                </a>
            </li>
        @endif

        <div class="nav-divider"></div>
        <div class="text-center py-2">
            <button class="sidebar-toggle-btn" id="sidebarToggle">
                <i class="fas fa-angle-left" style="font-size:0.7rem; color:var(--text-muted);"></i>
            </button>
        </div>
    </ul>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

            <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars" style="color:var(--text-secondary);"></i>
                </button>
                <ul class="navbar-nav ml-auto align-items-center">
                    <button class="theme-toggle-btn" id="themeToggle">
                        <i class="fas fa-moon" id="themeIcon"></i>
                    </button>
                    <div class="topbar-divider d-none d-sm-block"></div>
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                           role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="topbar-user-name d-none d-lg-inline mr-2">
                                {{ Auth::guard('guru')->user()->nama_guru }}
                            </span>
                            @php $guru = Auth::guard('guru')->user(); @endphp
                            @if($guru->foto)
                                <img class="img-profile rounded-circle"
                                     src="{{ asset('storage/'.$guru->foto) }}"
                                     style="width:34px;height:34px;object-fit:cover;">
                            @else
                                <div class="avatar-circle">
                                    {{ strtoupper(substr($guru->nama_guru, 0, 1)) }}
                                </div>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>

            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>

        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; SMK Arrasyadiyyah 2026</span>
                </div>
            </div>
        </footer>
    </div>
</div>

<a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="background:var(--card-bg);border:1px solid var(--card-border);border-radius:16px;">
            <div class="modal-header" style="border-bottom:1px solid var(--card-border);">
                <h5 class="modal-title" style="color:var(--text-primary);font-weight:700;">Konfirmasi Logout</h5>
                <button class="close" type="button" data-dismiss="modal" style="color:var(--text-muted);">
                    <span>×</span>
                </button>
            </div>
            <div class="modal-body" style="color:var(--text-secondary);">Apakah Anda yakin ingin keluar dari sistem?</div>
            <div class="modal-footer" style="border-top:1px solid var(--card-border);">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_role" value="guru">
                    <button type="submit" class="btn btn-success font-weight-bold">Logout</button>
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
    const html2      = document.documentElement;
    const themeIcon2 = document.getElementById('themeIcon');
    const themeBtn2  = document.getElementById('themeToggle');
    const saved2     = localStorage.getItem('erapor_theme') || 'light';
    html2.setAttribute('data-theme', saved2);
    updateIcon2(saved2);
    themeBtn2.addEventListener('click', function() {
        const cur  = html2.getAttribute('data-theme');
        const next = cur === 'light' ? 'dark' : 'light';
        html2.setAttribute('data-theme', next);
        localStorage.setItem('erapor_theme', next);
        updateIcon2(next);
    });
    function updateIcon2(t) { themeIcon2.className = t === 'dark' ? 'fas fa-sun' : 'fas fa-moon'; }
    setTimeout(function() { $('.alert').fadeOut('slow'); }, 4000);
</script>
</body>
</html>
