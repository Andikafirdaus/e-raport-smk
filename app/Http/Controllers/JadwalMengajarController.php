<?php

namespace App\Http\Controllers;

use App\Models\JadwalMengajar;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Rombel;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class JadwalMengajarController extends Controller
{
    /**
     * Menampilkan halaman jadwal mengajar (Khusus Tahun Akademik Aktif)
     */
    public function index()
    {
        // 1. Cek tahun akademik yang sedang aktif
        $tahunAktif = TahunAkademik::where('status', 'Aktif')->first();

        // Siapkan variabel kosong jaga-jaga kalau belum ada tahun aktif
        $rombels = collect();
        $jadwals = collect();

        if ($tahunAktif) {
            // 2. Ambil daftar Rombel yang ada di tahun aktif saja
            $rombels = Rombel::with('kelas')->where('tahun_akademik_id', $tahunAktif->id)->get();

            // 3. Ambil data jadwal mengajar yang rombelnya ada di tahun aktif
            $jadwals = JadwalMengajar::with(['guru', 'mapel', 'rombel.kelas'])
                ->whereHas('rombel', function($query) use ($tahunAktif) {
                    $query->where('tahun_akademik_id', $tahunAktif->id);
                })->get();
        }

        // 4. Ambil semua data Guru dan Mapel untuk pilihan dropdown di Form
        $gurus = Guru::orderBy('nama_guru', 'asc')->get();
        $mapels = Mapel::orderBy('nama_mapel', 'asc')->get();

        return view('admin.jadwal.index', compact('jadwals', 'gurus', 'mapels', 'rombels', 'tahunAktif'));
    }

    /**
     * Menyimpan data jadwal mengajar baru
     */
public function store(Request $request)
{
    $request->validate([
        'guru_id' => 'required|exists:gurus,id',
        'mapel_id' => 'required|exists:mapels,id',
        'rombel_id' => 'required|array|min:1',
        'hari' => 'required', // <--- Tambahkan validasi
        'jam_mulai' => 'required',
        'jam_selesai' => 'required',
    ]);

    $pesanError = [];
    $berhasilDisimpan = 0;

    foreach ($request->rombel_id as $rombel_id) {
        // Update pengecekan bentrok: cek rombel, mapel, DAN hari
        $cekBentrok = JadwalMengajar::where('mapel_id', $request->mapel_id)
                                    ->where('rombel_id', $rombel_id)
                                    ->where('hari', $request->hari)
                                    ->first();

        if ($cekBentrok) {
            $namaKelas = Rombel::find($rombel_id)->kelas->nama_kelas;
            $pesanError[] = "Kelas " . $namaKelas;
        } else {
            JadwalMengajar::create([
                'guru_id' => $request->guru_id,
                'mapel_id' => $request->mapel_id,
                'rombel_id' => $rombel_id,
                'hari' => $request->hari, // <--- Simpan hari
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
            ]);
            $berhasilDisimpan++;
        }
    }
        // 3. Laporan Hasil Eksekusi ke Admin
        if (count($pesanError) > 0) {
            $pesan = implode(', ', $pesanError);
            if ($berhasilDisimpan > 0) {
                return redirect()->back()->with('error', "Sebagian jadwal disimpan. TAPI GAGAL di: " . $pesan . " (Sudah ada gurunya)");
            }
            return redirect()->back()->with('error', "Semua jadwal gagal disimpan karena bentrok di: " . $pesan);
        }

        return redirect()->back()->with('success', $berhasilDisimpan . ' Jadwal mengajar berhasil ditambahkan sekaligus!');
    }
    public function update(Request $request, string $id)
    {
        // 1. Validasi Input (Perhatikan rombel_id di sini bukan array)
        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'mapel_id' => 'required|exists:mapels,id',
            'rombel_id' => 'required|exists:rombels,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        // 2. Cek Bentrok (Pastikan mapel & hari belum ada di kelas tersebut, KECUALI jadwal ini sendiri)
        $cekBentrok = JadwalMengajar::where('mapel_id', $request->mapel_id)
                                    ->where('rombel_id', $request->rombel_id)
                                    ->where('hari', $request->hari)
                                    ->where('id', '!=', $id) // <--- Kunci utamanya di sini
                                    ->first();

        if ($cekBentrok) {
            $namaKelas = Rombel::find($request->rombel_id)->kelas->nama_kelas;
            return redirect()->back()->with('error', "Gagal update! Mapel ini sudah ada jadwalnya di hari " . $request->hari . " untuk kelas " . $namaKelas);
        }

        // 3. Update data ke database
        $jadwal = JadwalMengajar::findOrFail($id);
        $jadwal->update([
            'guru_id' => $request->guru_id,
            'mapel_id' => $request->mapel_id,
            'rombel_id' => $request->rombel_id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()->back()->with('success', 'Jadwal mengajar berhasil diperbarui!');
    }
    public function destroy(string $id)
    {
        $jadwal = JadwalMengajar::findOrFail($id);
        $jadwal->delete();

        return redirect()->back()->with('success', 'Jadwal mengajar berhasil dihapus!');
    }
}
