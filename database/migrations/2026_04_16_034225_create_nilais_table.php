<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();

            // Kabel penghubung ke Siswa dan Mapel
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('mapel_id')->constrained('mapels')->onDelete('cascade');

            // Kolom nilai sesuai format Rapor SMK
            $table->integer('nilai_pengetahuan')->default(0);
            $table->integer('nilai_keterampilan')->default(0);
            $table->integer('nilai_akhir')->default(0);
            $table->string('predikat', 5)->nullable();

            // Penanda waktu
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->string('tahun_pelajaran'); // Contoh isian: '2022/2023'

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
