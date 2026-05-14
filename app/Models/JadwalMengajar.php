<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalMengajar extends Model
{
    use HasFactory;

    // Pastikan Laravel mengenali nama tabelnya
    protected $table = 'jadwal_mengajars';

    // Daftarkan kolom yang diizinkan untuk diisi data
    protected $fillable = [
        'guru_id',
        'mapel_id',
        'rombel_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    // --- DEKLARASI RELASI ---

    // 1 Jadwal dimiliki oleh 1 Guru
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    // 1 Jadwal diperuntukkan untuk 1 Mapel
    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    // 1 Jadwal berlaku di 1 Rombel
    public function rombel()
    {
        return $this->belongsTo(Rombel::class);
    }
}
