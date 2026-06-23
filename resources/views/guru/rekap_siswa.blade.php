@extends('layouts.guru')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Rekapitulasi & Absensi Siswa</h1>
        <a href="{{ route('walikelas.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4 border-left-primary">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <img class="img-profile rounded-circle shadow-sm mr-4" src="{{ asset('img/undraw_profile.svg') }}" style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #eaecf4;">
                <div>
                    <h4 class="font-weight-bold text-gray-800 mb-1">{{ $siswa->nama }}</h4>
                    <span class="badge badge-primary px-3 py-2 mr-2 shadow-sm" style="font-size: 14px;"><i class="fas fa-id-card mr-1"></i> NISN: {{ $siswa->nisn }}</span>
                    <span class="badge badge-success px-3 py-2 shadow-sm" style="font-size: 14px;"><i class="fas fa-chalkboard mr-1"></i> Kelas: {{ $rombel->kelas->nama_kelas }}</span>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('walikelas.simpan', $siswa->id) }}" method="POST">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary text-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold">Lembar Pengelolaan Nilai & Catatan (Bisa Diedit)</h6>
                <button type="submit" class="btn btn-success btn-sm shadow-sm">
                    <i class="fas fa-save"></i> Simpan Semua Perubahan
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle" style="min-width: 2000px;">
                        <thead class="bg-info text-white">
                            <tr>
                                <th class="align-middle" rowspan="2" width="3%">No</th>
                                <th class="align-middle" rowspan="2" width="12%">Mata Pelajaran</th>
                                <th colspan="8">Nilai Mentah (Dapat Diedit)</th>
                                <th class="align-middle" rowspan="2" width="7%">Keterampilan<br><small>(Mentah)</small></th>
                                <th class="align-middle" rowspan="2" width="18%">Absensi & Catatan Wali</th>
                                <th class="align-middle" rowspan="2" width="7%">Nilai<br>Pengetahuan</th>
                                <th class="align-middle" rowspan="2" width="7%">Nilai Akhir<br><small>(Akumulasi)</small></th>
                                <th class="align-middle" rowspan="2" width="6%">Sikap</th>
                            </tr>
                            <tr>
                                <th width="4%">UH1</th>
                                <th width="4%">UH2</th>
                                <th width="4%">UH3</th>
                                <th width="4%">UH4</th>
                                <th width="4%">UH5</th>
                                <th width="5%">REMEDIAL</th>
                                <th width="4%">PTS</th>
                                <th width="4%">PAS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($nilais as $index => $n)
                            <tr>
                                <td class="align-middle">{{ $index + 1 }}</td>
                                <td class="align-middle text-left font-weight-bold">{{ $n->nama_mapel }}</td>

                                <td class="align-middle">
                                    <input type="hidden" name="nilai[{{ $n->id }}][id]" value="{{ $n->id }}">
                                    <input type="number" class="form-control form-control-sm text-center" name="nilai[{{ $n->id }}][uh_1]" value="{{ $n->uh_1 }}" min="0" max="100" step="0.01">
                                </td>
                                <td class="align-middle"><input type="number" class="form-control form-control-sm text-center" name="nilai[{{ $n->id }}][uh_2]" value="{{ $n->uh_2 }}" min="0" max="100" step="0.01"></td>
                                <td class="align-middle"><input type="number" class="form-control form-control-sm text-center" name="nilai[{{ $n->id }}][uh_3]" value="{{ $n->uh_3 }}" min="0" max="100" step="0.01"></td>
                                <td class="align-middle"><input type="number" class="form-control form-control-sm text-center" name="nilai[{{ $n->id }}][uh_4]" value="{{ $n->uh_4 }}" min="0" max="100" step="0.01" placeholder="-"></td>
                                <td class="align-middle"><input type="number" class="form-control form-control-sm text-center" name="nilai[{{ $n->id }}][uh_5]" value="{{ $n->uh_5 }}" min="0" max="100" step="0.01" placeholder="-"></td>
                                <td class="align-middle" style="background-color: #fff8e1;">
                                    <input type="number" class="form-control form-control-sm text-center font-weight-bold text-warning" name="nilai[{{ $n->id }}][remedial]" value="{{ $n->remedial }}" min="0" max="100" step="0.01" placeholder="-" title="Jika diisi & ≥ KKM, nilai pengetahuan akan mentok di KKM">
                                </td>
                                <td class="align-middle"><input type="number" class="form-control form-control-sm text-center" name="nilai[{{ $n->id }}][pts]" value="{{ $n->pts }}" min="0" max="100" step="0.01"></td>
                                <td class="align-middle"><input type="number" class="form-control form-control-sm text-center" name="nilai[{{ $n->id }}][pas]" value="{{ $n->pas }}" min="0" max="100" step="0.01"></td>

                                <td class="align-middle font-weight-bold">{{ $n->nilai_keterampilan ?? '-' }}</td>

                                @if($index == 0)
                                <td rowspan="{{ count($nilais) }}" class="align-top text-left bg-light">
                                    <div class="row mb-2">
                                        <div class="col-4">
                                            <label class="small font-weight-bold text-danger">Sakit:</label>
                                            <input type="number" name="sakit" value="{{ $catatan->sakit ?? 0 }}" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-4">
                                            <label class="small font-weight-bold text-warning">Izin:</label>
                                            <input type="number" name="izin" value="{{ $catatan->izin ?? 0 }}" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-4">
                                            <label class="small font-weight-bold text-secondary">Alpa:</label>
                                            <input type="number" name="alpa" value="{{ $catatan->alpa ?? 0 }}" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <label class="small font-weight-bold text-primary mt-2">Catatan Wali Kelas:</label>
                                    <textarea name="catatan" rows="4" class="form-control form-control-sm" placeholder="Berikan catatan semangat untuk siswa...">{{ $catatan->catatan ?? '' }}</textarea>
                                </td>
                                @endif

                                <td class="align-middle font-weight-bold text-primary" style="font-size: 15px;">{{ $n->nilai_pengetahuan ?? '-' }}</td>
                                <td class="align-middle font-weight-bold text-success" style="font-size: 15px;">{{ $n->nilai_akhir ?? '-' }}</td>

                                <td class="align-middle">
                                    <select class="form-control form-control-sm font-weight-bold text-center" name="nilai[{{ $n->id }}][sikap]">
                                        <option value="" {{ empty($n->sikap) ? 'selected' : '' }}>-</option>
                                        <option value="A" {{ $n->sikap == 'A' ? 'selected' : '' }} class="text-success">A</option>
                                        <option value="B" {{ $n->sikap == 'B' ? 'selected' : '' }} class="text-primary">B</option>
                                        <option value="C" {{ $n->sikap == 'C' ? 'selected' : '' }} class="text-warning">C</option>
                                        <option value="D" {{ $n->sikap == 'D' ? 'selected' : '' }} class="text-danger">D</option>
                                    </select>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="15" class="text-center text-muted py-4">
                                    <i class="fas fa-box-open mb-3" style="font-size: 30px;"></i><br>
                                    Belum ada data nilai dari Guru Mata Pelajaran.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
