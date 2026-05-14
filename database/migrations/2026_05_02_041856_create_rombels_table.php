<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('rombels', function (Blueprint $table) {
        $table->id();
        // Relasi ke tabel tahun_akademiks
        $table->foreignId('tahun_akademik_id')->constrained('tahun_akademiks')->onDelete('cascade');
        // Relasi ke tabel kelas
        $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
        $table->timestamps();

        // Mencegah 1 kelas didaftarkan 2 kali di tahun akademik yang sama
        $table->unique(['tahun_akademik_id', 'kelas_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rombels');
    }
};
