@extends('layouts.siswa')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Nilai &amp; Raport</h1>
            <p class="mb-0 text-muted small">
                Tahun Pelajaran: <strong>{{ $rombel ? $rombel->tahunAkademik->tahun_akademik : '-' }}</strong>
                &nbsp;|&nbsp; Semester: <strong>{{ $rombel ? $rombel->tahunAkademik->semester : '-' }}</strong>
            </p>
        </div>
        <div>
            <a href="{{ route('siswa.cetak_raport') }}" target="_blank" class="btn btn-warning btn-sm font-weight-bold shadow-sm">
                <i class="fas fa-print mr-1"></i> Cetak Raport
            </a>
            <a href="{{ route('dashboard.siswa') }}" class="btn btn-secondary btn-sm shadow-sm ml-2">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Kartu Identitas Siswa -->
    <div class="card shadow mb-4 border-left-warning">
        <div class="card-body py-3">
            <div class="row">
                <div class="col-md-4">
                    <p class="mb-1 small text-muted">Nama Siswa</p>
                    <p class="font-weight-bold mb-0">{{ $siswa->nama }}</p>
                </div>
                <div class="col-md-2">
                    <p class="mb-1 small text-muted">NISN</p>
                    <p class="font-weight-bold mb-0">{{ $siswa->nisn }}</p>
                </div>
                <div class="col-md-2">
                    <p class="mb-1 small text-muted">Kelas</p>
                    <p class="font-weight-bold mb-0">{{ $rombel ? $rombel->kelas->nama_kelas : '-' }}</p>
                </div>
                <div class="col-md-4">
                    <p class="mb-1 small text-muted">Wali Kelas</p>
                    <p class="font-weight-bold mb-0">{{ $rombel && $rombel->waliKelas ? $rombel->waliKelas->nama_guru : '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Nilai -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-warning">
                <i class="fas fa-star mr-2"></i> Rekap Nilai Akademik
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th rowspan="2" class="align-middle" width="5%">No</th>
                            <th rowspan="2" class="align-middle text-left">Mata Pelajaran</th>
                            <th colspan="3" class="text-center">Ulangan Harian</th>
                            <th rowspan="2" class="align-middle">PTS</th>
                            <th rowspan="2" class="align-middle">PAS</th>
                            <th rowspan="2" class="align-middle">Pengetahuan</th>
                            <th rowspan="2" class="align-middle">Keterampilan</th>
                            <th rowspan="2" class="align-middle">Nilai Akhir</th>
                            <th rowspan="2" class="align-middle">Predikat</th>
                        </tr>
                        <tr class="text-center">
                            <th>UH 1</th>
                            <th>UH 2</th>
                            <th>UH 3</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nilais as $i => $n)
                        <tr class="text-center">
                            <td class="align-middle">{{ $i + 1 }}</td>
                            <td class="align-middle text-left font-weight-bold">{{ $n->nama_mapel }}</td>
                            <td class="align-middle">{{ $n->uh_1 ?? '-' }}</td>
                            <td class="align-middle">{{ $n->uh_2 ?? '-' }}</td>
                            <td class="align-middle">{{ $n->uh_3 ?? '-' }}</td>
                            <td class="align-middle">{{ $n->pts ?? '-' }}</td>
                            <td class="align-middle">{{ $n->pas ?? '-' }}</td>
                            <td class="align-middle">{{ $n->nilai_pengetahuan ?? '-' }}</td>
                            <td class="align-middle">{{ $n->nilai_keterampilan ?? '-' }}</td>
                            <td class="align-middle font-weight-bold">
                                @php $na = $n->nilai_akhir ?? 0; @endphp
                                <span class="badge {{ $na >= 80 ? 'badge-success' : ($na >= 70 ? 'badge-warning' : 'badge-danger') }}"
                                      style="font-size:13px;">
                                    {{ $na }}
                                </span>
                            </td>
                            <td class="align-middle">
                                <span class="badge {{ $n->predikat === 'A' ? 'badge-success' : ($n->predikat === 'B' ? 'badge-info' : ($n->predikat === 'C' ? 'badge-warning' : 'badge-danger')) }}"
                                      style="font-size:14px; font-weight:700;">
                                    {{ $n->predikat ?? '-' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                Belum ada data nilai untuk semester ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($nilais->count() > 0)
                    <tfoot>
                        <tr class="table-warning text-center">
                            <td colspan="9" class="text-right font-weight-bold">Rata-rata Nilai Akhir:</td>
                            <td colspan="2" class="font-weight-bold" style="font-size:1.1em;">
                                {{ number_format($rataRata, 1) }}
                            </td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <!-- Absensi & Catatan Wali Kelas -->
    @if($catatan)
    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="fas fa-calendar-times mr-2"></i> Rekap Kehadiran
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="h2 font-weight-bold text-info">{{ $catatan->sakit ?? 0 }}</div>
                            <small class="text-muted">Sakit</small>
                        </div>
                        <div class="col-4">
                            <div class="h2 font-weight-bold text-warning">{{ $catatan->izin ?? 0 }}</div>
                            <small class="text-muted">Izin</small>
                        </div>
                        <div class="col-4">
                            <div class="h2 font-weight-bold text-danger">{{ $catatan->alpa ?? 0 }}</div>
                            <small class="text-muted">Alpa</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($catatan->catatan)
        <div class="col-md-7 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-comment-dots mr-2"></i> Catatan Wali Kelas
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-gray-700 mb-0" style="line-height:1.8;">
                        {{ $catatan->catatan }}
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

</div>
@endsection
