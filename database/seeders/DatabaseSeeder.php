<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Jurusan;
use App\Models\Siswa;
use App\Models\Guru; // Wajib panggil model Guru!
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. DATA ADMIN (Eksklusif di tabel users)
        // ==========================================
        User::create([
            'name'     => 'Agung Admin Rapor',
            'email'    => 'admin@smk.com',
            'password' => Hash::make('rahasia123'), // Sandi eksklusif Admin
            // Laci 'role' dihapus karena kita pakai arsitektur tabel terpisah!
        ]);

        // ==========================================
        // 2. DATA GURU (Masuk ke tabel gurus)
        // ==========================================
        Guru::create([
            'nip'           => '198001012005011001',
            'nama_guru'     => 'Pak Budi Wali Kelas',
            'jenis_kelamin' => 'L', // <--- UBAH JADI 'L' AJA MANG!
            'email'         => 'guru@smk.com',
            'password'      => Hash::make('password123'),
        ]);

        // ==========================================
        // 3. DATA MASTER (Jurusan)
        // ==========================================
        $jurusanOtkp = Jurusan::create([
            'nama_jurusan' => 'Otomatisasi dan Tata Kelola Perkantoran',
            'singkatan'    => 'OTKP'
        ]);

        Jurusan::create([
            'nama_jurusan' => 'Teknik dan Bisnis Sepeda Motor',
            'singkatan'    => 'TBSM'
        ]);

        // ==========================================
        // 4. DATA SISWA (Masuk ke tabel siswas)
        // ==========================================
        // Password default untuk semua siswa adalah: 1234
        Siswa::create([
            'nisn'          => '1234567890',
            'nis'           => '20240001',
            'nama'          => 'Andi Pratama',
            'jenis_kelamin' => 'L',
            'email'         => 'andi@siswa.com',
            'password'      => Hash::make('1234'),
        ]);

        Siswa::create([
            'nisn'          => '0987654321',
            'nis'           => '20240002',
            'nama'          => 'Siti Nurhaliza',
            'jenis_kelamin' => 'P',
            'email'         => 'siti@siswa.com',
            'password'      => Hash::make('1234'),
        ]);

    }
}
