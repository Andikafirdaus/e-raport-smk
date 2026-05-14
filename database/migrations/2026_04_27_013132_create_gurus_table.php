<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gurus', function (Blueprint $table) {
        $table->id();
        $table->string('nip')->unique()->nullable(); // NIP Guru (boleh kosong kalau honorer)
        $table->string('nama_guru');
        $table->enum('jenis_kelamin', ['L', 'P']);
        $table->string('no_hp')->nullable();
        $table->string('email')->unique(); // Buat login nantinya
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
