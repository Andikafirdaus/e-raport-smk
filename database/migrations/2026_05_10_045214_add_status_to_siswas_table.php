<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menambahkan kolom foto dan status.
     */
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            // Cek dan tambah kolom foto jika belum ada
            if (!Schema::hasColumn('siswas', 'foto')) {
                $table->string('foto')->nullable()->after('alamat');
            }

            // Cek dan tambah kolom status jika belum ada
            if (!Schema::hasColumn('siswas', 'status')) {
                $table->string('status')->default('Aktif')->after('foto');
            }
        });
    }

    /**
     * Batalkan migrasi (Rollback).
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            if (Schema::hasColumn('siswas', 'foto')) {
                $table->dropColumn('foto');
            }
            if (Schema::hasColumn('siswas', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
