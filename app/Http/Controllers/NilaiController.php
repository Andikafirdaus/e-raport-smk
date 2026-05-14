<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalMengajar;
use App\Models\Nilai;
use App\Models\TahunAkademik;

class NilaiController extends Controller
{

public function pilihKelas()
{
    $guru_id = auth()->guard('guru')->user()->id;

    // Ambil daftar jadwal mengajar si guru
    $jadwals = JadwalMengajar::with(['mapel', 'rombel.kelas'])
                ->where('guru_id', $guru_id)
                ->get();

    return view('guru.pilih_kelas', compact('jadwals'));
}

// Fungsi buat nampilin halaman input (pindahan dari DashboardGuruController)


    public function input(string $jadwal_id)
    {
        $jadwal = JadwalMengajar::with(['mapel', 'rombel.kelas'])->findOrFail($jadwal_id);
        $siswas = $jadwal->rombel->siswas()->orderBy('nama', 'asc')->get();

        return view('guru.input_nilai', compact('jadwal', 'siswas'));
    }

    // Fungsi buat simpan & hitung otomatis (Logika utamanya di sini)
    public function store(Request $request)
{
    // 1. Ambil tahun akademik yang aktif
    $tahunAktif = TahunAkademik::where('status', 'Aktif')->first();

    if (!$tahunAktif) {
        return redirect()->back()->with('error', 'Tahun Akademik aktif tidak ditemukan!');
    }

    // 2. Looping data nilai dari form
    foreach ($request->nilai as $siswa_id => $data) {

        // Ambil nilai mentah
        $uh1 = $data['uh_1'];
        $uh2 = $data['uh_2'];
        $uh3 = $data['uh_3'];
        $pts = $data['pts'];
        $pas = $data['pas'];
        $keterampilan = $data['keterampilan'];

        // 3. RUMUS MESIN HITUNG (Akumulasi Nilai Pengetahuan)
        // Kita gunakan rata-rata sederhana: (UH1+UH2+UH3+PTS+PAS) / 5
        $nilai_pengetahuan = ($uh1 + $uh2 + $uh3 + $pts + $pas) / 5;

        // 4. Hitung Nilai Akhir Rapor (Rata-rata Pengetahuan & Keterampilan)
        $nilai_akhir = ($nilai_pengetahuan + $keterampilan) / 2;

        // 5. Tentukan Predikat Otomatis
        if ($nilai_akhir >= 90) { $predikat = 'A'; }
        elseif ($nilai_akhir >= 80) { $predikat = 'B'; }
        elseif ($nilai_akhir >= 70) { $predikat = 'C'; }
        else { $predikat = 'D'; }

        // 6. Simpan atau Update ke Database
        Nilai::updateOrCreate(
            [
                'siswa_id'        => $siswa_id,
                'mapel_id'        => $request->mapel_id,
                'semester'        => $tahunAktif->semester,
                'tahun_pelajaran' => $tahunAktif->tahun_akademik,
            ],
            [
                'uh_1'              => $uh1,
                'uh_2'              => $uh2,
                'uh_3'              => $uh3,
                'pts'               => $pts,
                'pas'               => $pas,
                'nilai_pengetahuan' => $nilai_pengetahuan,
                'nilai_keterampilan'=> $keterampilan,
                'nilai_akhir'       => $nilai_akhir,
                'predikat'          => $predikat,
            ]
        );
    }

        return redirect()->route('dashboard.guru')->with('success', 'Nilai berhasil dihitung otomatis dan disimpan!');
    }
}
