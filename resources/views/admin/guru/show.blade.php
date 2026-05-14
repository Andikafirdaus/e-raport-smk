@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Profil Guru</h1>
        <a href="{{ route('guru.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    @if($guru->foto)
                        <img src="{{ asset('storage/foto_guru/'.$guru->foto) }}" class="img-profile rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($guru->nama_guru) }}&background=random&size=150" class="rounded-circle img-thumbnail">
                    @endif
                    <h5 class="mt-3 font-weight-bold text-dark">{{ $guru->nama_guru }}</h5>
                    <p class="text-muted mb-2">NIP: {{ $guru->nip ?? 'Belum Diatur' }}</p>

                    @php
                        $badgeColor = 'success';
                        $statusText = $guru->status ?? 'Aktif';
                        if($statusText == 'Cuti') $badgeColor = 'warning';
                        elseif($statusText == 'Pindah') $badgeColor = 'info';
                        elseif($statusText == 'Pensiun' || $statusText == 'Keluar') $badgeColor = 'danger';
                    @endphp
                    <span class="badge badge-{{ $badgeColor }} px-3 py-2 mb-3"><i class="fas fa-info-circle"></i> Status: {{ $statusText }}</span>

                    <hr>

                    <div class="d-flex flex-column gap-2 mt-3">
                        <button class="btn btn-warning btn-sm mb-2" data-toggle="modal" data-target="#modalEditGuru">
                            <i class="fas fa-edit"></i> Edit Profil
                        </button>
                        <button class="btn btn-info btn-sm mb-2" data-toggle="modal" data-target="#modalUbahStatus">
                            <i class="fas fa-exchange-alt"></i> Ubah Status
                        </button>
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapusGuru">
                            <i class="fas fa-trash"></i> Hapus Guru
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Kontak & Pribadi</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless text-dark">
                        <tr>
                            <th width="30%">Nama Lengkap</th>
                            <td>: {{ $guru->nama_guru }}</td>
                        </tr>
                        <tr>
                            <th>NIP</th>
                            <td>: {{ $guru->nip ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>: {{ $guru->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <th>Email (Username)</th>
                            <td>: <strong>{{ $guru->email }}</strong></td>
                        </tr>
                        <tr>
                            <th>No. HP</th>
                            <td>: {{ $guru->no_hp ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUbahStatus" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Ubah Status Guru</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('guru.update_status', $guru->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body text-dark">
                    <div class="form-group">
                        <label>Status Saat Ini: <strong>{{ $guru->status ?? 'Aktif' }}</strong></label>
                        <select name="status" class="form-control" required>
                            <option value="Aktif" {{ ($guru->status == 'Aktif') ? 'selected' : '' }}>Aktif / Mengajar</option>
                            <option value="Cuti" {{ ($guru->status == 'Cuti') ? 'selected' : '' }}>Cuti</option>
                            <option value="Pindah" {{ ($guru->status == 'Pindah') ? 'selected' : '' }}>Pindah Tugas</option>
                            <option value="Pensiun" {{ ($guru->status == 'Pensiun') ? 'selected' : '' }}>Pensiun</option>
                            <option value="Keluar" {{ ($guru->status == 'Keluar') ? 'selected' : '' }}>Berhenti / Keluar</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info">Simpan Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditGuru" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">Edit Data: {{ $guru->nama_guru }}</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('guru.update', $guru->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body text-dark text-left">
                    <div class="form-group">
                        <label>NIP</label>
                        <input type="text" name="nip" class="form-control" value="{{ $guru->nip }}">
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap Guru</label>
                        <input type="text" name="nama_guru" class="form-control" value="{{ $guru->nama_guru }}" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="L" {{ $guru->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ $guru->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>No. HP</label>
                        <input type="text" name="no_hp" class="form-control" value="{{ $guru->no_hp }}">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $guru->email }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalHapusGuru" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('guru.destroy', $guru->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-dark text-left">
                    <p>Yakin mau menghapus data guru <strong>{{ $guru->nama_guru }}</strong>?</p>
                    <p class="text-danger small">*Data ini akan dihapus permanen dari sistem.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus!</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
