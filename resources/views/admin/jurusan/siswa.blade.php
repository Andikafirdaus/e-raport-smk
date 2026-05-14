@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-building text-primary mr-2"></i>
                Siswa Jurusan {{ $jurusan->singkatan }}
            </h1>
            <p class="mb-0 text-muted small">{{ $jurusan->nama_jurusan }}</p>
        </div>
        <a href="/dashboard-admin/jurusan" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Jurusan
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-users mr-2"></i> Daftar Siswa
            </h6>
            <span class="badge badge-primary px-3 py-2">Total: {{ $siswas->count() }} siswa</span>
        </div>
        <div class="card-body">
            @if($siswas->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Nama Siswa</th>
                            <th width="15%">NISN</th>
                            <th width="10%">L/P</th>
                            <th width="20%">Kelas</th>
                            <th width="10%" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswas as $i => $s)
                        <tr>
                            <td class="text-center align-middle">{{ $i + 1 }}</td>
                            <td class="align-middle font-weight-bold">
                                <div class="d-flex align-items-center">
                                    @if($s->foto)
                                        <img src="{{ asset('storage/'.$s->foto) }}" alt="foto"
                                             class="rounded-circle mr-2" style="width:32px;height:32px;object-fit:cover;">
                                    @else
                                        <div class="rounded-circle mr-2 d-flex align-items-center justify-content-center"
                                             style="width:32px;height:32px;background:linear-gradient(135deg,#4e73df,#224abe);color:#fff;font-weight:700;font-size:13px;flex-shrink:0;">
                                            {{ strtoupper(substr($s->nama, 0, 1)) }}
                                        </div>
                                    @endif
                                    {{ $s->nama }}
                                </div>
                            </td>
                            <td class="align-middle">{{ $s->nisn }}</td>
                            <td class="align-middle">
                                <span class="badge {{ $s->jenis_kelamin === 'L' ? 'badge-info' : 'badge-danger' }}">
                                    {{ $s->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </td>
                            <td class="align-middle small">
                                @foreach($s->rombels as $r)
                                    <span class="badge badge-light border">{{ $r->kelas->nama_kelas }}</span>
                                @endforeach
                            </td>
                            <td class="align-middle text-center">
                                <span class="badge {{ ($s->status ?? 'Aktif') === 'Aktif' ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $s->status ?? 'Aktif' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5 text-muted">
                <i class="fas fa-users fa-3x mb-3 d-block text-gray-300"></i>
                <h5>Belum ada siswa di jurusan ini</h5>
                <p class="small">Siswa akan muncul setelah dimasukkan ke dalam rombel yang terhubung dengan jurusan ini.</p>
            </div>
            @endif
        </div>
    </div>

</div>
@endsection
