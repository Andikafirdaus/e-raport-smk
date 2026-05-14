@extends('layouts.guru')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Guru</h1>
        <a href="{{ route('guru.jadwal_mingguan') }}" class="btn btn-success btn-sm shadow-sm">
            <i class="fas fa-calendar-week fa-sm text-white-50 mr-1"></i> Lihat Jadwal Mingguan
        </a>
    </div>

    <!-- Kartu Selamat Datang -->
    <div class="card shadow mb-4" style="border-left: .25rem solid #1cc88a;">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Selamat Datang!</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        Halo, {{ Auth::guard('guru')->user()->nama_guru }}!
                    </div>
                    <p class="mt-2 mb-0 text-muted small">
                        Selamat datang di Panel Guru E-Rapor SMK. Berikut adalah ringkasan jadwal mengajar Anda.
                    </p>
                </div>
                <div class="col-auto">
                    <i class="fas fa-chalkboard-teacher fa-3x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Jadwal Mengajar -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-success">
                <i class="fas fa-calendar-alt mr-1"></i> Jadwal Mengajar Saya
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-dark" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th width="30%">Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th width="12%">Hari</th>
                            <th width="20%">Jam Mengajar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwalGrouped as $mapel_id => $jadwals)
                            @foreach($jadwals as $j)
                            <tr>
                                @if($loop->first)
                                    <td class="align-middle text-center" rowspan="{{ $jadwals->count() }}">
                                        {{ $loop->parent->iteration }}
                                    </td>
                                    <td class="align-middle font-weight-bold" rowspan="{{ $jadwals->count() }}">
                                        {{ $j->mapel->nama_mapel }}
                                    </td>
                                @endif
                                <td class="align-middle">
                                    <span class="badge badge-success" style="font-size: 13px;">
                                        <i class="fas fa-users mr-1"></i> {{ $j->rombel->kelas->nama_kelas }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <span class="badge badge-info" style="font-size: 13px;">
                                        <i class="fas fa-calendar-day mr-1"></i> {{ $j->hari }}
                                    </span>
                                </td>
                                <td class="align-middle text-center font-weight-bold">
                                    <i class="far fa-clock text-primary mr-1"></i>
                                    {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                                </td>
                            </tr>
                            @endforeach
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                Belum ada jadwal mengajar untuk Anda saat ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
