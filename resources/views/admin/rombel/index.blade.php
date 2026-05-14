@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Manajemen Rombongan Belajar (Rombel)</h1>
    <p class="mb-4">Halaman ini digunakan untuk menempatkan siswa ke dalam kelas pada tahun ajaran yang sedang aktif.</p>

    {{-- Alert jika sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Pengecekan Tahun Akademik Aktif --}}
    @if(!$tahunAktif)
        <div class="alert alert-danger shadow" role="alert">
            <h4 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Perhatian!</h4>
            <p>Belum ada <b>Tahun Akademik</b> yang di-set menjadi <b>Aktif</b>. Anda tidak bisa mengelola Rombel.</p>
            <hr>
            <p class="mb-0">Silakan ke menu <a href="/dashboard-admin/tahun-akademik" class="font-weight-bold text-danger">Tahun Ajaran Aktif</a> terlebih dahulu untuk mengaktifkan salah satu tahun ajaran.</p>
        </div>
    @else
        <div class="alert alert-info shadow font-weight-bold" role="alert">
            <i class="fas fa-calendar-check mr-2"></i> Tahun Ajaran Aktif Saat Ini: {{ $tahunAktif->tahun_akademik }} - {{ $tahunAktif->semester }}
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Rombel / Kelas Tersedia</h6>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahRombelModal">
                    <i class="fas fa-plus"></i> Tambah Rombel
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
                                <th>Jml Siswa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rombels as $index => $rombel)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="font-weight-bold">{{ $rombel->kelas->nama_kelas }}</td>
                                <td>{{ $rombel->kelas->jurusan->singkatan }}</td>
                                <td>
                                    @if($rombel->waliKelas)
                                        {{ $rombel->waliKelas->nama_guru }}
                                    @else
                                        <span class="badge badge-secondary">Belum Ada Wali</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-success" style="font-size: 14px;">
                                        {{ $rombel->siswas_count }} Siswa
                                    </span>
                                </td>
                                <td>
                                    {{-- Tombol ini nanti akan mengarah ke halaman kelola anggota (sementara href-nya kita arahkan ke method show) --}}
                                    <a href="/dashboard-admin/rombel/{{ $rombel->id }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-users"></i> Kelola Anggota
                                    </a>

                                    <form action="/dashboard-admin/rombel/{{ $rombel->id }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus rombel kelas {{ $rombel->kelas->nama_kelas }}? (Data siswa di dalamnya hanya akan dikeluarkan dari kelas, tidak akan terhapus)')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada rombel yang dibuat untuk tahun ajaran ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Modal Tambah Rombel (Hanya dirender jika ada tahun aktif) --}}
        <div class="modal fade" id="tambahRombelModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Buka Rombel Baru</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="/dashboard-admin/rombel" method="POST">
                        @csrf
                        {{-- Kita tidak perlu mengirim tahun_akademik_id dari view untuk mencegah manipulasi, nanti kita set otomatis di Controller berdasarkan tahun yang aktif --}}
                        <div class="modal-body">
                            <p class="text-muted small">Rombel akan otomatis dimasukkan ke Tahun Ajaran: <b>{{ $tahunAktif->tahun_akademik }} ({{ $tahunAktif->semester }})</b></p>
<div class="form-group">
    <label>Pilih Kelas</label>
    <select class="form-control" name="kelas_id" required>
        <option value="">-- Pilih Kelas --</option>
        @foreach($kelasList as $kelas)
            <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }} - {{ $kelas->jurusan->singkatan }}</option>
        @endforeach
    </select>
</div>

    <div class="form-group mt-3">
        <label>Pilih Wali Kelas</label>
        <select class="form-control" name="guru_id" required>
            <option value="">-- Tentukan Wali Kelas --</option>
            @foreach($guruList as $guru)
                <option value="{{ $guru->id }}">{{ $guru->nama_guru }}</option>
            @endforeach
        </select>
    </div>
                            <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
