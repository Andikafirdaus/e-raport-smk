<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('siswas', function (Blueprint $table) {
        $table->id();

        // Relasi ke tabel kelas (pastikan nama tabel kelas lu bener 'kelas', sesuaikan kalau beda)


        $table->string('nisn', 10)->unique(); // NISN nasional
        $table->string('nis')->unique()->nullable(); // NIS lokal sekolah
        $table->string('nama');
        $table->enum('jenis_kelamin', ['L', 'P']);
        $table->string('tempat_lahir')->nullable();
        $table->date('tanggal_lahir')->nullable();
        $table->string('agama')->nullable();
        $table->text('alamat')->nullable();

        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
