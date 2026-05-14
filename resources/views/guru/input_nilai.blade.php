@extends('layouts.guru')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Input Nilai: {{ $jadwal->mapel->nama_mapel }}</h1>
        <a href="{{ route('dashboard.guru') }}" class="btn btn-secondary btn-sm">
    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
    </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Kelas: {{ $jadwal->rombel->kelas->nama_kelas }} - {{ $jadwal->rombel->nama_rombel }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('nilai.store') }}" method="POST">
                @csrf
                <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
                <input type="hidden" name="mapel_id" value="{{ $jadwal->mapel_id }}">

                <div class="table-responsive">
                    <table class="table table-bordered text-dark" width="100%">
                        <thead class="thead-light text-center">
                            <tr>
                                <th rowspan="2" class="align-middle" width="5%">No</th>
                                <th rowspan="2" class="align-middle">Nama Siswa</th>
                                <th colspan="5">Nilai Pengetahuan (Angka Murni)</th>
                                <th rowspan="2" class="align-middle" width="12%">Nilai Keterampilan</th>
                            </tr>
                            <tr>
                                <th width="8%">UH 1</th>
                                <th width="8%">UH 2</th>
                                <th width="8%">UH 3</th>
                                <th width="8%">PTS</th>
                                <th width="8%">PAS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswas as $index => $siswa)
                            <tr>
                                <td class="text-center align-middle">{{ $index + 1 }}</td>
                                <td class="align-middle font-weight-bold">{{ $siswa->nama }}</td>

                                {{-- Input Nilai Pengetahuan --}}
                                <td><input type="number" name="nilai[{{ $siswa->id }}][uh_1]" class="form-control text-center" min="0" max="100" required></td>
                                <td><input type="number" name="nilai[{{ $siswa->id }}][uh_2]" class="form-control text-center" min="0" max="100" required></td>
                                <td><input type="number" name="nilai[{{ $siswa->id }}][uh_3]" class="form-control text-center" min="0" max="100" required></td>
                                <td><input type="number" name="nilai[{{ $siswa->id }}][pts]" class="form-control text-center" min="0" max="100" required></td>
                                <td><input type="number" name="nilai[{{ $siswa->id }}][pas]" class="form-control text-center" min="0" max="100" required></td>

                                {{-- Input Nilai Keterampilan --}}
                                <td><input type="number" name="nilai[{{ $siswa->id }}][keterampilan]" class="form-control text-center" min="0" max="100" required></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-save"></i> Simpan & Hitung Otomatis
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
