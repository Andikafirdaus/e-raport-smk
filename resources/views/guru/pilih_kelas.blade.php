@extends('layouts.guru')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pilih Kelas untuk Input Nilai</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Jadwal Mengajar Anda</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th class="text-center" width="5%">No</th>
            <th>Kelas / Rombel</th>
            <th>Mata Pelajaran</th>
            <th class="text-center" width="15%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($jadwals as $index => $jadwal)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $jadwal->rombel->kelas->nama_kelas ?? 'Kelas Tidak Ditemukan' }} - {{ $jadwal->rombel->nama_rombel ?? '' }}</td>
            <td>{{ $jadwal->mapel->nama_mapel ?? 'Mapel Tidak Ditemukan' }}</td>
            <td class="text-center">
                <a href="{{ route('guru.input_nilai', $jadwal->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i> Input Nilai
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center text-danger">Belum ada jadwal mengajar yang ditugaskan untuk Anda.</td>
        </tr>
        @endforelse
    </tbody>
</table>
        </div>
    </div>
</div>
@endsection
