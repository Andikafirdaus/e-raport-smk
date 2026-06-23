@extends('layouts.guru')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Input Nilai: {{ $jadwal->mapel->nama_mapel }}</h1>
            <p class="mb-0 small text-muted">
                KKM: <strong>{{ $jadwal->mapel->kkm ?? 75 }}</strong> &nbsp;|&nbsp;
                Bobot: UH <strong>{{ $bobotUh }}%</strong> • PTS <strong>{{ $bobotPts }}%</strong> • PAS <strong>{{ $bobotPas }}%</strong>
            </p>
        </div>
        <a href="{{ route('dashboard.guru') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-users mr-2"></i>
                Kelas: {{ $jadwal->rombel->kelas->nama_kelas }} - {{ $jadwal->rombel->nama_rombel }}
            </h6>
        </div>
        <div class="card-body p-0">
            <form action="{{ route('nilai.store') }}" method="POST">
                @csrf
                <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
                <input type="hidden" name="mapel_id" value="{{ $jadwal->mapel_id }}">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-dark mb-0" width="100%">
                        <thead class="thead-dark text-center" style="font-size: 0.75rem;">
                            <tr>
                                <th rowspan="2" class="align-middle" width="3%">No</th>
                                <th rowspan="2" class="align-middle text-left" width="18%">Nama Siswa</th>
                                {{-- Ulangan Harian --}}
                                <th colspan="5" class="bg-info text-white">
                                    Ulangan Harian (UH) — Bobot {{ $bobotUh }}%
                                    <br><small class="font-weight-normal">(Kosongkan jika belum ada)</small>
                                </th>
                                {{-- PTS --}}
                                <th rowspan="2" class="align-middle bg-warning text-dark" width="7%">
                                    PTS<br><small class="font-weight-normal">{{ $bobotPts }}%</small>
                                </th>
                                {{-- PAS --}}
                                <th rowspan="2" class="align-middle bg-success text-white" width="7%">
                                    PAS<br><small class="font-weight-normal">{{ $bobotPas }}%</small>
                                </th>
                                {{-- Remedial --}}
                                <th rowspan="2" class="align-middle bg-danger text-white" width="7%">
                                    Remedial<br><small class="font-weight-normal">(jika &lt; KKM)</small>
                                </th>
                                {{-- Keterampilan --}}
                                <th rowspan="2" class="align-middle bg-secondary text-white" width="8%">
                                    Nilai<br>Keterampilan
                                </th>
                            </tr>
                            <tr>
                                <th class="bg-info text-white" width="7%">UH 1</th>
                                <th class="bg-info text-white" width="7%">UH 2</th>
                                <th class="bg-info text-white" width="7%">UH 3</th>
                                <th class="bg-info text-white" width="7%">UH 4</th>
                                <th class="bg-info text-white" width="7%">UH 5</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswas as $index => $siswa)
                            @php
                                $existing = $nilaisExisting[$siswa->id] ?? null;
                            @endphp
                            <tr>
                                <td class="text-center align-middle">{{ $index + 1 }}</td>
                                <td class="align-middle font-weight-bold">{{ $siswa->nama }}</td>

                                {{-- UH 1 --}}
                                <td class="p-1">
                                    <input type="number"
                                           name="nilai[{{ $siswa->id }}][uh_1]"
                                           class="form-control form-control-sm text-center"
                                           min="0" max="100"
                                           value="{{ $existing->uh_1 ?? '' }}"
                                           placeholder="-">
                                </td>
                                {{-- UH 2 --}}
                                <td class="p-1">
                                    <input type="number"
                                           name="nilai[{{ $siswa->id }}][uh_2]"
                                           class="form-control form-control-sm text-center"
                                           min="0" max="100"
                                           value="{{ $existing->uh_2 ?? '' }}"
                                           placeholder="-">
                                </td>
                                {{-- UH 3 --}}
                                <td class="p-1">
                                    <input type="number"
                                           name="nilai[{{ $siswa->id }}][uh_3]"
                                           class="form-control form-control-sm text-center"
                                           min="0" max="100"
                                           value="{{ $existing->uh_3 ?? '' }}"
                                           placeholder="-">
                                </td>
                                {{-- UH 4 --}}
                                <td class="p-1">
                                    <input type="number"
                                           name="nilai[{{ $siswa->id }}][uh_4]"
                                           class="form-control form-control-sm text-center"
                                           min="0" max="100"
                                           value="{{ $existing->uh_4 ?? '' }}"
                                           placeholder="-">
                                </td>
                                {{-- UH 5 --}}
                                <td class="p-1">
                                    <input type="number"
                                           name="nilai[{{ $siswa->id }}][uh_5]"
                                           class="form-control form-control-sm text-center"
                                           min="0" max="100"
                                           value="{{ $existing->uh_5 ?? '' }}"
                                           placeholder="-">
                                </td>
                                {{-- PTS --}}
                                <td class="p-1">
                                    <input type="number"
                                           name="nilai[{{ $siswa->id }}][pts]"
                                           class="form-control form-control-sm text-center"
                                           min="0" max="100"
                                           value="{{ $existing->pts ?? '' }}"
                                           placeholder="0">
                                </td>
                                {{-- PAS --}}
                                <td class="p-1">
                                    <input type="number"
                                           name="nilai[{{ $siswa->id }}][pas]"
                                           class="form-control form-control-sm text-center"
                                           min="0" max="100"
                                           value="{{ $existing->pas ?? '' }}"
                                           placeholder="0">
                                </td>
                                {{-- Remedial --}}
                                <td class="p-1">
                                    <input type="number"
                                           name="nilai[{{ $siswa->id }}][remedial]"
                                           class="form-control form-control-sm text-center"
                                           min="0" max="100"
                                           value="{{ $existing->remedial ?? '' }}"
                                           placeholder="-">
                                </td>
                                {{-- Keterampilan --}}
                                <td class="p-1">
                                    <input type="number"
                                           name="nilai[{{ $siswa->id }}][keterampilan]"
                                           class="form-control form-control-sm text-center"
                                           min="0" max="100"
                                           value="{{ $existing->nilai_keterampilan ?? '' }}"
                                           placeholder="0" required>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-right p-3">
                    <small class="text-muted mr-3">
                        <i class="fas fa-info-circle"></i>
                        Kolom UH boleh dikosongkan. Sistem akan otomatis menghitung rata-rata dari UH yang terisi saja.
                    </small>
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-save"></i> Simpan & Hitung Otomatis
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
