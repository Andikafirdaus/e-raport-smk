<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom KKM (Kriteria Ketuntasan Minimal) ke tabel mapels.
     * Default 75 sesuai standar umum SMK.
     */
    public function up(): void
    {
        Schema::table('mapels', function (Blueprint $table) {
            if (!Schema::hasColumn('mapels', 'kkm')) {
                $table->integer('kkm')->default(75)->after('kelompok');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mapels', function (Blueprint $table) {
            if (Schema::hasColumn('mapels', 'kkm')) {
                $table->dropColumn('kkm');
            }
        });
    }
};
