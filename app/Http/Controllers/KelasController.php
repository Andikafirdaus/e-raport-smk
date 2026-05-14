<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;   // Manggil kunci gudang Kelas
use App\Models\Jurusan; // Manggil kunci gudang Jurusan
use App\Models\Guru;    // Manggil kunci gudang Guru (Buat Wali Kelas)

class KelasController extends Controller
{
    public function index()
    {
        // 1. Ambil data kelas, sekalian bawa data relasi 'jurusan' DAN 'waliKelas'
        $data_kelas = Kelas::with(['jurusan', 'waliKelas'])->get();

        // 2. Ambil data buat ditaruh di pilihan (dropdown)
        $data_jurusan = Jurusan::all();
        $data_guru = Guru::all(); // Tambahan buat dropdown Wali Kelas

        // 3. Lempar KETIGA data ini ke etalase kelas
        return view('admin.kelas.index', compact('data_kelas', 'data_jurusan', 'data_guru'));
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'jurusan_id' => 'required',
            'nama_kelas' => 'required',
            'guru_id'    => 'nullable' // Boleh kosong kalau belum ada walinya
        ]);

        // 2. Simpen ke database
        Kelas::create([
            'jurusan_id' => $request->jurusan_id,
            'nama_kelas' => $request->nama_kelas,
            'guru_id'    => $request->guru_id // Masukin data wali kelas
        ]);

        return redirect('/dashboard-admin/kelas');
    }

    public function update(Request $request, $id)
    {
        // 1. Validasi
        $request->validate([
            'jurusan_id' => 'required',
            'nama_kelas' => 'required',
            'guru_id'    => 'nullable'
        ]);

        // 2. Cari kelasnya
        $kelas = Kelas::findOrFail($id);

        // 3. Update data
        $kelas->update([
            'jurusan_id' => $request->jurusan_id,
            'nama_kelas' => $request->nama_kelas,
            'guru_id'    => $request->guru_id // Update data wali kelas
        ]);

        return redirect('/dashboard-admin/kelas');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect('/dashboard-admin/kelas');
    }
}
