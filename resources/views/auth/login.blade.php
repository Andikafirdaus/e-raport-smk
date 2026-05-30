<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login {{ ucfirst($role) }} — E-Rapor SMK Arrasyadiyyah</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --ink:        #1a2540;
            --ink-muted:  #5a6a8a;
            --canvas:     #f4f5f7;
            --white:      #ffffff;
            --border:     #e5e7eb;
            --radius-md:  8px;
            --radius-lg:  12px;
            --radius-full:9999px;
        }

        /* ===== Per-role solid colors ===== */
        .role-admin  { --role-bg:#1e3a8a; --role-mid:#2563eb; --role-light:#dbeafe; --role-focus-rgb:37,99,235; }
        .role-guru   { --role-bg:#14532d; --role-mid:#16a34a; --role-light:#dcfce7; --role-focus-rgb:22,163,74; }
        .role-siswa  { --role-bg:#92400e; --role-mid:#d97706; --role-light:#fef3c7; --role-focus-rgb:217,119,6; }

        body {
            font-family: 'Rubik', system-ui, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--canvas);
        }

        /* ===== MOBILE HEADER — tampil hanya di HP ===== */
        .mobile-header {
            display: none;
            background: var(--role-bg);
            padding: 1.5rem 1.25rem 2rem;
            text-align: center;
            color: #fff;
        }
        .mobile-logo-wrap {
            width: 80px; height: 80px;
            margin: 0 auto 0.9rem;
            border-radius: 16px;
            background: rgba(255,255,255,0.15);
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
        }
        .mobile-logo-wrap img {
            width: 64px; height: 64px; object-fit: contain;
        }
        .mobile-school-name {
            font-size: 1.05rem; font-weight: 800;
            letter-spacing: 0.2px; margin-bottom: 0.2rem;
        }
        .mobile-school-sub {
            font-size: 0.72rem; opacity: 0.78;
        }
        .mobile-role-badge {
            display: inline-block;
            margin-top: 0.7rem;
            padding: 0.3rem 1rem;
            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: var(--radius-full);
            font-size: 0.72rem; font-weight: 700;
            letter-spacing: 1px; text-transform: uppercase;
        }
        /* Curved bottom edge on mobile header */
        .mobile-header::after {
            content: '';
            display: block;
            height: 20px;
            background: var(--canvas);
            border-radius: 50% 50% 0 0 / 20px;
            margin: 1rem -1.25rem -1px;
        }

        /* ===== DESKTOP LAYOUT ===== */
        .page-wrap {
            display: flex;
            flex: 1;
            min-height: 100vh;
        }

        /* ===== LEFT PANEL — Solid color, no decorations ===== */
        .left-panel {
            width: 52%;
            min-height: 100vh;
            background: var(--role-bg);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem 2.5rem;
        }

        .left-content {
            text-align: center;
            color: #fff;
            max-width: 380px;
            width: 100%;
        }

        /* Logo — lebih besar, tidak ada circle wrap */
        .logo-img-wrap {
            width: 140px; height: 140px;
            margin: 0 auto 1.6rem;
            border-radius: 24px;
            background: rgba(255,255,255,0.12);
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
        }
        .logo-img-wrap img {
            width: 116px; height: 116px;
            object-fit: contain;
        }

        .left-content h1 {
            font-size: 2rem; font-weight: 800; line-height: 1.2;
            margin-bottom: 0.3rem;
        }
        .left-content .subtitle {
            font-size: 0.83rem; opacity: 0.72; font-weight: 400;
            letter-spacing: 0.3px; margin-bottom: 1.3rem;
        }
        .role-badge {
            display: inline-block; padding: 0.4rem 1.4rem;
            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.32);
            border-radius: var(--radius-full);
            font-size: 0.78rem; font-weight: 700;
            letter-spacing: 1px; text-transform: uppercase;
            margin-bottom: 2.2rem;
        }

        /* Feature list */
        .features { text-align: left; width: 100%; }
        .feature-item {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.55rem 0; font-size: 0.85rem; font-weight: 400;
            color: rgba(255,255,255,0.88);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .feature-item:last-child { border-bottom: none; }
        .feature-item i {
            width: 20px; text-align: center;
            color: rgba(255,255,255,0.9); font-size: 0.85rem;
        }
        .divider-bar {
            display: block; width: 40px; height: 3px;
            background: rgba(255,255,255,0.5); border-radius: 99px;
            margin: 1.6rem auto 0;
        }

        /* ===== RIGHT PANEL ===== */
        .right-panel {
            width: 48%;
            min-height: 100vh;
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 2rem;
        }

        .login-card {
            width: 100%; max-width: 400px;
            animation: slideIn 0.5s cubic-bezier(0.16,1,0.3,1);
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(24px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .login-card .eyebrow {
            font-size: 0.7rem; font-weight: 700;
            letter-spacing: 1.5px; text-transform: uppercase;
            color: var(--role-mid); margin-bottom: 0.5rem;
        }
        .login-card h2 {
            font-size: 1.75rem; font-weight: 700;
            color: var(--ink); margin-bottom: 0.3rem; line-height: 1.2;
        }
        .login-card .sub {
            color: var(--ink-muted); font-size: 0.88rem;
            margin-bottom: 2rem; font-weight: 400;
        }

        .form-label {
            font-size: 0.78rem; font-weight: 600; letter-spacing: 0.3px;
            text-transform: uppercase; color: var(--ink-muted);
            margin-bottom: 0.4rem; display: block;
        }

        .input-wrap { position: relative; margin-bottom: 1.2rem; }
        .input-wrap .icon-left {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            color: #b5b0bc; font-size: 0.85rem; z-index: 3;
        }
        .input-wrap input {
            width: 100%; padding: 12px 12px 12px 38px;
            background: #f8f9fc; border: 1.5px solid var(--border);
            border-radius: var(--radius-md);
            font-family: 'Rubik', sans-serif;
            font-size: 0.95rem; font-weight: 500;
            color: var(--ink); transition: border 0.2s, box-shadow 0.2s, background 0.2s; outline: none;
        }
        .input-wrap input::placeholder { color: #b5b0bc; }
        .input-wrap input:focus {
            border-color: var(--role-mid);
            box-shadow: 0 0 0 3px rgba(var(--role-focus-rgb), 0.12);
            background: #fff;
        }
        .toggle-pw {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            color: #b5b0bc; cursor: pointer; background: none; border: none;
            font-size: 0.85rem; z-index: 3; padding: 0;
        }
        .toggle-pw:hover { color: var(--ink-muted); }

        .btn-login {
            width: 100%; padding: 13px 16px; border: none;
            border-radius: var(--radius-md); font-family: 'Rubik', sans-serif;
            font-size: 0.9rem; font-weight: 700; letter-spacing: 0.2px;
            text-transform: uppercase; color: #fff; cursor: pointer;
            margin-top: 0.5rem; transition: all 0.25s;
            background: var(--role-bg);
        }
        .btn-login:hover {
            background: var(--role-mid);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.22);
        }
        .btn-login:active { transform: translateY(0); }

        .alert-err {
            background: #fff5f5; color: #c53030; border-left: 4px solid #fc8181;
            border-radius: var(--radius-md); padding: 0.75rem 1rem;
            font-size: 0.85rem; margin-bottom: 1.2rem;
        }

        /* ===== RESPONSIVE — HP / MOBILE ===== */
        @media (max-width: 768px) {
            body { flex-direction: column; }
            .mobile-header { display: block; }
            .page-wrap { flex-direction: column; min-height: auto; }
            .left-panel { display: none; }
            .right-panel {
                width: 100%;
                min-height: auto;
                padding: 2rem 1.25rem 3rem;
                background: var(--canvas);
                align-items: flex-start;
            }
            .login-card {
                max-width: 100%;
                background: #fff;
                border-radius: 16px;
                padding: 1.75rem 1.5rem;
                box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            }
            .login-card .eyebrow { display: none; }
            .login-card h2 { font-size: 1.4rem; }
            .input-wrap input { font-size: 1rem; padding: 13px 13px 13px 40px; }
            .btn-login { padding: 14px; font-size: 0.95rem; }
        }

        @media (max-width: 420px) {
            .right-panel { padding: 1.5rem 1rem 2.5rem; }
            .login-card { padding: 1.5rem 1.25rem; }
        }
    </style>
</head>
<body class="role-{{ $role }}">

    <!-- MOBILE HEADER — hanya tampil di HP -->
    <div class="mobile-header">
        <div class="mobile-logo-wrap">
            <img src="{{ asset('img/logo-smk.png') }}" alt="Logo SMK Arrasyadiyyah">
        </div>
        <div class="mobile-school-name">SMK Arrasyadiyyah</div>
        <div class="mobile-school-sub">Cigedong Kelanggaran Unyur Serang — Banten</div>
        <span class="mobile-role-badge">
            @if($role === 'admin') Portal Admin
            @elseif($role === 'guru') Portal Guru
            @else Portal Siswa
            @endif
        </span>
    </div>

    <div class="page-wrap">
        <!-- LEFT PANEL — hanya desktop, solid color -->
        <div class="left-panel">
            <div class="left-content">
                <div class="logo-img-wrap">
                    <img src="{{ asset('img/logo-smk.png') }}" alt="Logo SMK Arrasyadiyyah">
                </div>
                <h1>SMK Arrasyadiyyah</h1>
                <p class="subtitle">Cigedong Kelanggaran Unyur Serang — Banten</p>
                <div class="role-badge">
                    @if($role === 'admin') Portal Admin
                    @elseif($role === 'guru') Portal Guru
                    @else Portal Siswa
                    @endif
                </div>

                <div class="features">
                    @if($role === 'admin')
                        <div class="feature-item"><i class="fas fa-users"></i> Kelola data guru &amp; siswa</div>
                        <div class="feature-item"><i class="fas fa-calendar-check"></i> Atur jadwal &amp; rombel kelas</div>
                        <div class="feature-item"><i class="fas fa-chart-bar"></i> Monitor akademik sekolah</div>
                        <div class="feature-item"><i class="fas fa-cog"></i> Manajemen tahun akademik</div>
                    @elseif($role === 'guru')
                        <div class="feature-item"><i class="fas fa-edit"></i> Input nilai siswa dengan mudah</div>
                        <div class="feature-item"><i class="fas fa-calendar-alt"></i> Lihat jadwal mengajar</div>
                        <div class="feature-item"><i class="fas fa-file-alt"></i> Kelola raport sebagai wali kelas</div>
                        <div class="feature-item"><i class="fas fa-user-check"></i> Rekap kehadiran siswa</div>
                    @else
                        <div class="feature-item"><i class="fas fa-chart-line"></i> Pantau nilai &amp; perkembangan belajar</div>
                        <div class="feature-item"><i class="fas fa-calendar-week"></i> Lihat jadwal pelajaran</div>
                        <div class="feature-item"><i class="fas fa-print"></i> Cetak raport secara mandiri</div>
                        <div class="feature-item"><i class="fas fa-user-circle"></i> Kelola profil siswa</div>
                    @endif
                </div>
                <span class="divider-bar"></span>
            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="right-panel">
            <div class="login-card">
                <p class="eyebrow">
                    @if($role === 'admin') Admin
                    @elseif($role === 'guru') Guru
                    @else Siswa
                    @endif
                </p>
                <h2>Selamat Datang</h2>
                <p class="sub">Masuk ke sistem E-Rapor SMK Arrasyadiyyah</p>

                @if($errors->any())
                    <div class="alert-err">
                        <i class="fas fa-exclamation-circle" style="margin-right:6px;"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="/login-{{ $role }}" method="POST" autocomplete="off">
                    @csrf

                    <label class="form-label">{{ $role === 'siswa' ? 'NISN' : 'Email' }}</label>
                    <div class="input-wrap">
                        <i class="icon-left fas {{ $role === 'siswa' ? 'fa-id-card' : 'fa-envelope' }}"></i>
                        @if($role === 'siswa')
                            <input type="text" name="email" id="inp_main"
                                   placeholder="Masukkan NISN kamu" required autofocus>
                        @else
                            <input type="email" name="email" id="inp_main"
                                   placeholder="contoh@email.com" required autofocus>
                        @endif
                    </div>

                    <label class="form-label">Password</label>
                    <div class="input-wrap">
                        <i class="icon-left fas fa-lock"></i>
                        <input type="password" name="password" id="inp_pw"
                               placeholder="Masukkan password" required>
                        <button type="button" class="toggle-pw" onclick="togglePw()">
                            <i class="fas fa-eye" id="pw-eye"></i>
                        </button>
                    </div>

                    <button type="submit" class="btn-login" id="btn_submit">
                        <i class="fas fa-sign-in-alt" style="margin-right:6px;"></i>
                        Masuk ke Sistem
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePw() {
            const inp = document.getElementById('inp_pw');
            const eye = document.getElementById('pw-eye');
            if (inp.type === 'password') {
                inp.type = 'text';
                eye.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                inp.type = 'password';
                eye.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>
