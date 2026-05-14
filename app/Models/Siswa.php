<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// 1. Panggil class Authenticatable
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// 2. Ganti tulisan 'Model' jadi 'Authenticatable'
class Siswa extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'siswas';
    protected $guarded = ['id'];
    protected $hidden  = ['password', 'remember_token'];
    protected $casts   = ['password' => 'hashed'];


    public function rombels()
    {
        return $this->belongsToMany(Rombel::class, 'rombel_siswa', 'siswa_id', 'rombel_id')->withTimestamps();
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }
}
