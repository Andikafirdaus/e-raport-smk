<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    // Kasih tau Laravel mana aja yang boleh diisi dari form
    protected $fillable = ['kode_mapel', 'nama_mapel', 'kelompok', 'kkm'];

    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }
}
