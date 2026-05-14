<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Jurusan extends Model
{
    protected $guarded = [];

    // Relasi: 1 Jurusan punya Banyak Kelas
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'jurusan_id');
    }
}
