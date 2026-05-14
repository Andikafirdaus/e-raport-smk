<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Tampilan Form Login (Tetap sama)
    public function loginAdmin() { return view('auth.login', ['role' => 'admin']); }
    public function loginGuru() { return view('auth.login', ['role' => 'guru']); }
    public function loginSiswa() { return view('auth.login', ['role' => 'siswa']); }

    // --- PROSES LOGIN ADMIN ---
    public function authAdmin(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Pake guard default ('web') buat ngecek ke tabel users
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/dashboard-admin');
        }

        return back()->withErrors(['email' => 'Akses ditolak! Email atau Password Admin salah.']);
    }

    // --- PROSES LOGIN GURU ---
    public function authGuru(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Pake guard 'guru' buat ngecek ke tabel gurus
        if (Auth::guard('guru')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/dashboard-guru');
        }

        return back()->withErrors(['email' => 'Akses ditolak! Email atau Password Guru salah.']);
    }

    // --- PROSES LOGIN SISWA ---
    public function authSiswa(Request $request) {
        // Karena form di tampilan blade pakai name="email",
        // kita validasi 'email' tapi JANGAN pake aturan 'email' (karena isinya angka NISN)
        $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        // Kita akali: inputan 'email' kita paksa masukin ke kolom 'nisn'
        $credentials = [
            'nisn' => $request->email,
            'password' => $request->password
        ];

        // Pake guard 'siswa' buat ngecek ke tabel siswas
        if (Auth::guard('siswa')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/dashboard-siswa');
        }

        return back()->withErrors(['email' => 'Akses ditolak! NISN atau Password Siswa salah.']);
    }

    // --- FUNGSI KELUAR GEDUNG (LOGOUT) MULTI-GUARD ---
    public function logout(Request $request) {
        // Tentukan redirect path sesuai guard yang aktif
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            $redirectPath = '/login-admin';
        } elseif (Auth::guard('guru')->check()) {
            Auth::guard('guru')->logout();
            $redirectPath = '/login-guru';
        } elseif (Auth::guard('siswa')->check()) {
            Auth::guard('siswa')->logout();
            $redirectPath = '/login-siswa';
        } else {
            // Fallback: gunakan hint _role dari form jika guard sudah tidak bisa dideteksi
            $role = $request->input('_role', 'admin');
            $redirectPath = match($role) {
                'guru'  => '/login-guru',
                'siswa' => '/login-siswa',
                default => '/login-admin',
            };
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect($redirectPath);
    }
}
