<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            // Cek dulu, kalau belum ada kolom uh_1, baru kita bikin laci-lacinya
            if (!Schema::hasColumn('nilais', 'uh_1')) {
                $table->integer('uh_1')->nullable()->after('mapel_id');
                $table->integer('uh_2')->nullable()->after('uh_1');
                $table->integer('uh_3')->nullable()->after('uh_2');
                $table->integer('pts')->nullable()->after('uh_3');
                $table->integer('pas')->nullable()->after('pts');
            }

            // Karena kolom nilai_keterampilan terdeteksi SUDAH ADA,
            // kita tidak perlu menuliskannya lagi di sini agar tidak error.
        });
    }

    public function down(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            if (Schema::hasColumn('nilais', 'uh_1')) {
                $table->dropColumn(['uh_1', 'uh_2', 'uh_3', 'pts', 'pas']);
            }
        });
    }
};
