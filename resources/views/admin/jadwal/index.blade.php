@extends('layouts.admin')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Jadwal Mengajar</h1>
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambah">
            <i class="fas fa-plus fa-sm"></i> Tambah Jadwal
        </button>
    </div>

    <div class="alert alert-info">
        Menampilkan jadwal untuk Tahun Akademik: <strong>{{ $tahunAktif->tahun_akademik ?? 'Tidak Ada' }} - {{ $tahunAktif->semester ?? '-' }}</strong>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal Menyimpan!</strong> Coba cek lagi isian di bawah ini:
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-dark" width="100%" cellspacing="0">
<thead class="thead-dark">
    <tr>
        <th>No</th>
        <th>Nama Guru</th>
        <th>Mata Pelajaran</th>
        <th>Rombel / Kelas</th>
        <th>Hari & Jam Mengajar</th> <th>Aksi</th>
    </tr>
</thead>
<tbody>
@forelse($jadwals as $index => $j)
<tr>
    <td class="text-center">{{ $index + 1 }}</td>
    <td>{{ $j->guru->nama_guru }}</td>
    <td>{{ $j->mapel->nama_mapel }}</td>
    <td>{{ $j->rombel->kelas->nama_kelas }}</td>
    <td>
        <span class="font-weight-bold text-dark">
            <i class="far fa-calendar-alt text-success"></i> {{ $j->hari ?? 'Belum diset' }},
            <i class="far fa-clock text-primary ml-1"></i>
            {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} -
            {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
        </span>
    </td>
    <td class="text-center">
        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit{{ $j->id }}">
            <i class="fas fa-edit"></i>
        </button>

        <form action="{{ route('jadwal.destroy', $j->id) }}" method="POST" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus jadwal ini?')">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </td>
</tr>

<div class="modal fade" id="modalEdit{{ $j->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-dark text-left">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title font-weight-bold">Edit Jadwal Mengajar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('jadwal.update', $j->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih Guru</label>
                        <select name="guru_id" class="form-control" required>
                            @foreach($gurus as $g)
                                <option value="{{ $g->id }}" {{ $j->guru_id == $g->id ? 'selected' : '' }}>{{ $g->nama_guru }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Pilih Mata Pelajaran</label>
                        <select name="mapel_id" class="form-control" required>
                            @foreach($mapels as $m)
                                <option value="{{ $m->id }}" {{ $j->mapel_id == $m->id ? 'selected' : '' }}>[{{ $m->kode_mapel }}] {{ $m->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Pilih Rombel / Kelas</label>
                        <select name="rombel_id" class="form-control" required>
                            @foreach($rombels as $r)
                                <option value="{{ $r->id }}" {{ $j->rombel_id == $r->id ? 'selected' : '' }}>{{ $r->kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Pilih Hari</label>
                        <select name="hari" class="form-control" required>
                            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                                <option value="{{ $hari }}" {{ $j->hari == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jam Mulai</label>
                                <input type="time" name="jam_mulai" class="form-control" value="{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jam Selesai</label>
                                <input type="time" name="jam_selesai" class="form-control" value="{{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning font-weight-bold text-dark">Update Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>

@empty
    <tr>
        <td colspan="6" class="text-center">Belum ada jadwal mengajar di tahun akademik ini.</td>
    </tr>
    @endforelse
</tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-dark">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Jadwal Mengajar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('jadwal.store') }}" method="POST">
                @csrf
 <div class="modal-body">

    <div class="form-group">
        <label>Pilih Guru</label>
        <select name="guru_id" class="form-control" required>
            <option value="">-- Pilih Guru --</option>
            @foreach($gurus as $g)
                <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Pilih Mata Pelajaran</label>
        <select name="mapel_id" class="form-control" required>
            <option value="">-- Pilih Mapel --</option>
            @foreach($mapels as $m)
                <option value="{{ $m->id }}">[{{ $m->kode_mapel }}] {{ $m->nama_mapel }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="font-weight-bold">Pilih Rombel / Kelas (Bisa centang lebih dari satu)</label>
        <div class="row">
            @foreach($rombels as $r)
            <div class="col-md-6 mb-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="rombel_id[]" value="{{ $r->id }}" id="rombel{{ $r->id }}">
                    <label class="form-check-label" for="rombel{{ $r->id }}">
                        {{ $r->kelas->nama_kelas }}
                    </label>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="form-group">
        <label class="font-weight-bold">Pilih Hari</label>
        <select name="hari" class="form-control" required>
            <option value="">-- Pilih Hari --</option>
            <option value="Senin">Senin</option>
            <option value="Selasa">Selasa</option>
            <option value="Rabu">Rabu</option>
            <option value="Kamis">Kamis</option>
            <option value="Jumat">Jumat</option>
            <option value="Sabtu">Sabtu</option>
        </select>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Jam Mulai</label>
                <input type="time" name="jam_mulai" class="form-control" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Jam Selesai</label>
                <input type="time" name="jam_selesai" class="form-control" required>
            </div>
        </div>
    </div>

</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
