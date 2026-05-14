@extends('layouts.siswa')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Halo, {{ $siswa->nama }}! 👋</h1>
            <p class="mb-0 text-muted small">Selamat datang di Portal Siswa E-Rapor SMK</p>
        </div>
    </div>

    <!-- Kartu Info Siswa -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Kelas</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                {{ $rombel ? $rombel->kelas->nama_kelas : '-' }}
                            </div>
                        </div>
                        <div class="col-auto"><i class="fas fa-school fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jurusan</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                {{ $rombel && $rombel->kelas->jurusan ? $rombel->kelas->jurusan->singkatan : '-' }}
                            </div>
                        </div>
                        <div class="col-auto"><i class="fas fa-building fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Wali Kelas</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800" style="font-size:0.8rem;">
                                {{ $rombel && $rombel->waliKelas ? $rombel->waliKelas->nama_guru : '-' }}
                            </div>
                        </div>
                        <div class="col-auto"><i class="fas fa-user-tie fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">NISN</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">{{ $siswa->nisn }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-id-card fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jadwal Pelajaran Mingguan -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-warning">
                <i class="fas fa-calendar-week mr-2"></i> Jadwal Pelajaran Mingguan
                @if($rombel)
                    <span class="badge badge-warning ml-2">{{ $rombel->kelas->nama_kelas }}</span>
                @endif
            </h6>
        </div>
        <div class="card-body">
            @if(!$rombel)
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-exclamation-circle fa-2x mb-2 d-block text-warning"></i>
                    Kamu belum terdaftar di rombel aktif. Hubungi admin sekolah.
                </div>
            @else
                @php
                    $urutan_hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    $warna = ['Senin'=>'primary','Selasa'=>'success','Rabu'=>'info','Kamis'=>'warning','Jumat'=>'danger','Sabtu'=>'secondary'];
                @endphp

                @foreach($urutan_hari as $hari)
                @if(isset($jadwalPerHari[$hari]) && $jadwalPerHari[$hari]->count() > 0)
                <div class="mb-3">
                    <h6 class="font-weight-bold text-{{ $warna[$hari] }} mb-2">
                        <i class="fas fa-circle mr-1" style="font-size:8px;"></i> {{ $hari }}
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0">
                            <thead style="background:#f8f9fc;">
                                <tr>
                                    <th width="25%">Jam</th>
                                    <th>Mata Pelajaran</th>
                                    <th width="30%">Guru</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jadwalPerHari[$hari]->sortBy('jam_mulai') as $j)
                                <tr>
                                    <td class="font-weight-bold text-{{ $warna[$hari] }}">
                                        {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                                    </td>
                                    <td class="font-weight-bold">{{ $j->mapel->nama_mapel }}</td>
                                    <td class="text-muted">{{ $j->guru->nama_guru }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                @endforeach

                @if($jadwalPerHari->flatten()->count() === 0)
                    <p class="text-center text-muted py-3">
                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                        Belum ada jadwal pelajaran untuk kelasmu.
                    </p>
                @endif
            @endif
        </div>
    </div>

    <!-- Quick Action -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow border-left-warning h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <div style="width:50px;height:50px;border-radius:50%;background:linear-gradient(135deg,#f6c23e,#f4a623);display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-star text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="font-weight-bold mb-1">Nilai &amp; Raport</h6>
                        <p class="text-muted small mb-2">Lihat detail nilai semua mata pelajaran</p>
                        <a href="{{ route('siswa.nilai') }}" class="btn btn-warning btn-sm font-weight-bold">
                            <i class="fas fa-eye mr-1"></i> Lihat Nilai
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow border-left-primary h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <div style="width:50px;height:50px;border-radius:50%;background:linear-gradient(135deg,#4e73df,#224abe);display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-print text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="font-weight-bold mb-1">Cetak Raport</h6>
                        <p class="text-muted small mb-2">Download dan cetak raport kamu</p>
                        <a href="{{ route('siswa.cetak_raport') }}" target="_blank" class="btn btn-primary btn-sm font-weight-bold">
                            <i class="fas fa-print mr-1"></i> Cetak Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
