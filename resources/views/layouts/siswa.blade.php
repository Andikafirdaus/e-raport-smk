<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Portal Siswa — SMK Arrasyadiyyah</title>
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <style>
        :root {
            --canvas:         #f4f5f7;
            --sidebar-bg:     #ffffff;
            --sidebar-border: #fde8d0;
            --topbar-bg:      #ffffff;
            --topbar-border:  #e5e7eb;
            --text-primary:   #2d1000;
            --text-secondary: #c06000;
            --text-muted:     #c09060;
            --accent:         #c06000;
            --accent-light:   #fff3e8;
            --accent-lime:    #c2ef4e;
            --card-bg:        #ffffff;
            --card-border:    #e5e7eb;
            --nav-active-bg:  #fff3e8;
            --nav-active-text:#c06000;
            --nav-hover-bg:   #fff8f2;
            --footer-bg:      #ffffff;
            --shadow-sm:      0 1px 3px rgba(192,96,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md:      0 4px 12px rgba(192,96,0,0.08);
            --radius-md:      8px;
            --radius-lg:      12px;
        }
        [data-theme="dark"] {
            --canvas:         #1f1100;
            --sidebar-bg:     #2d1800;
            --sidebar-border: #5c3300;
            --topbar-bg:      #2d1800;
            --topbar-border:  #5c3300;
            --text-primary:   #ffecd6;
            --text-secondary: #f0a050;
            --text-muted:     #805030;
            --accent:         #c2ef4e;
            --accent-light:   rgba(194,239,78,0.12);
            --card-bg:        #2d1800;
            --card-border:    #5c3300;
            --nav-active-bg:  rgba(194,239,78,0.12);
            --nav-active-text:#c2ef4e;
            --nav-hover-bg:   rgba(255,255,255,0.04);
            --footer-bg:      #2d1800;
        }

        * { transition: background-color 0.25s, color 0.2s, border-color 0.2s; }
        body { font-family: 'Rubik', system-ui, sans-serif; background: var(--canvas); color: var(--text-primary); }

        /* Sidebar */
        #accordionSidebar {
            background: var(--sidebar-bg) !important;
            border-right: 1px solid var(--sidebar-border);
            min-height: 100vh; width: 240px;
            box-shadow: 2px 0 12px rgba(192,96,0,0.06);
            transition: width 0.3s;
        }
        .sidebar-brand {
            padding: 1.2rem 1.5rem; display: flex; align-items: center; gap: 0.75rem;
            text-decoration: none; border-bottom: 1px solid var(--sidebar-border);
        }
        .sidebar-brand .logo-img { width: 42px; height: 42px; object-fit: contain; border-radius: 8px; flex-shrink: 0; }
        .brand-text { display: flex; flex-direction: column; }
        .brand-name { font-size: 0.92rem; font-weight: 700; color: var(--text-primary); line-height: 1.2; }
        .brand-sub  { font-size: 0.68rem; font-weight: 400; color: var(--text-secondary); }
        .nav-section-label {
            font-size: 0.62rem; font-weight: 700; letter-spacing: 1.2px;
            text-transform: uppercase; color: var(--text-muted); padding: 1rem 1.25rem 0.4rem;
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
            background: linear-gradient(135deg, #e08020, #c06000);
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
        .table thead th { background: var(--accent) !important; color: #fff !important; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px; border: none !important; }
        .table td, .table th { border-color: var(--card-border) !important; vertical-align: middle; }
        .btn-warning { background: var(--accent) !important; border-color: var(--accent) !important; color: #fff !important; }
        .btn-primary { background: #422082 !important; border-color: #422082 !important; }
        .alert { border-radius: var(--radius-md) !important; border: none !important; animation: slideDown 0.3s ease-out; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }
        .sticky-footer { background: var(--footer-bg) !important; border-top: 1px solid var(--topbar-border) !important; }
        .sticky-footer .copyright { color: var(--text-muted); font-size: 0.78rem; }
        .scroll-to-top { background: var(--accent) !important; color: #fff !important; }
        .border-left-warning { border-left: 4px solid var(--accent) !important; }
        .border-left-primary { border-left: 4px solid #422082 !important; }
        .border-left-success { border-left: 4px solid #1cc88a !important; }
        .border-left-info    { border-left: 4px solid #36b9cc !important; }
        .text-warning { color: var(--accent) !important; }

        /* ===== DARK MODE — Override Komprehensif ===== */
        [data-theme="dark"] body,
        [data-theme="dark"] #content-wrapper,
        [data-theme="dark"] #content,
        [data-theme="dark"] .wrapper { background-color: var(--canvas) !important; color: var(--text-primary) !important; }
        [data-theme="dark"] .container-fluid { background: var(--canvas) !important; }
        [data-theme="dark"] h1,[data-theme="dark"] h2,[data-theme="dark"] h3,
        [data-theme="dark"] h4,[data-theme="dark"] h5,[data-theme="dark"] h6,
        [data-theme="dark"] .h3,.h4,.h5,.h6 { color: var(--text-primary) !important; }
        [data-theme="dark"] .text-gray-800,[data-theme="dark"] .text-gray-700,
        [data-theme="dark"] .text-gray-600,[data-theme="dark"] .text-dark { color: var(--text-primary) !important; }
        [data-theme="dark"] .text-muted { color: var(--text-muted) !important; }
        [data-theme="dark"] p,[data-theme="dark"] span:not(.badge) { color: var(--text-primary); }
        [data-theme="dark"] small { color: var(--text-secondary) !important; }
        [data-theme="dark"] .table td { color: var(--text-primary) !important; background-color: var(--card-bg) !important; border-color: var(--card-border) !important; }
        [data-theme="dark"] .table-bordered { border-color: var(--card-border) !important; }
        [data-theme="dark"] .form-control { background-color: #3d1c00 !important; border-color: var(--card-border) !important; color: var(--text-primary) !important; }
        [data-theme="dark"] .form-control:focus { background-color: #4a2200 !important; box-shadow: 0 0 0 3px rgba(194,239,78,0.15) !important; }
        [data-theme="dark"] .modal-content { background: var(--card-bg) !important; border-color: var(--card-border) !important; color: var(--text-primary) !important; }
        [data-theme="dark"] .modal-header,[data-theme="dark"] .modal-footer { border-color: var(--card-border) !important; }
        [data-theme="dark"] label { color: var(--text-secondary) !important; }
        [data-theme="dark"] .input-group-text { background: #3d1c00 !important; border-color: var(--card-border) !important; color: var(--text-primary) !important; }
        [data-theme="dark"] select.form-control { background-color: #3d1c00 !important; color: var(--text-primary) !important; }
        [data-theme="dark"] .bg-light { background: #3d1c00 !important; }
        [data-theme="dark"] .bg-white { background: var(--card-bg) !important; }
        [data-theme="dark"] .card-footer.bg-white { background: var(--card-bg) !important; }
        [data-theme="dark"] .page-item .page-link { background: var(--card-bg) !important; border-color: var(--card-border) !important; color: var(--text-primary) !important; }
        [data-theme="dark"] .page-item.active .page-link { background: var(--accent) !important; color: #4a2000 !important; }
        /* Table border dark mode fix */
        [data-theme="dark"] .table th,[data-theme="dark"] .table tr { border-color: var(--card-border) !important; }
        [data-theme="dark"] .table tbody tr:hover td { background-color: rgba(194,239,78,0.06) !important; }
        [data-theme="dark"] .table-hover tbody tr:hover { background-color: rgba(255,255,255,0.05) !important; }
        [data-theme="dark"] .table thead th { background: var(--accent) !important; color: #4a2000 !important; border-color: var(--accent) !important; }
        [data-theme="dark"] .thead-dark th,[data-theme="dark"] .thead-light th { background: var(--accent) !important; color: #4a2000 !important; }
    </style>
</head>

<body id="page-top">
<div id="wrapper">

    <!-- SIDEBAR SISWA -->
    <ul class="navbar-nav" id="accordionSidebar">

        <a class="sidebar-brand" href="{{ route('dashboard.siswa') }}">
            <img src="{{ asset('img/logo-smk.png') }}" alt="Logo SMK" class="logo-img">
            <div class="brand-text">
                <span class="brand-name">SMK Arrasyadiyyah</span>
                <span class="brand-sub">Portal Siswa</span>
            </div>
        </a>

        <li class="nav-item {{ request()->routeIs('dashboard.siswa') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard.siswa') }}">
                <i class="fas fa-fw fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <div class="nav-divider"></div>
        <div class="nav-section-label">Akademik Saya</div>

        <li class="nav-item {{ request()->routeIs('siswa.nilai') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('siswa.nilai') }}">
                <i class="fas fa-fw fa-star"></i>
                <span>Nilai &amp; Raport</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('siswa.pilih_cetak') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('siswa.pilih_cetak') }}">
                <i class="fas fa-fw fa-print"></i>
                <span>Cetak Raport</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('siswa.profil') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('siswa.profil') }}">
                <i class="fas fa-fw fa-user-circle"></i>
                <span>Profil Saya</span>
            </a>
        </li>

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
                                {{ Auth::guard('siswa')->user()->nama ?? 'Siswa' }}
                            </span>
                            @php $siswa = Auth::guard('siswa')->user(); @endphp
                            @if($siswa->foto)
                                <img class="img-profile rounded-circle"
                                     src="{{ asset('storage/'.$siswa->foto) }}"
                                     style="width:34px;height:34px;object-fit:cover;">
                            @else
                                <div class="avatar-circle">
                                    {{ strtoupper(substr($siswa->nama ?? 'S', 0, 1)) }}
                                </div>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('siswa.profil') }}">
                                <i class="fas fa-user fa-sm fa-fw mr-2" style="color:var(--text-muted);"></i>
                                Profil Saya
                            </a>
                            <div class="dropdown-divider"></div>
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
            <div class="modal-body" style="color:var(--text-secondary);">Apakah Anda yakin ingin keluar dari portal siswa?</div>
            <div class="modal-footer" style="border-top:1px solid var(--card-border);">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_role" value="siswa">
                    <button type="submit" class="btn btn-warning font-weight-bold">Logout</button>
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
    const html3      = document.documentElement;
    const themeIcon3 = document.getElementById('themeIcon');
    const themeBtn3  = document.getElementById('themeToggle');
    const saved3     = localStorage.getItem('erapor_theme') || 'light';
    html3.setAttribute('data-theme', saved3);
    updateIcon3(saved3);
    themeBtn3.addEventListener('click', function() {
        const cur  = html3.getAttribute('data-theme');
        const next = cur === 'light' ? 'dark' : 'light';
        html3.setAttribute('data-theme', next);
        localStorage.setItem('erapor_theme', next);
        updateIcon3(next);
    });
    function updateIcon3(t) { themeIcon3.className = t === 'dark' ? 'fas fa-sun' : 'fas fa-moon'; }
    setTimeout(function() { $('.alert').fadeOut('slow'); }, 4000);
</script>
</body>
</html>
