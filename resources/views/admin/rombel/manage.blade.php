@extends('layouts.admin')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Anggota Kelas: {{ $rombel->kelas->nama_kelas }}</h1>
        <a href="/dashboard-admin/rombel" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <p class="mb-4">Tahun Ajaran Aktif: <b>{{ $rombel->tahunAkademik->tahun_akademik }} ({{ $rombel->tahunAkademik->semester }})</b> | Jurusan: <b>{{ $rombel->kelas->jurusan->singkatan }}</b></p>

    {{-- Pesan Sukses/Error --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Bagian Kiri: Daftar Siswa Tersedia (Belum Punya Kelas) -->
        <div class="col-lg-6">
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-users"></i> Siswa Belum Punya Kelas ({{ $siswaTersedia->count() }})</h6>
                </div>
                <div class="card-body">
                    <form action="/dashboard-admin/rombel/{{ $rombel->id }}/add" method="POST">
                        @csrf
                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                            <table class="table table-bordered table-sm table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" width="10%">Pilih</th>
                                        <th>NISN</th>
                                        <th>Nama Siswa</th>
                                        <th class="text-center">L/P</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($siswaTersedia as $siswa)
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" name="siswa_id[]" value="{{ $siswa->id }}" style="transform: scale(1.5);">
                                            </td>
                                            <td>{{ $siswa->nisn }}</td>
                                            <td>{{ $siswa->nama }}</td>
                                            <td class="text-center">{{ $siswa->jenis_kelamin }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Semua siswa sudah masuk ke dalam kelas.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($siswaTersedia->count() > 0)
                            <button type="submit" class="btn btn-primary btn-block mt-3">
                                Masukkan Siswa Terpilih <i class="fas fa-arrow-right"></i>
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <!-- Bagian Kanan: Daftar Anggota Kelas Saat Ini -->
        <div class="col-lg-6">
            <div class="card shadow mb-4 border-left-success">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-check-circle"></i> Anggota Kelas Saat Ini ({{ $anggotaRombel->count() }})</h6>
                </div>
                <div class="card-body">
                    <form action="/dashboard-admin/rombel/{{ $rombel->id }}/remove" method="POST">
                        @csrf
                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                            <table class="table table-bordered table-sm table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" width="10%">Pilih</th>
                                        <th>NISN</th>
                                        <th>Nama Siswa</th>
                                        <th class="text-center">L/P</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($anggotaRombel as $anggota)
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" name="siswa_id[]" value="{{ $anggota->id }}" style="transform: scale(1.5);">
                                            </td>
                                            <td>{{ $anggota->nisn }}</td>
                                            <td>{{ $anggota->nama }}</td>
                                            <td class="text-center">{{ $anggota->jenis_kelamin }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Belum ada siswa di kelas ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($anggotaRombel->count() > 0)
                            <button type="submit" class="btn btn-danger btn-block mt-3">
                                <i class="fas fa-trash"></i> Keluarkan Siswa Terpilih
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
