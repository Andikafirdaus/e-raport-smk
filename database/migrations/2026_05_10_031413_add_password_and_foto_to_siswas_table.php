<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            // Password ternyata sudah ada, jadi kita cuma perlu nambah foto
            $table->string('foto')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            // Menghapus kolom foto jika di-rollback
            $table->dropColumn('foto');
        });
    }
};
