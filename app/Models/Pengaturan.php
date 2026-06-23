<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use HasFactory;

    protected $table = 'pengaturans';

    protected $fillable = ['key', 'value', 'keterangan'];

    /**
     * Helper statis untuk mengambil nilai pengaturan berdasarkan key.
     * Mengembalikan nilai default jika key tidak ditemukan.
     *
     * Contoh penggunaan:
     *   $bobotUH = Pengaturan::getValue('bobot_uh', 40);
     */
    public static function getValue(string $key, $default = null)
    {
        $pengaturan = static::where('key', $key)->first();
        return $pengaturan ? $pengaturan->value : $default;
    }
}
