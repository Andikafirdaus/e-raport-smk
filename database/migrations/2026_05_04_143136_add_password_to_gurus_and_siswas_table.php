<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Nambah password di tabel gurus
        Schema::table('gurus', function (Blueprint $table) {
            $table->string('password')->after('email')->default(bcrypt('password123'));
            // (defaultnya diset 'password123' biar guru yang udah ada datanya bisa langsung login)
        });

        // Nambah password di tabel siswas
        Schema::table('siswas', function (Blueprint $table) {
            $table->string('password')->after('nisn')->default(bcrypt('siswa123'));
            // (defaultnya diset 'siswa123')
        });
    }

    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->dropColumn('password');
        });
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn('password');
        });
    }
};
