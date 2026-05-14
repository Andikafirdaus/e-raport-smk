<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi ke master Tahun Akademik
    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }

    // Relasi ke master Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    // Relasi Many-to-Many ke Siswa
    public function siswas()
    {
        return $this->belongsToMany(Siswa::class, 'rombel_siswa', 'rombel_id', 'siswa_id')->withTimestamps();
    }
    // Relasi ke Guru sebagai Wali Kelas
    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
}
