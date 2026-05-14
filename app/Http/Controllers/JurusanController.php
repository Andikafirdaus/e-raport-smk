<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\Siswa;

class JurusanController extends Controller
{
    public function index()
    {
        $data_jurusan = Jurusan::all();
        return view('admin.jurusan.index', compact('data_jurusan'));
    }

    /**
     * Tampilkan semua siswa yang terdaftar di jurusan tertentu
     * (via relasi: siswa → rombel → kelas → jurusan)
     */
    public function showSiswa($id)
    {
        $jurusan = Jurusan::findOrFail($id);

        // Ambil siswa yang kelasnya ada di jurusan ini (via rombel → kelas)
        $siswas = Siswa::whereHas('rombels', function($q) use ($id) {
            $q->whereHas('kelas', function($q2) use ($id) {
                $q2->where('jurusan_id', $id);
            });
        })->with(['rombels.kelas'])->orderBy('nama')->get();

        return view('admin.jurusan.siswa', compact('jurusan', 'siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'singkatan'    => 'required',
            'nama_jurusan' => 'required'
        ]);

        Jurusan::create([
            'singkatan'    => $request->singkatan,
            'nama_jurusan' => $request->nama_jurusan
        ]);

        return redirect('/dashboard-admin/jurusan')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'singkatan'    => 'required',
            'nama_jurusan' => 'required'
        ]);

        $jurusan = Jurusan::findOrFail($id);
        $jurusan->update([
            'singkatan'    => $request->singkatan,
            'nama_jurusan' => $request->nama_jurusan
        ]);

        return redirect('/dashboard-admin/jurusan')->with('success', 'Data jurusan diperbarui.');
    }

    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();
        return redirect('/dashboard-admin/jurusan')->with('success', 'Jurusan dihapus.');
    }
}
