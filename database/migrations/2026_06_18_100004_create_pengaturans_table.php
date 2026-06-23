<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Membuat tabel pengaturans sebagai key-value store untuk konfigurasi aplikasi.
     * Sekaligus mengisi data default bobot penilaian.
     */
    public function up(): void
    {
        Schema::create('pengaturans', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('value');
            $table->string('keterangan')->nullable(); // Deskripsi pengaturan
            $table->timestamps();
        });

        // Insert nilai default bobot penilaian
        DB::table('pengaturans')->insert([
            [
                'key'         => 'bobot_uh',
                'value'       => '40',
                'keterangan'  => 'Persentase bobot rata-rata Ulangan Harian (UH)',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'key'         => 'bobot_pts',
                'value'       => '30',
                'keterangan'  => 'Persentase bobot Penilaian Tengah Semester (PTS)',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'key'         => 'bobot_pas',
                'value'       => '30',
                'keterangan'  => 'Persentase bobot Penilaian Akhir Semester (PAS)',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturans');
    }
};
