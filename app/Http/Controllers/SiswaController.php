<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAkademik;
use App\Models\Rombel;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $tahun_akademik = TahunAkademik::all();
        $rombels = Rombel::with(['kelas', 'tahunAkademik'])->get();

        $query = Siswa::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%$search%")
                  ->orWhere('nisn', 'LIKE', "%$search%")
                  ->orWhere('nis', 'LIKE', "%$search%");
            });
        }

        if ($request->has('rombel_id') && $request->rombel_id != '') {
            $query->whereHas('rombels', function($q) use ($request) {
                $q->where('rombels.id', $request->rombel_id);
            });
        }

        $siswas = $query->latest()->paginate(25)->appends($request->all());

        return view('admin.siswa.index', compact('siswas', 'tahun_akademik', 'rombels'));
    }

    public function show(string $id)
    {
        $siswa = Siswa::with(['rombels.kelas', 'rombels.tahunAkademik'])->findOrFail($id);
        return view('admin.siswa.show', compact('siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nisn'          => 'required|max:10|unique:siswas,nisn',
            'nis'           => 'required|unique:siswas,nis',
            'nama'          => 'required',
            'jenis_kelamin' => 'required',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make('1234'); // Password default

        $siswa = Siswa::create($data);

        if ($request->rombel_id) {
            $siswa->rombels()->attach($request->rombel_id);
        }

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambah! Password default: 1234');
    }

    // ==========================================================
    // FUNGSI UPDATE DATA PROFIL
    // ==========================================================
    public function update(Request $request, string $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nisn'          => 'required|max:10|unique:siswas,nisn,' . $siswa->id,
            'nama'          => 'required',
            'jenis_kelamin' => 'required',
            // kelas_id SUDAH DIHAPUS DARI SINI
        ]);

        $siswa->update($request->all());

        // Menggunakan redirect()->back() agar jika diedit dari halaman detail, kembalinya ke detail lagi
        return redirect()->back()->with('success', 'Data profil siswa berhasil diubah!');
    }

    // ==========================================================
    // FUNGSI UPDATE STATUS SAJA
    // ==========================================================
    public function updateStatus(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status siswa berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        // Kalau dihapus, lemparnya kembali ke halaman tabel depan
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus permanen!');
    }
}
