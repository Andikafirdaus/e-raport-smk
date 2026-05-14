<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\TahunAkademikController;
use App\Http\Controllers\RombelController;
use App\Http\Controllers\DashboardGuruController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\WaliKelasController;
use App\Http\Controllers\JadwalMengajarController;
use App\Http\Controllers\DashboardSiswaController;

// --- JALUR PINTU ADMIN ---
Route::get('/login-admin', [AuthController::class, 'loginAdmin'])->name('login.admin');
Route::post('/login-admin', [AuthController::class, 'authAdmin']);

// --- JALUR PINTU GURU ---
Route::get('/login-guru', [AuthController::class, 'loginGuru'])->name('login.guru');
Route::post('/login-guru', [AuthController::class, 'authGuru']);

// --- JALUR PINTU SISWA ---
Route::get('/login-siswa', [AuthController::class, 'loginSiswa'])->name('login.siswa');
Route::post('/login-siswa', [AuthController::class, 'authSiswa']);

// Rute khusus halaman Dashboard Admin
Route::get('/dashboard-admin', function () {
    $totalSiswa  = \App\Models\Siswa::count();
    $siswaAktif  = \App\Models\Siswa::where('status', 'Aktif')->count();
    $totalGuru   = \App\Models\Guru::count();
    $guruAktif   = \App\Models\Guru::where('status', 'Aktif')->count();
    $totalMapel  = \App\Models\Mapel::count();
    $totalKelas  = \App\Models\Kelas::count();
    $jurusans    = \App\Models\Jurusan::withCount('kelas')->get();

    $tahunAktif  = \App\Models\TahunAkademik::where('status', 'Aktif')->first();
    $rombels     = \App\Models\Rombel::with(['kelas', 'waliKelas', 'siswas'])
                    ->when($tahunAktif, fn($q) => $q->where('tahun_akademik_id', $tahunAktif->id))
                    ->get();
    $totalRombel = $rombels->count();
    return view('admin.dashboard', compact(
        'totalSiswa','siswaAktif','totalGuru','guruAktif',
        'totalMapel','totalKelas','jurusans','tahunAktif','rombels','totalRombel'
    ));
})->middleware('auth');

// Grup besar untuk semua Master Data di Dashboard Admin
Route::middleware('auth:web')->prefix('dashboard-admin')->group(function () {

    // Profil Admin
    Route::get('/profil', [App\Http\Controllers\AdminProfileController::class, 'index'])->name('admin.profil');
    Route::put('/profil/update', [App\Http\Controllers\AdminProfileController::class, 'update'])->name('admin.profil.update');

    // CRUD Master Data
    Route::resource('jurusan', JurusanController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('mapel', MapelController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('tahun-akademik', TahunAkademikController::class);
    Route::get('/tahun-akademik/aktifkan/{id}', [TahunAkademikController::class, 'aktifkan'])->name('tahun.aktifkan');
    Route::post('rombel/{id}/add', [RombelController::class, 'addSiswa']);
    Route::post('rombel/{id}/remove', [RombelController::class, 'removeSiswa']);
    Route::resource('rombel', RombelController::class);
    Route::resource('jadwal', JadwalMengajarController::class);

    // Status update
    Route::put('/siswa/{id}/status', [SiswaController::class, 'updateStatus'])->name('siswa.update_status');
    Route::put('/guru/{id}/status', [GuruController::class, 'updateStatus'])->name('guru.update_status');

    // Detail show
    Route::get('/siswa/{id}/detail', [SiswaController::class, 'show'])->name('siswa.show');
    Route::get('/guru/{id}/detail', [GuruController::class, 'show'])->name('guru.show');

    // Siswa per jurusan
    Route::get('/jurusan/{id}/siswa', [JurusanController::class, 'showSiswa'])->name('jurusan.siswa');
});

// --- AREA GURU ---
Route::middleware('auth:guru')->group(function () {
    Route::get('/dashboard-guru', [DashboardGuruController::class, 'index'])->name('dashboard.guru');
    Route::get('/dashboard-guru/jadwal-mingguan', [DashboardGuruController::class, 'jadwalMingguan'])->name('guru.jadwal_mingguan');

    Route::get('/guru/nilai/pilih-kelas', [NilaiController::class, 'pilihKelas'])->name('nilai.pilih_kelas');
    Route::get('/guru/nilai/input/{jadwal_id}', [NilaiController::class, 'input'])->name('guru.input_nilai');
    Route::post('/guru/nilai/simpan', [NilaiController::class, 'store'])->name('nilai.store');

    Route::get('/dashboard-guru/wali-kelas', [WaliKelasController::class, 'index'])->name('walikelas.index');
    Route::get('/dashboard-guru/wali-kelas/siswa/{id}', [WaliKelasController::class, 'showSiswa'])->name('walikelas.siswa');
    Route::post('/dashboard-guru/wali-kelas/siswa/{id}/simpan', [WaliKelasController::class, 'simpanCatatan'])->name('walikelas.simpan');
    Route::get('/dashboard-guru/wali-kelas/cetak/{id}/pilih', [WaliKelasController::class, 'pilihCetak'])->name('walikelas.pilih_cetak');
    Route::get('/dashboard-guru/wali-kelas/cetak/{id}', [WaliKelasController::class, 'cetakRaport'])->name('walikelas.cetak');
});

// --- AREA SISWA ---
Route::middleware('auth:siswa')->group(function () {
    Route::get('/dashboard-siswa', [DashboardSiswaController::class, 'index'])->name('dashboard.siswa');
    Route::get('/siswa-portal/nilai', [DashboardSiswaController::class, 'nilai'])->name('siswa.nilai');
    Route::get('/siswa-portal/cetak-raport', [DashboardSiswaController::class, 'cetakRaport'])->name('siswa.cetak_raport');
    Route::get('/siswa-portal/pilih-cetak', [DashboardSiswaController::class, 'pilihCetak'])->name('siswa.pilih_cetak');
    Route::get('/siswa-portal/profil', [DashboardSiswaController::class, 'profil'])->name('siswa.profil');
    Route::post('/siswa-portal/profil/update', [DashboardSiswaController::class, 'updateProfil'])->name('siswa.profil.update');
});

// --- JALUR LOGOUT ---
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
