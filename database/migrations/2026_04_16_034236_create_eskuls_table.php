<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eskuls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');

            $table->string('nama_kegiatan'); // Contoh: Pramuka, OSIS
            $table->string('predikat', 5)->nullable(); // Contoh: B, A
            $table->string('keterangan')->nullable();

            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->string('tahun_pelajaran');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eskuls');
    }
};
