<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Siswa;
use App\Models\JadwalMengajar;
use App\Models\Nilai;
use App\Models\Rombel;

class DashboardSiswaController extends Controller
{
    private function getRombelAktif($siswa_id)
    {
        return Rombel::with(['kelas.jurusan', 'tahunAkademik', 'waliKelas'])
            ->whereHas('siswas', function($q) use ($siswa_id) {
                $q->where('siswas.id', $siswa_id);
            })
            ->whereHas('tahunAkademik', function($q) {
                $q->where('status', 'Aktif');
            })
            ->first();
    }

    private function getNilais($siswa_id)
    {
        return DB::table('nilais')
            ->join('mapels', 'nilais.mapel_id', '=', 'mapels.id')
            ->select('nilais.*', 'mapels.nama_mapel', 'mapels.kode_mapel')
            ->where('nilais.siswa_id', $siswa_id)
            ->get();
    }

    private function getCatatan($siswa_id, $rombel)
    {
        if (!$rombel) return null;
        return DB::table('catatan_walis')
            ->where('siswa_id', $siswa_id)
            ->where('rombel_id', $rombel->id)
            ->first();
    }

    // =============================
    // DASHBOARD
    // =============================
    public function index()
    {
        $siswa  = Auth::guard('siswa')->user();
        $rombel = $this->getRombelAktif($siswa->id);
        $urutan_hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $jadwalPerHari = collect();

        if ($rombel) {
            $jadwalMentah = JadwalMengajar::with(['mapel', 'guru', 'rombel.kelas'])
                ->where('rombel_id', $rombel->id)
                ->orderBy('jam_mulai')
                ->get();
            $jadwalPerHari = $jadwalMentah->groupBy('hari');
        }

        return view('siswa.dashboard', compact('siswa', 'rombel', 'jadwalPerHari', 'urutan_hari'));
    }

    // =============================
    // NILAI
    // =============================
    public function nilai()
    {
        $siswa    = Auth::guard('siswa')->user();
        $rombel   = $this->getRombelAktif($siswa->id);
        $nilais   = $this->getNilais($siswa->id);
        $catatan  = $this->getCatatan($siswa->id, $rombel);
        $rataRata = $nilais->avg('nilai_akhir');

        return view('siswa.nilai', compact('siswa', 'rombel', 'nilais', 'catatan', 'rataRata'));
    }

    // =============================
    // PILIH CETAK RAPORT
    // =============================
    public function pilihCetak()
    {
        $siswa   = Auth::guard('siswa')->user();
        $rombel  = $this->getRombelAktif($siswa->id);
        $nilais  = $this->getNilais($siswa->id);
        $catatan = $this->getCatatan($siswa->id, $rombel);

        return view('siswa.pilih_cetak', compact('siswa', 'rombel', 'nilais', 'catatan'));
    }

    // =============================
    // CETAK RAPORT (3 halaman terpisah)
    // =============================
    public function cetakRaport(Request $request)
    {
        $halaman = $request->get('halaman', 1);
        $siswa   = Auth::guard('siswa')->user();
        $rombel  = $this->getRombelAktif($siswa->id);
        $nilais  = $this->getNilais($siswa->id);
        $catatan = $this->getCatatan($siswa->id, $rombel);

        return view('siswa.cetak_raport', compact('siswa', 'rombel', 'nilais', 'catatan', 'halaman'));
    }

    // =============================
    // PROFIL SISWA
    // =============================
    public function profil()
    {
        $siswa = Auth::guard('siswa')->user();
        return view('siswa.profil', compact('siswa'));
    }

    public function updateProfil(Request $request)
    {
        $siswa = Auth::guard('siswa')->user();

        $request->validate([
            'nama'          => 'required|string|max:255',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = ['nama' => $request->nama];

        // Ganti password jika diisi
        if ($request->filled('password')) {
            $request->validate([
                'password'              => 'min:6',
                'password_confirmation' => 'required_with:password|same:password',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        // Upload foto profil
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $path = $request->file('foto')->store('foto-siswa', 'public');
            $data['foto'] = $path;
        }

        Siswa::where('id', $siswa->id)->update($data);

        return redirect()->route('siswa.profil')->with('success', 'Profil berhasil diperbarui!');
    }
}
