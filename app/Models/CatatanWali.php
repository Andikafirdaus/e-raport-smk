<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanWali extends Model
{
    use HasFactory;

    // Beri tahu nama tabelnya
    protected $table = 'catatan_walis';

    // Izinkan semua kolom diisi (mass assignment)
    protected $guarded = ['id'];
}
