<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // 1. Relasi balik ke Jurusan (Ini yang tadi hilang)
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    // 2. Relasi ke Guru (sebagai Wali Kelas)
    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
}
