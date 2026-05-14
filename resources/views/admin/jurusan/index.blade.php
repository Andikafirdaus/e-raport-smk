@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Data Master Jurusan</h1>
    <p class="mb-4">Halaman ini digunakan untuk mengelola data jurusan yang ada di SMK.</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Jurusan</h6>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahJurusanModal">
                <i class="fas fa-plus"></i> Tambah Jurusan
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
<table class="table table-bordered" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th>Singkatan</th>
            <th>Nama Jurusan Lengkap</th>
            <th width="15%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data_jurusan as $index => $jur)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td class="font-weight-bold"><span class="badge badge-primary">{{ $jur->singkatan }}</span></td>
            <td>
                <a href="/dashboard-admin/jurusan/{{ $jur->id }}/siswa"
                   class="font-weight-bold text-primary"
                   title="Lihat siswa jurusan ini">
                    {{ $jur->nama_jurusan }}
                    <i class="fas fa-external-link-alt fa-xs ml-1 text-muted"></i>
                </a>
            </td>
            <td>
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editJurusanModal{{ $jur->id }}">
                    <i class="fas fa-edit"></i>
                </button>

                <form action="/dashboard-admin/jurusan/{{ $jur->id }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE') <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus jurusan ini?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </td>
        </tr>

        <div class="modal fade" id="editJurusanModal{{ $jur->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data Jurusan</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="/dashboard-admin/jurusan/{{ $jur->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Singkatan</label>
                                <input type="text" class="form-control" name="singkatan" value="{{ $jur->singkatan }}" required>
                            </div>
                            <div class="form-group">
                                <label>Nama Jurusan Lengkap</label>
                                <input type="text" class="form-control" name="nama_jurusan" value="{{ $jur->nama_jurusan }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning">Update Data</button>
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
    <div class="modal fade" id="tambahJurusanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Jurusan Baru</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form action="/dashboard-admin/jurusan" method="POST">
                @csrf <div class="modal-body">
                    <div class="form-group">
                        <label>Singkatan (Contoh: RPL)</label>
                        <input type="text" class="form-control" name="singkatan" required placeholder="Masukkan singkatan...">
                    </div>
                    <div class="form-group">
                        <label>Nama Jurusan Lengkap</label>
                        <input type="text" class="form-control" name="nama_jurusan" required placeholder="Masukkan nama jurusan...">
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
