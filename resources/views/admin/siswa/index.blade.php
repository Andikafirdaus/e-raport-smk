@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Master Data Siswa</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <form action="{{ route('siswa.index') }}" method="GET" class="form-inline">
                        <select name="rombel_id" class="form-control form-control-sm mr-2" style="max-width: 250px;">
                            <option value="">-- Semua Kelas --</option>
                            @foreach($rombels as $r)
                                <option value="{{ $r->id }}" {{ request('rombel_id') == $r->id ? 'selected' : '' }}>
                                    {{ $r->kelas->nama_kelas ?? '' }} ({{ $r->tahunAkademik->tahun_akademik ?? '' }})
                                </option>
                            @endforeach
                        </select>

                        <div class="input-group input-group-sm mr-2">
                            <input type="text" name="search" class="form-control" placeholder="Cari Nama / NISN..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i> Cari
                                </button>
                            </div>
                        </div>

                        @if(request('search') || request('rombel_id'))
                            <a href="{{ route('siswa.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                        @endif
                    </form>
                </div>

                <div class="col-md-3 text-right">
                    <button type="button" class="btn btn-info btn-sm shadow-sm mr-1" data-toggle="modal" data-target="#modalImportSiswa"
                            title="Import data siswa dari file Excel atau CSV">
                        <i class="fas fa-file-excel fa-sm text-white-50"></i> Import Excel
                    </button>
                    <button type="button" class="btn btn-success btn-sm shadow-sm" data-toggle="modal" data-target="#modalTambahSiswa">
                        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Siswa
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th width="5%">L/P</th>
                            <th>Status Rombel / Kelas</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $index => $siswa)
                        <tr>
                            <td>{{ $siswas->firstItem() + $index }}</td>
                            <td>{{ $siswa->nisn }}</td>
                            <td>
                            <a href="{{ route('siswa.show', $siswa->id) }}" class="font-weight-bold text-primary" style="text-decoration: none;">
                                {{ $siswa->nama }}
                            </a>
                        </td>
                            <td>{{ $siswa->jenis_kelamin }}</td>
                            <td>
                                @php $rombelTerakhir = $siswa->rombels->last(); @endphp
                                @if($rombelTerakhir)
                                    <span class="badge badge-primary">
                                        {{ $rombelTerakhir->kelas->nama_kelas ?? '' }}
                                        ({{ $rombelTerakhir->tahunAkademik->tahun_akademik ?? '' }})
                                    </span>
                                @else
                                    <span class="badge badge-secondary">Belum Diatur</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditSiswa{{ $siswa->id }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapusSiswa{{ $siswa->id }}">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>

                                <div class="modal fade" id="modalEditSiswa{{ $siswa->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning text-white">
                                                <h5 class="modal-title">Edit Data: {{ $siswa->nama }}</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="row text-dark">
                                                        <div class="col-md-6 text-left">
                                                            <div class="form-group">
                                                                <label>NISN</label>
                                                                <input type="text" name="nisn" class="form-control" value="{{ $siswa->nisn }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Nama Lengkap</label>
                                                                <input type="text" name="nama" class="form-control" value="{{ $siswa->nama }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Jenis Kelamin</label>
                                                                <select name="jenis_kelamin" class="form-control" required>
                                                                    <option value="L" {{ $siswa->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                                    <option value="P" {{ $siswa->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 text-left">
                                                            <div class="form-group">
                                                                <label>Tanggal Lahir</label>
                                                                <input type="date" name="tanggal_lahir" class="form-control" value="{{ $siswa->tanggal_lahir }}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Alamat</label>
                                                                <textarea name="alamat" class="form-control" rows="2">{{ $siswa->alamat }}</textarea>
                                                            </div>
                                                        </div>
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

                                <div class="modal fade" id="modalHapusSiswa{{ $siswa->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-body text-dark text-left">
                                                    <p>Lu yakin mau ngehapus data siswa <strong>{{ $siswa->nama }}</strong>?</p>
                                                    <p class="text-danger small">*Data ini bakal ilang permanen dari database, Gung.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Ya, Hapus Aja!</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Data siswa tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
                {{ $siswas->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahSiswa" tabindex="-1" role="dialog" aria-labelledby="modalTambahSiswaLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: #0a2342;">
                <h5 class="modal-title" id="modalTambahSiswaLabel">
                    <i class="fas fa-user-plus mr-2"></i> Tambah Data Siswa
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('siswa.store') }}" method="POST" id="formTambahSiswa">
                @csrf

                {{-- ===== NAV TABS ===== --}}
                <div class="modal-body pb-0">
                    <ul class="nav nav-tabs" id="siswaTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-identitas-link" data-toggle="tab" href="#tab-identitas" role="tab">
                                <i class="fas fa-id-card mr-1"></i> Identitas Pribadi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-riwayat-link" data-toggle="tab" href="#tab-riwayat" role="tab">
                                <i class="fas fa-school mr-1"></i> Riwayat & Asal Sekolah
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-ortu-link" data-toggle="tab" href="#tab-ortu" role="tab">
                                <i class="fas fa-users mr-1"></i> Data Orang Tua & Wali
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content modal-body pt-3" id="siswaTabContent" style="max-height: 65vh; overflow-y: auto;">

                    {{-- ======================== --}}
                    {{-- TAB 1: IDENTITAS PRIBADI --}}
                    {{-- ======================== --}}
                    <div class="tab-pane fade show active" id="tab-identitas" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NISN <span class="text-danger">*</span></label>
                                    <input type="text" name="nisn" class="form-control" maxlength="10" required placeholder="10 digit NISN">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NIS (Lokal)</label>
                                    <input type="text" name="nis" class="form-control" placeholder="NIS sekolah">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" class="form-control" required placeholder="Nama lengkap siswa">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" class="form-control" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="L">Laki-laki (L)</option>
                                        <option value="P">Perempuan (P)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control" placeholder="Kota lahir">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Agama</label>
                                    <select name="agama" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Anak ke-</label>
                                    <input type="number" name="anak_ke" class="form-control" min="1" placeholder="Contoh: 2">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status Keluarga</label>
                                    <select name="status_keluarga" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        <option value="Kandung">Kandung</option>
                                        <option value="Tiri">Tiri</option>
                                        <option value="Angkat">Angkat</option>
                                        <option value="Yatim">Yatim</option>
                                        <option value="Piatu">Piatu</option>
                                        <option value="Yatim Piatu">Yatim Piatu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Telepon Siswa</label>
                                    <input type="text" name="telp_siswa" class="form-control" placeholder="No. HP siswa">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email Siswa</label>
                                    <input type="email" name="email_siswa" class="form-control" placeholder="email@siswa.com">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Daftarkan ke Kelas (Opsional)</label>
                                    <select name="rombel_id" class="form-control">
                                        <option value="">-- Jangan Masukkan Kelas Dulu --</option>
                                        @foreach($rombels as $r)
                                            <option value="{{ $r->id }}">{{ $r->kelas->nama_kelas }} ({{ $r->tahunAkademik->tahun_akademik }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat domisili siswa"></textarea>
                        </div>
                    </div>
                    {{-- END TAB 1 --}}

                    {{-- ================================== --}}
                    {{-- TAB 2: RIWAYAT & ASAL SEKOLAH     --}}
                    {{-- ================================== --}}
                    <div class="tab-pane fade" id="tab-riwayat" role="tabpanel">
                        <p class="text-muted small mb-3"><i class="fas fa-info-circle mr-1"></i> Data riwayat penerimaan di sekolah ini.</p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Diterima di Kelas</label>
                                    <input type="text" name="diterima_di_kelas" class="form-control" placeholder="Contoh: X TKJ 1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Diterima</label>
                                    <input type="date" name="diterima_pada_tanggal" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Diterima Semester</label>
                                    <select name="diterima_semester" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        <option value="Ganjil">Ganjil</option>
                                        <option value="Genap">Genap</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Sekolah Asal</label>
                                    <input type="text" name="asal_sekolah_nama" class="form-control" placeholder="SMP / MTs asal">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Alamat Sekolah Asal</label>
                            <textarea name="asal_sekolah_alamat" class="form-control" rows="2" placeholder="Alamat sekolah asal"></textarea>
                        </div>

                        <hr class="my-3">
                        <p class="font-weight-bold text-secondary small mb-2"><i class="fas fa-file-alt mr-1"></i> Data Ijazah & SKHU</p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tahun Ijazah</label>
                                    <input type="text" name="ijazah_tahun" class="form-control" maxlength="4" placeholder="Contoh: 2023">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor Ijazah</label>
                                    <input type="text" name="ijazah_nomor" class="form-control" placeholder="No. seri ijazah">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tahun SKHU</label>
                                    <input type="text" name="skhu_tahun" class="form-control" maxlength="4" placeholder="Contoh: 2023">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor SKHU</label>
                                    <input type="text" name="skhu_nomor" class="form-control" placeholder="No. seri SKHU">
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- END TAB 2 --}}

                    {{-- ================================== --}}
                    {{-- TAB 3: DATA ORANG TUA & WALI      --}}
                    {{-- ================================== --}}
                    <div class="tab-pane fade" id="tab-ortu" role="tabpanel">

                        {{-- DATA ORANG TUA --}}
                        <div class="d-flex align-items-center mb-3">
                            <div class="border-left border-primary pl-2">
                                <h6 class="mb-0 font-weight-bold text-primary">Data Orang Tua</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Ayah</label>
                                    <input type="text" name="nama_ayah" class="form-control" placeholder="Nama lengkap ayah">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Ibu</label>
                                    <input type="text" name="nama_ibu" class="form-control" placeholder="Nama lengkap ibu">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pekerjaan Ayah</label>
                                    <input type="text" name="pekerjaan_ayah" class="form-control" placeholder="Contoh: Wiraswasta">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pekerjaan Ibu</label>
                                    <input type="text" name="pekerjaan_ibu" class="form-control" placeholder="Contoh: Ibu Rumah Tangga">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Telepon Orang Tua</label>
                                    <input type="text" name="telp_orang_tua" class="form-control" placeholder="No. HP orang tua">
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{-- Kolom kosong, bisa diisi field lain nanti --}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Alamat Orang Tua</label>
                            <textarea name="alamat_orang_tua" class="form-control" rows="2" placeholder="Alamat lengkap orang tua"></textarea>
                        </div>

                        <hr class="my-3">

                        {{-- DATA WALI --}}
                        <div class="d-flex align-items-center mb-3">
                            <div class="border-left border-secondary pl-2">
                                <h6 class="mb-0 font-weight-bold text-secondary">Data Wali <small class="font-weight-normal">(jika ada)</small></h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Wali</label>
                                    <input type="text" name="nama_wali" class="form-control" placeholder="Nama lengkap wali">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pekerjaan Wali</label>
                                    <input type="text" name="pekerjaan_wali" class="form-control" placeholder="Pekerjaan wali">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Telepon Wali</label>
                                    <input type="text" name="telp_wali" class="form-control" placeholder="No. HP wali">
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{-- Kolom kosong --}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Alamat Wali</label>
                            <textarea name="alamat_wali" class="form-control" rows="2" placeholder="Alamat lengkap wali (jika berbeda dengan orang tua)"></textarea>
                        </div>
                    </div>
                    {{-- END TAB 3 --}}

                </div>
                {{-- END TAB CONTENT --}}

                <div class="modal-footer">
                    <small class="text-muted mr-auto">
                        <i class="fas fa-info-circle"></i> Field bertanda <span class="text-danger">*</span> wajib diisi. Field lainnya bisa diisi nanti.
                    </small>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan Data Siswa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

{{-- ===== MODAL IMPORT EXCEL ===== --}}
<div class="modal fade" id="modalImportSiswa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-file-excel mr-2"></i>Import Siswa dari Excel / CSV</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    {{-- Error import --}}
                    @if(session('import_errors'))
                        <div class="alert alert-warning py-2">
                            <strong><i class="fas fa-exclamation-triangle mr-1"></i>Beberapa baris dilewati:</strong>
                            <ul class="mb-0 mt-1 small">
                                @foreach(session('import_errors') as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @error('file_import')
                        <div class="alert alert-danger py-2 small">{{ $message }}</div>
                    @enderror

                    <div class="form-group">
                        <label class="font-weight-bold">Pilih File Excel / CSV</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="fileImport" name="file_import"
                                   accept=".xlsx,.xls,.csv" required>
                            <label class="custom-file-label" for="fileImport">Pilih file...</label>
                        </div>
                        <small class="text-muted">Format: .xlsx, .xls, atau .csv — Maks 5MB</small>
                    </div>

                    <div class="alert alert-light border py-2 mb-0">
                        <p class="font-weight-bold mb-1 small"><i class="fas fa-info-circle text-info mr-1"></i>Format kolom yang diterima:</p>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0 small">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Nama Kolom</th>
                                        <th>Keterangan</th>
                                        <th>Wajib?</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td><code>nisn</code></td><td>10 digit NISN</td><td><span class="badge badge-danger">Wajib</span></td></tr>
                                    <tr><td><code>nis</code></td><td>NIS sekolah</td><td>Opsional</td></tr>
                                    <tr><td><code>nama</code></td><td>Nama lengkap</td><td><span class="badge badge-danger">Wajib</span></td></tr>
                                    <tr><td><code>jenis_kelamin</code></td><td>L atau P</td><td>Opsional</td></tr>
                                    <tr><td><code>tempat_lahir</code></td><td>Kota lahir</td><td>Opsional</td></tr>
                                    <tr><td><code>tanggal_lahir</code></td><td>YYYY-MM-DD</td><td>Opsional</td></tr>
                                    <tr><td><code>alamat</code></td><td>Alamat lengkap</td><td>Opsional</td></tr>
                                    <tr><td><code>status</code></td><td>Aktif / Tidak Aktif</td><td>Opsional</td></tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="mb-0 mt-1 small text-muted">Password default semua siswa yang diimport: <strong>1234</strong></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info" id="btnImport">
                        <i class="fas fa-upload mr-1"></i>Import Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Show filename on file input change
document.getElementById('fileImport').addEventListener('change', function() {
    var fname = this.files[0] ? this.files[0].name : 'Pilih file...';
    this.nextElementSibling.textContent = fname;
});
// Disable button on submit to prevent double click
document.querySelector('#modalImportSiswa form').addEventListener('submit', function() {
    document.getElementById('btnImport').disabled = true;
    document.getElementById('btnImport').innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Memproses...';
});
</script>
