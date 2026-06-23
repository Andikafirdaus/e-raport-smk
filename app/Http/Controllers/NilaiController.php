<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalMengajar;
use App\Models\Nilai;
use App\Models\TahunAkademik;
use App\Models\Pengaturan;

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

    // Fungsi buat nampilin halaman input
    public function input(string $jadwal_id)
    {
        $jadwal = JadwalMengajar::with(['mapel', 'rombel.kelas'])->findOrFail($jadwal_id);
        $siswas = $jadwal->rombel->siswas()->orderBy('nama', 'asc')->get();

        // Ambil nilai yang sudah ada (untuk pre-fill form)
        $tahunAktif = TahunAkademik::where('status', 'Aktif')->first();
        $nilaisExisting = collect();
        if ($tahunAktif) {
            $nilaisExisting = Nilai::where('mapel_id', $jadwal->mapel_id)
                ->where('semester', $tahunAktif->semester)
                ->where('tahun_pelajaran', $tahunAktif->tahun_akademik)
                ->whereIn('siswa_id', $siswas->pluck('id'))
                ->get()
                ->keyBy('siswa_id');
        }

        // Ambil bobot dari pengaturan untuk ditampilkan di header form
        $bobotUh  = (int) Pengaturan::getValue('bobot_uh', 40);
        $bobotPts = (int) Pengaturan::getValue('bobot_pts', 30);
        $bobotPas = (int) Pengaturan::getValue('bobot_pas', 30);

        return view('guru.input_nilai', compact(
            'jadwal', 'siswas', 'nilaisExisting', 'bobotUh', 'bobotPts', 'bobotPas'
        ));
    }

    // Fungsi buat simpan & hitung otomatis — MESIN PENILAIAN DINAMIS
    public function store(Request $request)
    {
        // 1. Ambil tahun akademik yang aktif
        $tahunAktif = TahunAkademik::where('status', 'Aktif')->first();

        if (!$tahunAktif) {
            return redirect()->back()->with('error', 'Tahun Akademik aktif tidak ditemukan!');
        }

        // 2. Ambil bobot dari tabel pengaturans
        $bobotUh  = (int) Pengaturan::getValue('bobot_uh', 40);
        $bobotPts = (int) Pengaturan::getValue('bobot_pts', 30);
        $bobotPas = (int) Pengaturan::getValue('bobot_pas', 30);

        // 3. Ambil KKM dari mapel yang diajarkan
        $jadwal = JadwalMengajar::with('mapel')->findOrFail($request->jadwal_id);
        $kkm    = $jadwal->mapel->kkm ?? 75;

        // 4. Looping data nilai dari form
        foreach ($request->nilai as $siswa_id => $data) {

            // ============================
            // HITUNG RATA-RATA UH DINAMIS
            // Hanya hitung UH yang terisi (not null & not empty string)
            // ============================
            $uhFields  = ['uh_1', 'uh_2', 'uh_3', 'uh_4', 'uh_5'];
            $uhValues  = [];

            foreach ($uhFields as $field) {
                $val = $data[$field] ?? null;
                // Anggap terisi jika nilainya adalah string angka (termasuk "0")
                if ($val !== null && $val !== '') {
                    $uhValues[] = (float) $val;
                }
            }

            // Jika tidak ada UH yang terisi sama sekali, rata-rata = 0
            $rataUh = count($uhValues) > 0
                ? array_sum($uhValues) / count($uhValues)
                : 0;

            $pts          = isset($data['pts']) && $data['pts'] !== '' ? (float) $data['pts'] : 0;
            $pas          = isset($data['pas']) && $data['pas'] !== '' ? (float) $data['pas'] : 0;
            $keterampilan = isset($data['keterampilan']) && $data['keterampilan'] !== '' ? (float) $data['keterampilan'] : 0;
            $remedial     = isset($data['remedial']) && $data['remedial'] !== '' ? (float) $data['remedial'] : null;

            // ============================
            // RUMUS NILAI PENGETAHUAN DINAMIS
            // ============================
            $nilai_pengetahuan = ($rataUh * $bobotUh / 100)
                               + ($pts    * $bobotPts / 100)
                               + ($pas    * $bobotPas / 100);

            // ============================
            // LOGIKA REMEDIAL KETAT
            // Jika nilai_pengetahuan < KKM:
            //   Cek apakah remedial diinput DAN nilainya >= KKM
            //   Jika ya → nilai_pengetahuan MENTOK di nilai KKM
            // ============================
            if ($nilai_pengetahuan < $kkm && $remedial !== null && $remedial >= $kkm) {
                $nilai_pengetahuan = $kkm;
            }

            // ============================
            // HITUNG NILAI AKHIR RAPOR
            // ============================
            $nilai_akhir = ($nilai_pengetahuan + $keterampilan) / 2;

            // ============================
            // TENTUKAN PREDIKAT (8 Tingkat)
            // ============================
            if ($nilai_akhir > 95)                              { $predikat = 'A+'; }
            elseif ($nilai_akhir > 90 && $nilai_akhir <= 95)    { $predikat = 'A';  }
            elseif ($nilai_akhir > 85 && $nilai_akhir <= 90)    { $predikat = 'A-'; }
            elseif ($nilai_akhir > 80 && $nilai_akhir <= 85)    { $predikat = 'B+'; }
            elseif ($nilai_akhir > 75 && $nilai_akhir <= 80)    { $predikat = 'B';  }
            elseif ($nilai_akhir > 70 && $nilai_akhir <= 75)    { $predikat = 'B-'; }
            elseif ($nilai_akhir >= 65 && $nilai_akhir <= 70)   { $predikat = 'C';  }
            else                                                 { $predikat = 'D';  }

            // ============================
            // SIMPAN / UPDATE KE DATABASE
            // ============================
            Nilai::updateOrCreate(
                [
                    'siswa_id'        => $siswa_id,
                    'mapel_id'        => $request->mapel_id,
                    'semester'        => $tahunAktif->semester,
                    'tahun_pelajaran' => $tahunAktif->tahun_akademik,
                ],
                [
                    'uh_1'               => $data['uh_1'] !== '' ? $data['uh_1'] : null,
                    'uh_2'               => $data['uh_2'] !== '' ? $data['uh_2'] : null,
                    'uh_3'               => $data['uh_3'] !== '' ? $data['uh_3'] : null,
                    'uh_4'               => ($data['uh_4'] ?? '') !== '' ? $data['uh_4'] : null,
                    'uh_5'               => ($data['uh_5'] ?? '') !== '' ? $data['uh_5'] : null,
                    'pts'                => $pts ?: null,
                    'pas'                => $pas ?: null,
                    'remedial'           => $remedial,
                    'nilai_pengetahuan'  => round($nilai_pengetahuan, 2),
                    'nilai_keterampilan' => $keterampilan,
                    'nilai_akhir'        => round($nilai_akhir, 2),
                    'predikat'           => $predikat,
                ]
            );
        }

        return redirect()->route('dashboard.guru')
            ->with('success', 'Nilai berhasil dihitung otomatis dan disimpan!');
    }
}
