<?php

namespace App\Http\Controllers;

use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class TahunAkademikController extends Controller
{
    public function index()
    {
        // Ambil data tahun akademik, urutkan dari yang terbaru
        $tahuns = TahunAkademik::orderBy('id', 'desc')->get();
        return view('admin.tahun_akademik.index', compact('tahuns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_akademik' => 'required',
            'semester'       => 'required',
        ]);

        TahunAkademik::create([
            'tahun_akademik' => $request->tahun_akademik,
            'semester'       => $request->semester,
            'status'         => 'Tidak Aktif' // Default awal tidak aktif
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambah!');
    }

    public function aktifkan(string $id)
    {
        // 1. Ambil data tahun yang mau diaktifkan
        $tahunBaru = TahunAkademik::findOrFail($id);

        // 2. Set semua tahun jadi Tidak Aktif dulu
        TahunAkademik::query()->update(['status' => 'Tidak Aktif']);

        // 3. Set tahun yang dipilih jadi Aktif
        $tahunBaru->update(['status' => 'Aktif']);

        // Pesan sukses yang lebih informatif
        return redirect()->back()->with('success', "Tahun Akademik {$tahunBaru->tahun_akademik} ({$tahunBaru->semester}) sekarang menjadi Aktif!");
    }

    public function destroy(string $id)
    {
        $tahun = TahunAkademik::findOrFail($id);

        // PENGAMAN: Cek apakah tahun ini sudah dipakai di tabel Rombel?
        // Pastikan di Model TahunAkademik kamu sudah ada relasi: public function rombels() { return $this->hasMany(Rombel::class); }
        if ($tahun->rombels()->count() > 0) {
            return redirect()->back()->with('error', 'Gagal! Tahun ini tidak bisa dihapus karena sudah memiliki data Pembagian Kelas (Rombel).');
        }

        $tahun->delete();
        return redirect()->back()->with('success', 'Data Tahun Akademik berhasil dihapus.');
    }
}
