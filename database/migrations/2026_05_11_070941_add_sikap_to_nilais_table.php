<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom sikap.
     */
    public function up(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            // Mengecek apakah kolom sikap belum ada, kalau belum baru dibuat
            if (!Schema::hasColumn('nilais', 'sikap')) {
                // Kita buat tipe datanya string (bisa disi 'A', 'B', 'C', dll),
                // dan diletakkan setelah kolom 'nilai_akhir' supaya rapi di database.
                $table->string('sikap', 5)->nullable()->after('nilai_akhir');
            }
        });
    }

    /**
     * Membatalkan penambahan kolom (Rollback).
     */
    public function down(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            if (Schema::hasColumn('nilais', 'sikap')) {
                $table->dropColumn('sikap');
            }
        });
    }
};
