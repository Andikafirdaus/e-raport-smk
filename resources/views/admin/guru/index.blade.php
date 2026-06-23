@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Master Data Guru</h1>
    </div>

    <div class="card shadow mb-4">
        {{-- ===== CARD HEADER: Search + Tombol Tambah ===== --}}
        <div class="card-header py-3">
            <div class="row align-items-center">
                {{-- Kiri: Form Search --}}
                <div class="col-md-8">
                    <form action="{{ route('guru.index') }}" method="GET" class="form-inline">
                        <div class="input-group input-group-sm mr-2">
                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   placeholder="Cari Nama Guru atau NIP..."
                                   value="{{ request('search') }}"
                                   style="min-width: 280px;">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i> Cari
                                </button>
                            </div>
                        </div>
                        @if(request('search'))
                            <a href="{{ route('guru.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times mr-1"></i> Reset
                            </a>
                        @endif
                    </form>
                </div>
                {{-- Kanan: Tombol Tambah --}}
                <div class="col-md-4 text-right">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahGuru">
                        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Guru
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body">
            {{-- Info hasil pencarian --}}
            @if(request('search'))
                <div class="alert alert-info py-2 mb-3">
                    <i class="fas fa-search mr-1"></i>
                    Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
                    ({{ $gurus->total() }} data ditemukan)
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th>NIP</th>
                            <th>Nama Guru</th>
                            <th width="5%">L/P</th>
                            <th>Email</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gurus as $index => $guru)
                        <tr>
                            <td>{{ $gurus->firstItem() + $index }}</td>
                            <td>{{ $guru->nip ?? '-' }}</td>
                            <td>
                                <a href="{{ route('guru.show', $guru->id) }}" class="font-weight-bold text-primary" style="text-decoration: none;">
                                    {{ $guru->nama_guru }}
                                </a>
                            </td>
                            <td>{{ $guru->jenis_kelamin }}</td>
                            <td>{{ $guru->email }}</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditGuru{{ $guru->id }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapusGuru{{ $guru->id }}">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>

                                {{-- Modal Edit Guru --}}
                                <div class="modal fade" id="modalEditGuru{{ $guru->id }}" tabindex="-1" role="dialog" aria-hidden="true">
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

                                {{-- Modal Hapus Guru --}}
                                <div class="modal fade" id="modalHapusGuru{{ $guru->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title text-white">Konfirmasi Hapus</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('guru.destroy', $guru->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-body text-dark text-left">
                                                    <p>Yakin mau hapus guru <strong>{{ $guru->nama_guru }}</strong>?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Hapus Sekarang!</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                @if(request('search'))
                                    <i class="fas fa-search mr-2"></i> Tidak ada guru dengan kata kunci "<strong>{{ request('search') }}</strong>".
                                @else
                                    <i class="fas fa-users-slash mr-2"></i> Belum ada data guru.
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $gurus->links() }}
            </div>
        </div>
    </div>

</div>

{{-- ===== MODAL TAMBAH GURU ===== --}}
<div class="modal fade" id="modalTambahGuru" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Data Guru</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('guru.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>NIP (Opsional)</label>
                        <input type="text" name="nip" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap Guru</label>
                        <input type="text" name="nama_guru" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>No. HP</label>
                        <input type="text" name="no_hp" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email (Untuk Login)</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
