<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Badge"/>
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel Badge"/>
  <img src="https://img.shields.io/badge/Bootstrap_4-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap Badge"/>
  <img src="https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL Badge"/>
</p>

<h1 align="center">🎓 E-Raport SMK Arrasyadiyyah</h1>

<p align="center">
  Sistem Informasi Manajemen Nilai dan Raport Akademik Terpadu untuk Sekolah Menengah Kejuruan (SMK), dirancang dengan arsitektur multi-portal dan mesin kalkulasi nilai yang dinamis.
</p>

---

## 📖 Tentang Projek

**E-Raport SMK Arrasyadiyyah** adalah aplikasi berbasis web yang mendigitalisasi proses penilaian siswa yang sebelumnya dilakukan secara manual (melalui Excel) menjadi sistem terpusat yang efisien, akurat, dan transparan. Aplikasi ini tidak hanya menyimpan data, tetapi juga dilengkapi dengan **Dynamic Grading Engine** (Mesin Penilaian Dinamis) yang mampu menghitung otomatis nilai rapor berdasarkan persentase bobot yang diatur oleh admin sekolah, menangani ketidakhadiran ulangan, serta mengeksekusi aturan ketat remedial sesuai Standar Operasional Prosedur (SOP) pendidikan.

## ✨ Fitur Unggulan & Portal Akses

Sistem ini membagi hak akses pengguna menjadi 4 portal dengan fungsi spesifik:

### 🛡️ 1. Portal Admin Sekolah
* **Master Data Management:** Mengelola kelengkapan data Siswa (termasuk riwayat asal sekolah & data orang tua/wali), Guru, Mata Pelajaran, Kelas, dan Jurusan.
* **Pengaturan Bobot Dinamis:** Antarmuka khusus untuk mengatur persentase pembobotan nilai (Ulangan Harian, PTS, dan PAS) yang akan menjadi patokan rumus hitung seluruh sekolah.
* **Sistem Pencarian Canggih:** Dilengkapi fitur *search* dengan dukungan *pagination* yang mulus.

### 👨‍🏫 2. Portal Guru Mata Pelajaran
* **Input Nilai Mentah:** Form input nilai yang rapi (Ulangan Harian 1-5, PTS, PAS, Remedial, dan Praktik/Keterampilan).
* **Auto-Calculate Engine:** Sistem akan menghitung rata-rata secara pintar (hanya menghitung UH yang terisi). Jika nilai siswa di bawah KKM dan memiliki nilai remedial yang lolos, sistem otomatis mengunci nilai akhir menjadi sebatas KKM.
* **Predikat Huruf Otomatis:** Sistem langsung mengkonversi angka menjadi predikat (A+, A, B, C, dst) sesuai rentang nilai SMK.

### 📋 3. Portal Wali Kelas
* **Rekapitulasi Kelas:** Memantau akumulasi nilai akhir dari berbagai mata pelajaran secara tersinkronisasi.
* **Absensi & Catatan:** Mengelola kehadiran siswa (Sakit, Izin, Alpa) dan memberikan catatan motivasi akademik.
* **Approval Nilai:** Mengunci dan memastikan keabsahan data nilai sebelum didistribusikan ke siswa.

### 👨‍🎓 4. Portal Siswa
* **Dashboard Akademik:** Akses cepat untuk melihat Jadwal Pelajaran Mingguan.
* **Cetak Rapor:** Melihat rincian perolehan nilai, predikat, tingkat kehadiran, dan mengunduh/mencetak dokumen rapor secara mandiri.

## 🛠️ Teknologi yang Digunakan

* **Backend:** PHP 8.x, Framework Laravel 10/11
* **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 4
* **UI/UX Template:** SB Admin 2 (Disesuaikan dengan warna identitas *Navy Blue*)
* **Database:** MySQL
* **Tools Tambahan:** Artisan Console, Eloquent ORM, Blade Templating

## 🚀 Panduan Instalasi (Local Development)

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi di komputer lokal (*localhost*):

1. **Clone repository ini**
   ```bash
   git clone [https://github.com/Andikafirdaus/NAMA_REPOSITORY_ANDA.git](https://github.com/Andikafirdaus/NAMA_REPOSITORY_ANDA.git)
