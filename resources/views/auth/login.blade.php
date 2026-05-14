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
            --accent-lime:#c2ef4e;
            --ink:        #1a2540;
            --ink-muted:  #5a6a8a;
            --canvas:     #f4f5f7;
            --white:      #ffffff;
            --border:     #e5e7eb;
            --radius-md:  8px;
            --radius-lg:  12px;
            --radius-full:9999px;
        }
        /* ===== Per-role accent colors ===== */
        .role-admin  { --role-start:#0033cc; --role-end:#2563eb; --role-mid:#3b82f6; --role-light:#dbeafe; }
        .role-guru   { --role-start:#0a2e18; --role-end:#1b6b3a; --role-mid:#2e9950; --role-light:#d1fae5; }
        .role-siswa  { --role-start:#92400e; --role-end:#d97706; --role-mid:#f59e0b; --role-light:#fef3c7; }

        body {
            font-family: 'Rubik', system-ui, sans-serif;
            min-height: 100vh;
            display: flex;
            background: var(--canvas);
            overflow: hidden;
        }

        /* ===== LEFT PANEL — warna per role ===== */
        .left-panel {
            width: 52%;
            min-height: 100vh;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            overflow: hidden;
            background: linear-gradient(145deg, var(--role-start) 0%, var(--role-end) 60%, var(--role-mid) 100%);
        }

        /* Starfield dots */
        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle, rgba(255,255,255,0.22) 1px, transparent 1px),
                radial-gradient(circle, rgba(255,255,255,0.12) 1px, transparent 1px);
            background-size: 45px 45px, 90px 90px;
            background-position: 0 0, 22px 22px;
            pointer-events: none;
        }

        /* Floating orbs */
        .orb {
            position: absolute; border-radius: 50%;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.07);
            animation: floatOrb 10s ease-in-out infinite;
        }
        .orb:nth-child(1) { width: 360px; height: 360px; top: -100px; left: -100px; animation-delay: 0s; }
        .orb:nth-child(2) { width: 220px; height: 220px; bottom: 40px; right: -60px; animation-delay: 3s; }
        .orb:nth-child(3) { width: 140px; height: 140px; top: 45%; left: 5%; animation-delay: 6s; }

        @keyframes floatOrb {
            0%, 100% { transform: translateY(0) scale(1); }
            50%       { transform: translateY(-22px) scale(1.04); }
        }

        .left-content {
            position: relative; z-index: 10;
            text-align: center; color: #fff; max-width: 400px;
        }

        /* Logo */
        .logo-wrap {
            width: 100px; height: 100px; border-radius: 50%;
            background: rgba(255,255,255,0.12);
            border: 2px solid rgba(255,255,255,0.25);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.5rem; overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            animation: pulse 3s ease-in-out infinite;
        }
        .logo-wrap img { width: 80px; height: 80px; object-fit: contain; }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 8px 32px rgba(0,0,0,0.3); }
            50%       { box-shadow: 0 12px 48px rgba(0,0,0,0.45); }
        }

        .left-content h1 {
            font-size: 1.9rem; font-weight: 800; line-height: 1.2;
            margin-bottom: 0.3rem; text-shadow: 0 2px 12px rgba(0,0,0,0.3);
        }
        .left-content .subtitle {
            font-size: 0.85rem; opacity: 0.75; font-weight: 400;
            letter-spacing: 0.3px; margin-bottom: 1.4rem;
        }
        .role-badge {
            display: inline-block; padding: 0.4rem 1.2rem;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: var(--radius-full);
            font-size: 0.78rem; font-weight: 600;
            letter-spacing: 1px; text-transform: uppercase; margin-bottom: 2rem;
        }

        /* Feature list — plain, no glassmorphism */
        .features { text-align: left; }
        .feature-item {
            display: flex; align-items: center; gap: 0.7rem;
            padding: 0.5rem 0; font-size: 0.85rem; font-weight: 400;
            color: rgba(255,255,255,0.88);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .feature-item:last-child { border-bottom: none; }
        .feature-item i {
            width: 20px; text-align: center;
            color: var(--accent-lime); font-size: 0.85rem;
        }
        .lime-bar {
            display: block; width: 40px; height: 3px;
            background: var(--accent-lime); border-radius: 99px;
            margin: 1.5rem auto 0;
        }

        /* ===== RIGHT PANEL ===== */
        .right-panel {
            width: 48%; min-height: 100vh; background: var(--white);
            display: flex; align-items: center; justify-content: center; padding: 2rem;
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
            width: 100%; padding: 10px 12px 10px 36px;
            background: #f8f9fc; border: 1.5px solid var(--border);
            border-radius: var(--radius-md);
            font-family: 'Rubik', sans-serif;
            font-size: 0.92rem; font-weight: 500;
            color: var(--ink); transition: border 0.2s, box-shadow 0.2s, background 0.2s; outline: none;
        }
        .input-wrap input::placeholder { color: #b5b0bc; }
        .input-wrap input:focus {
            border-color: var(--role-mid);
            box-shadow: 0 0 0 3px rgba(var(--role-focus-rgb, 59,130,246), 0.12);
            background: #fff;
        }
        .toggle-pw {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            color: #b5b0bc; cursor: pointer; background: none; border: none;
            font-size: 0.85rem; z-index: 3; padding: 0;
        }
        .toggle-pw:hover { color: var(--ink-muted); }

        .btn-login {
            width: 100%; padding: 11px 16px; border: none;
            border-radius: var(--radius-md); font-family: 'Rubik', sans-serif;
            font-size: 0.85rem; font-weight: 700; letter-spacing: 0.2px;
            text-transform: uppercase; color: #fff; cursor: pointer;
            margin-top: 0.5rem; transition: all 0.25s;
            position: relative; overflow: hidden;
            background: linear-gradient(135deg, var(--role-start), var(--role-mid));
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.22); }
        .btn-login:active { transform: translateY(0); }
        .btn-shine {
            position: absolute; top: 0; left: -100%; width: 60%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.18), transparent);
            animation: shine 3s ease-in-out infinite;
        }
        @keyframes shine { 0% { left: -100%; } 50%, 100% { left: 150%; } }

        .alert-err {
            background: #fff5f5; color: #c53030; border-left: 4px solid #fc8181;
            border-radius: var(--radius-md); padding: 0.75rem 1rem;
            font-size: 0.85rem; margin-bottom: 1.2rem;
        }

        @media (max-width: 768px) {
            .left-panel { display: none; }
            .right-panel { width: 100%; }
        }
    </style>
</head>
<body class="role-{{ $role }}">

    <!-- LEFT PANEL -->
    <div class="left-panel">
        <div class="orb"></div>
        <div class="orb"></div>
        <div class="orb"></div>

        <div class="left-content">
            <div class="logo-wrap">
                <img src="/rapor-smk/public/img/logo-smk.png" alt="Logo SMK Arrasyadiyyah">
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
            <span class="lime-bar"></span>
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

                <button type="submit" class="btn-login">
                    <span class="btn-shine"></span>
                    <i class="fas fa-sign-in-alt" style="margin-right:6px;"></i>
                    Masuk ke Sistem
                </button>
            </form>


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