@extends('layouts.admin')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Dashboard Utama</h1>
        <p class="mb-0 text-muted small">Selamat datang, <strong>{{ Auth::user()->name ?? 'Admin' }}</strong> 👋</p>
    </div>
    <span class="badge badge-primary px-3 py-2" style="font-size:0.85rem;">
        <i class="fas fa-calendar-check mr-1"></i>
        @php
            $tahunAktif = \App\Models\TahunAkademik::where('status', 'Aktif')->first();
        @endphp
        {{ $tahunAktif ? $tahunAktif->tahun_akademik . ' — ' . $tahunAktif->semester : 'Belum ada tahun aktif' }}
    </span>
</div>

<!-- Kartu Statistik -->
<div class="row">

    <!-- Total Siswa -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Siswa</div>
                        <div class="h2 mb-0 font-weight-bold text-gray-800">{{ $totalSiswa }}</div>
                        <div class="text-xs text-muted mt-1">{{ $siswaAktif }} aktif</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Guru -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Guru</div>
                        <div class="h2 mb-0 font-weight-bold text-gray-800">{{ $totalGuru }}</div>
                        <div class="text-xs text-muted mt-1">{{ $guruAktif }} aktif</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Mata Pelajaran -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Mata Pelajaran</div>
                        <div class="h2 mb-0 font-weight-bold text-gray-800">{{ $totalMapel }}</div>
                        <div class="text-xs text-muted mt-1">{{ $totalKelas }} kelas terdaftar</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tahun Akademik -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Tahun Akademik</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $tahunAktif ? $tahunAktif->tahun_akademik : '-' }}
                        </div>
                        <div class="text-xs text-muted mt-1">
                            Semester {{ $tahunAktif ? $tahunAktif->semester : '-' }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Row 2: Jurusan & Rombel -->
<div class="row">

    <!-- Data Jurusan -->
    <div class="col-xl-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-building mr-2"></i> Data Jurusan
                </h6>
                <a href="/dashboard-admin/jurusan" class="btn btn-primary btn-sm">Kelola</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead style="background:#f8f9fc;">
                            <tr>
                                <th class="pl-3">Jurusan</th>
                                <th class="text-center">Singkatan</th>
                                <th class="text-center">Jml Kelas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jurusans as $j)
                            <tr>
                                <td class="pl-3">
                                    <a href="/dashboard-admin/jurusan/{{ $j->id }}/siswa"
                                       class="font-weight-bold text-primary" style="text-decoration:none;">
                                        {{ $j->nama_jurusan }}
                                    </a>
                                </td>
                                <td class="text-center"><span class="badge badge-primary">{{ $j->singkatan }}</span></td>
                                <td class="text-center font-weight-bold">{{ $j->kelas_count ?? 0 }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">Belum ada data jurusan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Rombel Aktif -->
    <div class="col-xl-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-users-cog mr-2"></i> Rombel Tahun Ini
                </h6>
                <span class="badge badge-success">{{ $totalRombel }} Rombel</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead style="background:#f8f9fc;">
                            <tr>
                                <th class="pl-3">Rombel</th>
                                <th class="text-center">Wali Kelas</th>
                                <th class="text-center">Jml Siswa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rombels as $r)
                            <tr>
                                <td class="pl-3 font-weight-bold">{{ $r->kelas->nama_kelas ?? '-' }}</td>
                                <td class="text-center small text-muted">
                                    {{ $r->waliKelas ? $r->waliKelas->nama_guru : '<span class="text-danger">Belum diset</span>' }}
                                </td>
                                <td class="text-center font-weight-bold">{{ $r->siswas->count() }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">Belum ada rombel aktif</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection