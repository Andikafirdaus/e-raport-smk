<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Tambahan untuk enkripsi password

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_guru', 'LIKE', "%{$search}%")
                  ->orWhere('nip', 'LIKE', "%{$search}%");
            });
        }

        $gurus = $query->latest()->paginate(15)->appends($request->only('search'));

        return view('admin.guru.index', compact('gurus'));
    }

    // FUNGSI TAMPILKAN DETAIL
    public function show(string $id)
    {
        $guru = Guru::findOrFail($id);
        return view('admin.guru.show', compact('guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip'           => 'nullable|unique:gurus,nip',
            'nama_guru'     => 'required',
            'jenis_kelamin' => 'required',
            'email'         => 'required|email|unique:gurus,email',
        ]);

        $data = $request->except('_token');
        // SET PASSWORD DEFAULT "1234" UNTUK GURU BARU
        $data['password'] = Hash::make('1234');

        Guru::create($data);

        return redirect()->route('guru.index')->with('success', 'Data Guru Berhasil Ditambah! Password Default: 1234');
    }

    public function update(Request $request, string $id)
    {
        $guru = Guru::findOrFail($id);

        $request->validate([
            'nip'           => 'nullable|unique:gurus,nip,' . $guru->id,
            'nama_guru'     => 'required',
            'jenis_kelamin' => 'required',
            'email'         => 'required|email|unique:gurus,email,' . $guru->id,
        ]);

        $guru->update($request->all());

        return redirect()->back()->with('success', 'Data Profil Guru Berhasil Diperbarui!');
    }

    // FUNGSI UPDATE STATUS SAJA
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $guru = Guru::findOrFail($id);
        $guru->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status guru berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Data Guru Berhasil Dihapus!');
    }
}
