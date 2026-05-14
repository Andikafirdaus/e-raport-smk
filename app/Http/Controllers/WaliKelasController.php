<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Rombel;
use App\Models\Siswa;
use App\Models\CatatanWali;


class WaliKelasController extends Controller
{
    public function index()
{
    // Pastikan pakai guard('guru') supaya tidak dianggap logout
    if (!Auth::guard('guru')->check()) {
        return redirect()->route('login.guru');
    }

    $guru_id = Auth::guard('guru')->user()->id;

    // Ambil data rombel yang wali kelasnya adalah guru ini
    $rombel = Rombel::with(['kelas', 'siswas'])->where('guru_id', $guru_id)->first();

    if (!$rombel) {
        return redirect()->route('dashboard.guru')->with('error', 'Anda bukan Wali Kelas.');
    }

    return view('guru.wali_kelas', compact('rombel'));
}

public function showSiswa($id)
    {
        $guru_id = Auth::guard('guru')->user()->id;

        // Cari rombel di mana guru ini adalah wali kelasnya
        $rombel = Rombel::with('kelas')->where('guru_id', $guru_id)->first();

        // Validasi keamanan: Pastikan dia Wali Kelas
        if (!$rombel) {
            return redirect()->route('dashboard.guru')->with('error', 'Akses ditolak!');
        }

        // Cari data siswa berdasarkan ID yang diklik
        $siswa = Siswa::findOrFail($id);

        // Ambil data catatan jika sebelumnya sudah pernah diinput
        $catatan = CatatanWali::where('rombel_id', $rombel->id)
                              ->where('siswa_id', $siswa->id)
                              ->first();

        // --- TAMBAHAN BARU: Ambil semua data nilai untuk siswa ini ---
        $nilais = DB::table('nilais')
            ->join('mapels', 'nilais.mapel_id', '=', 'mapels.id')
            ->select('nilais.*', 'mapels.nama_mapel') // Baris sakti untuk mencegah tabrakan ID
            ->where('siswa_id', $id)
            ->get();

        // Lempar semua datanya ($rombel, $siswa, $catatan, $nilais) ke halaman view
        return view('guru.rekap_siswa', compact('rombel', 'siswa', 'catatan', 'nilais'));
    }
public function simpanCatatan(Request $request, $siswa_id)
    {
        $guru_id = Auth::guard('guru')->user()->id;
        $rombel = Rombel::where('guru_id', $guru_id)->first();

        if (!$rombel) return redirect()->back()->with('error', 'Akses ditolak!');

        // 1. Simpan Absensi dan Catatan
        CatatanWali::updateOrCreate(
            ['rombel_id' => $rombel->id, 'siswa_id' => $siswa_id],
            [
                'sakit' => $request->sakit ?? 0,
                'izin' => $request->izin ?? 0,
                'alpa' => $request->alpa ?? 0,
                'catatan' => $request->catatan,
            ]
        );

        // 2. Simpan Nilai Mentah + AUTO KALKULASI Nilai Pengetahuan & Nilai Akhir
        if ($request->has('nilai')) {
            foreach ($request->nilai as $nilai_id => $data_nilai) {

                // Ambil angka yang diinput (jadikan angka 0 kalau kosong)
                $uh1 = $data_nilai['uh_1'] ?? 0;
                $uh2 = $data_nilai['uh_2'] ?? 0;
                $uh3 = $data_nilai['uh_3'] ?? 0;
                $pts = $data_nilai['pts']  ?? 0;
                $pas = $data_nilai['pas']  ?? 0;

                // RUMUS 1: Hitung Nilai Pengetahuan (Rata-rata dari 5 ujian)
                // Jika sekolahmu punya bobot berbeda (misal PTS dikali 2), rumusnya tinggal diganti di sini.
                $nilai_pengetahuan = ($uh1 + $uh2 + $uh3 + $pts + $pas) / 5;

                // Ambil Nilai Keterampilan mentah yang sudah ada di database
                $nilai_lama = DB::table('nilais')->where('id', $nilai_id)->first();
                $keterampilan = $nilai_lama->nilai_keterampilan ?? 0;

                // RUMUS 2: Hitung Nilai Akhir sesuai logikamu (Pengetahuan + Keterampilan dibagi 2)
                $nilai_akhir = ($nilai_pengetahuan + $keterampilan) / 2;

                // Simpan semuanya kembali ke database
                DB::table('nilais')
                ->where('id', $nilai_id)
                ->where('siswa_id', $siswa_id) // Tambahkan kunci pengaman ini agar tidak salah sasaran
                ->update([
                    'uh_1' => $uh1,
                    'uh_2' => $uh2,
                    'uh_3' => $uh3,
                    'pts'  => $pts,
                    'pas'  => $pas,
                    'sikap' => !empty($data_nilai['sikap']) ? $data_nilai['sikap'] : null,
                    'nilai_pengetahuan' => round($nilai_pengetahuan),
                    'nilai_akhir' => round($nilai_akhir),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Data tersimpan dan Nilai Akhir berhasil dihitung otomatis!');
    }

public function cetakRaport($id)
{
    $halaman = request()->query('halaman', 1);
    $siswa = Siswa::findOrFail($id);
    $guru_id = Auth::guard('guru')->user()->id;
    $rombel = Rombel::with(['kelas.jurusan', 'tahunAkademik', 'waliKelas'])->where('guru_id', $guru_id)->first();

    $catatan = CatatanWali::where('siswa_id', $id)->where('rombel_id', $rombel->id)->first();

    $nilais = DB::table('nilais')
                ->join('mapels', 'nilais.mapel_id', '=', 'mapels.id')
                ->where('siswa_id', $id)
                ->get();

    return view('guru.cetak_raport', compact('siswa', 'rombel', 'catatan', 'nilais', 'halaman'));
}

public function pilihCetak($id)
{
    $siswa = Siswa::findOrFail($id);
    $guru_id = Auth::guard('guru')->user()->id;
    $rombel = Rombel::with(['kelas', 'tahunAkademik'])->where('guru_id', $guru_id)->first();

    if (!$rombel) return redirect()->route('dashboard.guru')->with('error', 'Akses ditolak!');

    $nilais = DB::table('nilais')->where('siswa_id', $id)->get();

    return view('guru.pilih_cetak', compact('siswa', 'rombel', 'nilais'));
}

}
