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
    Schema::create('rombel_siswa', function (Blueprint $table) {
        $table->id();
        // Relasi ke tabel rombels
        $table->foreignId('rombel_id')->constrained('rombels')->onDelete('cascade');
        // Relasi ke tabel siswas
        $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
        $table->timestamps();

        // Mencegah siswa yang sama dimasukkan 2 kali ke rombel yang sama
        $table->unique(['rombel_id', 'siswa_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rombel_siswa');
    }
};
