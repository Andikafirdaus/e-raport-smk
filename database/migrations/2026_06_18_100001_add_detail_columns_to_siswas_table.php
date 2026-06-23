<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom-kolom detail siswa (Pribadi, Riwayat, Asal Sekolah, Orang Tua & Wali).
     * Semua nullable agar tidak merusak data siswa yang sudah ada.
     */
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {

            // ===== IDENTITAS PRIBADI =====
            if (!Schema::hasColumn('siswas', 'anak_ke')) {
                $table->integer('anak_ke')->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('siswas', 'status_keluarga')) {
                $table->string('status_keluarga')->nullable()->after('anak_ke');
            }
            if (!Schema::hasColumn('siswas', 'telp_siswa')) {
                $table->string('telp_siswa')->nullable()->after('status_keluarga');
            }
            if (!Schema::hasColumn('siswas', 'email_siswa')) {
                $table->string('email_siswa')->nullable()->after('telp_siswa');
            }

            // ===== RIWAYAT PENERIMAAN =====
            if (!Schema::hasColumn('siswas', 'diterima_di_kelas')) {
                $table->string('diterima_di_kelas')->nullable()->after('email_siswa');
            }
            if (!Schema::hasColumn('siswas', 'diterima_pada_tanggal')) {
                $table->date('diterima_pada_tanggal')->nullable()->after('diterima_di_kelas');
            }
            if (!Schema::hasColumn('siswas', 'diterima_semester')) {
                $table->string('diterima_semester')->nullable()->after('diterima_pada_tanggal');
            }

            // ===== SEKOLAH ASAL =====
            if (!Schema::hasColumn('siswas', 'asal_sekolah_nama')) {
                $table->string('asal_sekolah_nama')->nullable()->after('diterima_semester');
            }
            if (!Schema::hasColumn('siswas', 'asal_sekolah_alamat')) {
                $table->text('asal_sekolah_alamat')->nullable()->after('asal_sekolah_nama');
            }
            if (!Schema::hasColumn('siswas', 'ijazah_tahun')) {
                $table->string('ijazah_tahun', 10)->nullable()->after('asal_sekolah_alamat');
            }
            if (!Schema::hasColumn('siswas', 'ijazah_nomor')) {
                $table->string('ijazah_nomor')->nullable()->after('ijazah_tahun');
            }
            if (!Schema::hasColumn('siswas', 'skhu_tahun')) {
                $table->string('skhu_tahun', 10)->nullable()->after('ijazah_nomor');
            }
            if (!Schema::hasColumn('siswas', 'skhu_nomor')) {
                $table->string('skhu_nomor')->nullable()->after('skhu_tahun');
            }

            // ===== DATA ORANG TUA =====
            if (!Schema::hasColumn('siswas', 'nama_ayah')) {
                $table->string('nama_ayah')->nullable()->after('skhu_nomor');
            }
            if (!Schema::hasColumn('siswas', 'nama_ibu')) {
                $table->string('nama_ibu')->nullable()->after('nama_ayah');
            }
            if (!Schema::hasColumn('siswas', 'alamat_orang_tua')) {
                $table->text('alamat_orang_tua')->nullable()->after('nama_ibu');
            }
            if (!Schema::hasColumn('siswas', 'telp_orang_tua')) {
                $table->string('telp_orang_tua')->nullable()->after('alamat_orang_tua');
            }
            if (!Schema::hasColumn('siswas', 'pekerjaan_ayah')) {
                $table->string('pekerjaan_ayah')->nullable()->after('telp_orang_tua');
            }
            if (!Schema::hasColumn('siswas', 'pekerjaan_ibu')) {
                $table->string('pekerjaan_ibu')->nullable()->after('pekerjaan_ayah');
            }

            // ===== DATA WALI =====
            if (!Schema::hasColumn('siswas', 'nama_wali')) {
                $table->string('nama_wali')->nullable()->after('pekerjaan_ibu');
            }
            if (!Schema::hasColumn('siswas', 'alamat_wali')) {
                $table->text('alamat_wali')->nullable()->after('nama_wali');
            }
            if (!Schema::hasColumn('siswas', 'telp_wali')) {
                $table->string('telp_wali')->nullable()->after('alamat_wali');
            }
            if (!Schema::hasColumn('siswas', 'pekerjaan_wali')) {
                $table->string('pekerjaan_wali')->nullable()->after('telp_wali');
            }
        });
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $columns = [
                'anak_ke', 'status_keluarga', 'telp_siswa', 'email_siswa',
                'diterima_di_kelas', 'diterima_pada_tanggal', 'diterima_semester',
                'asal_sekolah_nama', 'asal_sekolah_alamat',
                'ijazah_tahun', 'ijazah_nomor', 'skhu_tahun', 'skhu_nomor',
                'nama_ayah', 'nama_ibu', 'alamat_orang_tua', 'telp_orang_tua',
                'pekerjaan_ayah', 'pekerjaan_ibu',
                'nama_wali', 'alamat_wali', 'telp_wali', 'pekerjaan_wali',
            ];
            foreach ($columns as $col) {
                if (Schema::hasColumn('siswas', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
