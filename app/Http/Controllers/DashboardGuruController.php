<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalMengajar;
use Illuminate\Support\Facades\Auth;

class DashboardGuruController extends Controller
{
    public function index()
    {
        $guru_id = Auth::guard('guru')->user()->id;

        $jadwalMentah = JadwalMengajar::with(['mapel', 'rombel.kelas'])
                            ->where('guru_id', $guru_id)
                            ->get();

        // Group berdasarkan mapel_id untuk tabel ringkasan di dashboard
        $jadwalGrouped = $jadwalMentah->groupBy('mapel_id');

        return view('guru.dashboard', compact('jadwalGrouped'));
    }

    public function jadwalMingguan()
    {
        $guru_id = Auth::guard('guru')->user()->id;

        // Urutan hari yang benar
        $urutan_hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        // Ambil semua jadwal guru, urutkan per jam mulai
        $jadwalMentah = JadwalMengajar::with(['mapel', 'rombel.kelas'])
                            ->where('guru_id', $guru_id)
                            ->orderBy('jam_mulai')
                            ->get();

        // Group berdasarkan hari
        $jadwalPerHari = $jadwalMentah->groupBy('hari');

        return view('guru.jadwal_mingguan', compact('jadwalPerHari', 'urutan_hari'));
    }
}
