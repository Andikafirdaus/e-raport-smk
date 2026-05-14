@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Data Master Kelas</h1>
    <p class="mb-4">Halaman ini digunakan untuk mengelola data kelas dan relasinya dengan jurusan.</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kelas</h6>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahKelasModal">
                <i class="fas fa-plus"></i> Tambah Kelas
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Jurusan</th>
                            <th>Wali Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_kelas as $index => $kel)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="font-weight-bold">{{ $kel->nama_kelas }}</td>
                            <td>{{ $kel->jurusan->nama_jurusan }} ({{ $kel->jurusan->singkatan }})</td>
                            <td>
                                @if($kel->waliKelas)
                                    <span class="badge badge-info">{{ $kel->waliKelas->nama_guru }}</span>
                                @else
                                    <span class="badge badge-secondary">Belum Ada Wali</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editKelasModal{{ $kel->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form action="/dashboard-admin/kelas/{{ $kel->id }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kelas {{ $kel->nama_kelas }}?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <div class="modal fade" id="editKelasModal{{ $kel->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Data Kelas</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <form action="/dashboard-admin/kelas/{{ $kel->id }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Nama Kelas</label>
                                                <input type="text" class="form-control" name="nama_kelas" value="{{ $kel->nama_kelas }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Pilih Jurusan</label>
                                                <select class="form-control" name="jurusan_id" required>
                                                    @foreach($data_jurusan as $jur)
                                                        <option value="{{ $jur->id }}" {{ $kel->jurusan_id == $jur->id ? 'selected' : '' }}>
                                                            {{ $jur->singkatan }} - {{ $jur->nama_jurusan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Wali Kelas (Opsional)</label>
                                                <select name="guru_id" class="form-control">
                                                    <option value="">-- Pilih Wali Kelas --</option>
                                                    @foreach($data_guru as $guru)
                                                        <option value="{{ $guru->id }}" {{ $kel->guru_id == $guru->id ? 'selected' : '' }}>
                                                            {{ $guru->nama_guru }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambahKelasModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Kelas Baru</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="/dashboard-admin/kelas" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Kelas (Contoh: 10 RPL 1)</label>
                            <input type="text" class="form-control" name="nama_kelas" required placeholder="Masukkan nama kelas...">
                        </div>
                        <div class="form-group">
                            <label>Pilih Jurusan</label>
                            <select class="form-control" name="jurusan_id" required>
                                <option value="">-- Pilih Jurusan --</option>
                                @foreach($data_jurusan as $jur)
                                    <option value="{{ $jur->id }}">{{ $jur->singkatan }} - {{ $jur->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Wali Kelas (Opsional)</label>
                            <select name="guru_id" class="form-control">
                                <option value="">-- Pilih Wali Kelas --</option>
                                @foreach($data_guru as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->nama_guru }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
