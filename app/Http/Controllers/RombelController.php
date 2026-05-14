<?php

namespace App\Http\Controllers;

use App\Models\Rombel;
use App\Models\TahunAkademik;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Models\Guru;

class RombelController extends Controller
{
    /**
     * Menampilkan daftar Rombel berdasarkan Tahun Akademik yang aktif.
     */
    public function index()
    {
        $tahunAktif = TahunAkademik::where('status', 'Aktif')->first();
        $rombels = collect();
        $kelasList = Kelas::with('jurusan')->get();

        // --- TAMBAHAN BARU: Ambil semua data guru untuk pilihan Wali Kelas ---
        $guruList = Guru::orderBy('nama_guru', 'asc')->get();

        if ($tahunAktif) {
            // Tambahkan relasi 'waliKelas' agar nama guru muncul di tabel
            $rombels = Rombel::with(['kelas.jurusan', 'waliKelas'])
                            ->withCount('siswas')
                            ->where('tahun_akademik_id', $tahunAktif->id)
                            ->get();
        }

        // --- TAMBAHAN BARU: Lempar variabel $guruList ke view ---
        return view('admin.rombel.index', compact('tahunAktif', 'rombels', 'kelasList', 'guruList'));
    }

    /**
     * Menyimpan data Rombel baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input: pastikan kelas dipilih (dan sekarang ditambah guru_id)
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'guru_id'  => 'required|exists:gurus,id', // Wajib diisi ID Guru yang valid
        ]);

        $tahunAktif = TahunAkademik::where('status', 'Aktif')->first();

        if (!$tahunAktif) {
            return redirect()->back()->with('error', 'Gagal! Tidak ada Tahun Akademik yang aktif.');
        }

        // 4. Simpan ke tabel rombels (ditambah guru_id)
        Rombel::firstOrCreate([
            'tahun_akademik_id' => $tahunAktif->id,
            'kelas_id'          => $request->kelas_id,
        ], [
            // Nilai default jika membuat baru
            'guru_id'           => $request->guru_id,
        ]);

        return redirect()->back()->with('success', 'Rombel berhasil dibuka untuk tahun ajaran ini!');
    }

public function show(string $id)
    {
        // 1. Ambil data Rombel beserta relasi kelas dan tahun akademiknya
        $rombel = Rombel::with(['kelas', 'tahunAkademik'])->findOrFail($id);

        // 2. Ambil siswa yang sudah jadi anggota rombel ini
        $anggotaRombel = $rombel->siswas()->orderBy('nama', 'asc')->get();

        // 3. Ambil siswa yang BELUM punya kelas di tahun akademik aktif rombel tersebut
        $siswaTersedia = Siswa::whereDoesntHave('rombels', function($query) use ($rombel) {
            $query->where('tahun_akademik_id', $rombel->tahun_akademik_id);
        })->orderBy('nama', 'asc')->get();

        // 4. Lempar data ke halaman view manage.blade.php
        return view('admin.rombel.manage', compact('rombel', 'anggotaRombel', 'siswaTersedia'));
    }
    // Fungsi untuk memasukkan siswa ke kelas (Rombel)
    public function addSiswa(Request $request, string $id)
    {
        // Validasi: pastikan minimal ada 1 siswa yang dicentang
        $request->validate([
            'siswa_id' => 'required|array',
            'siswa_id.*' => 'exists:siswas,id'
        ]);

        $rombel = Rombel::findOrFail($id);

        // attach() adalah fungsi pintar Laravel untuk memasukkan banyak data ke tabel perantara (rombel_siswa) sekaligus
        $rombel->siswas()->attach($request->siswa_id);

        return redirect()->back()->with('success', 'Siswa terpilih berhasil dimasukkan ke kelas!');
    }

    // Fungsi untuk mengeluarkan siswa dari kelas (Rombel)
    public function removeSiswa(Request $request, string $id)
    {
        // Validasi: pastikan minimal ada 1 siswa yang dicentang
        $request->validate([
            'siswa_id' => 'required|array',
            'siswa_id.*' => 'exists:siswas,id'
        ]);

        $rombel = Rombel::findOrFail($id);

        // detach() adalah kebalikan dari attach(), gunanya untuk mencabut relasi data
        $rombel->siswas()->detach($request->siswa_id);

        return redirect()->back()->with('success', 'Siswa terpilih berhasil dikeluarkan dari kelas!');
    }

    /**
     * Menghapus data Rombel.
     */
    public function destroy(string $id)
    {
        // 1. Cari data rombel berdasarkan ID
        $rombel = Rombel::findOrFail($id);

        // 2. Lepaskan/hapus dulu semua relasi siswa di rombel ini agar database tidak error
        $rombel->siswas()->detach();

        // 3. Hapus data rombelnya
        $rombel->delete();

        // 4. Tendang balik user ke halaman utama rombel dengan pesan sukses
        return redirect()->back()->with('success', 'Rombel berhasil dihapus!');
    }
    // (Method create, show, edit, update sengaja saya hilangkan karena kita pakai Modal di halaman index)
}
