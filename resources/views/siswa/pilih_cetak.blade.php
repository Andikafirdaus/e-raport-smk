@extends('layouts.siswa')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Cetak Raport</h1>
            <p class="mb-0 text-muted small">Pilih bagian raport yang ingin Anda cetak</p>
        </div>
        <a href="{{ route('siswa.nilai') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left mr-1"></i> Lihat Nilai
        </a>
    </div>

    <!-- Info Siswa -->
    <div class="card shadow mb-4 border-left-warning">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col-auto">
                    @if($siswa->foto)
                        <img src="{{ asset('storage/'.$siswa->foto) }}" class="rounded-circle" style="width:50px;height:50px;object-fit:cover;">
                    @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width:50px;height:50px;background:linear-gradient(135deg,#ef6c00,#e65100);color:#fff;font-weight:800;font-size:1.3rem;">
                            {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="col">
                    <h6 class="font-weight-bold mb-0">{{ $siswa->nama }}</h6>
                    <p class="text-muted small mb-0">
                        NISN: {{ $siswa->nisn }}
                        &nbsp;|&nbsp; Kelas: <strong>{{ $rombel ? $rombel->kelas->nama_kelas : '-' }}</strong>
                        &nbsp;|&nbsp; {{ $rombel ? ($rombel->tahunAkademik->tahun_akademik . ' — Semester ' . $rombel->tahunAkademik->semester) : '-' }}
                    </p>
                </div>
                <div class="col-auto">
                    @if($nilais->count() > 0)
                        <span class="badge badge-success px-3 py-2">
                            <i class="fas fa-check mr-1"></i> Nilai Tersedia
                        </span>
                    @else
                        <span class="badge badge-warning px-3 py-2">
                            <i class="fas fa-exclamation-triangle mr-1"></i> Nilai Belum Ada
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Pilihan Halaman Raport -->
    <div class="row">

        <!-- Halaman 1: Nilai Akademik -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow h-100 border-0" style="border-radius:16px;overflow:hidden;">
                <div class="card-header border-0 py-4 text-white text-center"
                     style="background:linear-gradient(135deg,#4e73df,#224abe);">
                    <h5 class="font-weight-bold mb-1">Halaman 1</h5>
                    <p class="mb-0 small opacity-75">Nilai &amp; Deskripsi Raport</p>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Halaman ini berisi:</p>
                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-primary mr-2"></i>
                            <strong>A.</strong> Rekap Nilai Akademik (Kelompok A, B, C, D)
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-primary mr-2"></i>
                            Nilai Pengetahuan, Keterampilan, Nilai Akhir &amp; Predikat
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-primary mr-2"></i>
                            Rata-rata &amp; Peringkat Kelas
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-primary mr-2"></i>
                            <strong>B.</strong> Catatan Akademik Wali Kelas
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-primary mr-2"></i>
                            Tanda Tangan Orang Tua &amp; Wali Kelas
                        </li>
                    </ul>
                </div>
                <div class="card-footer bg-white border-0 pb-4 text-center">
                    <a href="{{ route('siswa.cetak_raport', ['halaman' => 1]) }}"
                       target="_blank"
                       class="btn btn-primary font-weight-bold px-4">
                        <i class="fas fa-print mr-2"></i> Cetak Halaman Ini
                    </a>
                </div>
            </div>
        </div>

        <!-- Halaman 2: PKL, Ekskul, Absensi -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow h-100 border-0" style="border-radius:16px;overflow:hidden;">
                <div class="card-header border-0 py-4 text-white text-center"
                     style="background:linear-gradient(135deg,#1cc88a,#13855c);">
                    <h5 class="font-weight-bold mb-1">Halaman 2</h5>
                    <p class="mb-0 small opacity-75">PKL, Ekskul &amp; Kehadiran</p>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Halaman ini berisi:</p>
                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success mr-2"></i>
                            <strong>C.</strong> Praktik Kerja Lapangan (PKL)
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success mr-2"></i>
                            <strong>D.</strong> Kegiatan Ekstrakurikuler
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success mr-2"></i>
                            <strong>E.</strong> Rekap Ketidakhadiran (Sakit, Izin, Alpa)
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success mr-2"></i>
                            <strong>F.</strong> Status Kenaikan Kelas
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-success mr-2"></i>
                            Tanda Tangan Orang Tua, Wali Kelas &amp; Kepala Sekolah
                        </li>
                    </ul>
                </div>
                <div class="card-footer bg-white border-0 pb-4 text-center">
                    <a href="{{ route('siswa.cetak_raport', ['halaman' => 2]) }}"
                       target="_blank"
                       class="btn btn-success font-weight-bold px-4">
                        <i class="fas fa-print mr-2"></i> Cetak Halaman Ini
                    </a>
                </div>
            </div>
        </div>

        <!-- Halaman 3: Deskripsi Karakter -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow h-100 border-0" style="border-radius:16px;overflow:hidden;">
                <div class="card-header border-0 py-4 text-white text-center"
                     style="background:linear-gradient(135deg,#f6c23e,#d4a017);">
                    <h5 class="font-weight-bold mb-1">Halaman 3</h5>
                    <p class="mb-0 small opacity-75">Perkembangan Karakter</p>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Halaman ini berisi:</p>
                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-warning mr-2"></i>
                            <strong>G.</strong> Deskripsi Perkembangan Karakter
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-warning mr-2"></i>
                            Integritas, Religius, Nasionalis, Mandiri, Gotong Royong
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-warning mr-2"></i>
                            <strong>H.</strong> Catatan Perkembangan Karakter
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-warning mr-2"></i>
                            Tanda Tangan Orang Tua, Wali Kelas &amp; Kepala Sekolah
                        </li>
                    </ul>
                </div>
                <div class="card-footer bg-white border-0 pb-4 text-center">
                    <a href="{{ route('siswa.cetak_raport', ['halaman' => 3]) }}"
                       target="_blank"
                       class="btn btn-warning font-weight-bold px-4">
                        <i class="fas fa-print mr-2"></i> Cetak Halaman Ini
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- Cetak Semua Sekaligus -->
    <div class="card shadow border-0" style="border-radius:16px;">
        <div class="card-body d-flex align-items-center p-4">
            <div class="mr-4" style="font-size:2.5rem;">🖨️</div>
            <div class="flex-grow-1">
                <h5 class="font-weight-bold mb-1">Cetak Semua Halaman Sekaligus</h5>
                <p class="text-muted small mb-0">
                    Buka ketiga halaman raport sekaligus dalam tab baru untuk dicetak secara berurutan.
                </p>
            </div>
            <div class="ml-3">
                <button onclick="cetakSemua()" class="btn btn-dark font-weight-bold px-4">
                    <i class="fas fa-print mr-2"></i> Cetak Semua
                </button>
            </div>
        </div>
    </div>

</div>

<script>
function cetakSemua() {
    window.open('{{ route("siswa.cetak_raport", ["halaman" => 1]) }}', '_blank');
    setTimeout(() => window.open('{{ route("siswa.cetak_raport", ["halaman" => 2]) }}', '_blank'), 800);
    setTimeout(() => window.open('{{ route("siswa.cetak_raport", ["halaman" => 3]) }}', '_blank'), 1600);
}
</script>
@endsection
