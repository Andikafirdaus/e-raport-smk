@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Data Master Mata Pelajaran</h1>
    <p class="mb-4">Kelola daftar mata pelajaran (Mapel) yang ada di sekolah.</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Mapel</h6>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahMapelModal">
                <i class="fas fa-plus"></i> Tambah Mapel
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Kode</th>
                            <th>Nama Mata Pelajaran</th>
                            <th>Kelompok</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_mapel as $index => $mpl)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="font-weight-bold">{{ $mpl->kode_mapel }}</td>
                            <td>{{ $mpl->nama_mapel }}</td>
                            <td>{{ $mpl->kelompok ?? '-' }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editMapelModal{{ $mpl->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="/dashboard-admin/mapel/{{ $mpl->id }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus Mapel ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <div class="modal fade" id="editMapelModal{{ $mpl->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Mapel</h5>
                                        <button class="close" type="button" data-dismiss="modal"><span>×</span></button>
                                    </div>
                                    <form action="/dashboard-admin/mapel/{{ $mpl->id }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Kode Mapel</label>
                                                <input type="text" class="form-control" name="kode_mapel" value="{{ $mpl->kode_mapel }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Mapel</label>
                                                <input type="text" class="form-control" name="nama_mapel" value="{{ $mpl->nama_mapel }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Kelompok (Opsional)</label>
                                                <input type="text" class="form-control" name="kelompok" value="{{ $mpl->kelompok }}" placeholder="Contoh: Muatan Nasional">
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

    <div class="modal fade" id="tambahMapelModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Mapel Baru</h5>
                    <button class="close" type="button" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="/dashboard-admin/mapel" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kode Mapel (Misal: MTK)</label>
                            <input type="text" class="form-control" name="kode_mapel" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Mapel (Misal: Matematika)</label>
                            <input type="text" class="form-control" name="nama_mapel" required>
                        </div>
                        <div class="form-group">
                            <label>Kelompok (Opsional)</label>
                            <input type="text" class="form-control" name="kelompok" placeholder="Contoh: Muatan Kejuruan">
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
