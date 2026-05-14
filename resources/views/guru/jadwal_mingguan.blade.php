@extends('layouts.guru')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Jadwal Mengajar Mingguan</h1>
            <p class="mb-0 text-muted small">Ringkasan jadwal mengajar Anda selama satu minggu penuh</p>
        </div>
        <a href="{{ route('dashboard.guru') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm mr-1"></i> Kembali ke Dashboard
        </a>
    </div>

    <!-- Tabel Jadwal Mingguan -->
    @php
        $urutan_hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $warna_hari = [
            'Senin'  => 'primary',
            'Selasa' => 'success',
            'Rabu'   => 'info',
            'Kamis'  => 'warning',
            'Jumat'  => 'danger',
            'Sabtu'  => 'secondary',
        ];
    @endphp

    @foreach($urutan_hari as $hari)
    <div class="card shadow mb-3">
        <div class="card-header py-2 bg-{{ $warna_hari[$hari] }}">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="fas fa-calendar-day mr-2"></i>{{ $hari }}
                @if(isset($jadwalPerHari[$hari]))
                    <span class="badge badge-light ml-2">{{ $jadwalPerHari[$hari]->count() }} sesi</span>
                @endif
            </h6>
        </div>
        <div class="card-body py-2">
            @if(isset($jadwalPerHari[$hari]) && $jadwalPerHari[$hari]->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm table-bordered mb-0">
                        <thead style="background-color: #f8f9fc;">
                            <tr>
                                <th width="22%">Jam</th>
                                <th>Mata Pelajaran</th>
                                <th width="30%">Kelas / Rombel</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jadwalPerHari[$hari]->sortBy('jam_mulai') as $j)
                            <tr>
                                <td class="align-middle font-weight-bold text-{{ $warna_hari[$hari] }}">
                                    <i class="far fa-clock mr-1"></i>
                                    {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                                </td>
                                <td class="align-middle font-weight-bold">
                                    {{ $j->mapel->nama_mapel }}
                                </td>
                                <td class="align-middle">
                                    <span class="badge badge-{{ $warna_hari[$hari] }}" style="font-size: 12px;">
                                        <i class="fas fa-users mr-1"></i>
                                        {{ $j->rombel->kelas->nama_kelas }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mb-0 py-2 text-center small">
                    <i class="fas fa-coffee mr-1"></i> Tidak ada jadwal mengajar pada hari {{ $hari }}.
                </p>
            @endif
        </div>
    </div>
    @endforeach

    <!-- Info Total -->
    <div class="card shadow border-left-success mb-4">
        <div class="card-body py-3">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Sesi Mengajar per Minggu</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{ $jadwalPerHari->flatten()->count() }} Sesi
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
