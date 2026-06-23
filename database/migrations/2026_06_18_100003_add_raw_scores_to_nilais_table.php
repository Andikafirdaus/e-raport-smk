<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom nilai mentah baru: uh_4, uh_5, dan remedial.
     * Catatan: uh_1, uh_2, uh_3, pts, pas SUDAH ADA dari migrasi sebelumnya.
     */
    public function up(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            if (!Schema::hasColumn('nilais', 'uh_4')) {
                $table->integer('uh_4')->nullable()->after('uh_3');
            }
            if (!Schema::hasColumn('nilais', 'uh_5')) {
                $table->integer('uh_5')->nullable()->after('uh_4');
            }
            if (!Schema::hasColumn('nilais', 'remedial')) {
                // Remedial diletakkan setelah pas, sebelum nilai_pengetahuan
                $table->integer('remedial')->nullable()->after('pas');
            }
        });
    }

    public function down(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            foreach (['uh_4', 'uh_5', 'remedial'] as $col) {
                if (Schema::hasColumn('nilais', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
