@extends('layouts.guru')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Panel Wali Kelas</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-success text-white">
            <h6 class="m-0 font-weight-bold">
                Daftar Siswa Kelas: {{ $rombel->kelas->nama_kelas }} - {{ $rombel->nama_rombel }}
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-dark" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Jenis Kelamin</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rombel->siswas as $index => $siswa)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $siswa->nisn }}</td>
                            <td class="font-weight-bold">{{ $siswa->nama }}</td>
                            <td class="text-center">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td class="text-center">
                                <a href="{{ route('walikelas.siswa', $siswa->id) }}" class="btn btn-info btn-sm shadow-sm mb-1">
                                    <i class="fas fa-list"></i> Rekap & Absensi
                                </a>
                                <a href="{{ route('walikelas.pilih_cetak', $siswa->id) }}" class="btn btn-success btn-sm shadow-sm mb-1">
                                    <i class="fas fa-print"></i> Cetak Raport
                                </a>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
