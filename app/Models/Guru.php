<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// 1. Panggil class Authenticatable (Biar bisa login)
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// 2. Ganti tulisan 'Model' jadi 'Authenticatable'
class Guru extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = ['id'];

public function kelas()
    {
        return $this->hasMany(Kelas::class, 'guru_id');
    }


    // Relasi: 1 Guru memiliki BANYAK Jadwal Mengajar
    public function jadwalMengajars()
    {
        return $this->hasMany(JadwalMengajar::class, 'guru_id');
    }
}
