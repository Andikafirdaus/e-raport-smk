<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catatan_walis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rombel_id')->constrained('rombels')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->integer('sakit')->default(0);
            $table->integer('izin')->default(0);
            $table->integer('alpa')->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Mencegah duplikasi: 1 siswa hanya punya 1 catatan per rombel
            $table->unique(['rombel_id', 'siswa_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catatan_walis');
    }
};
