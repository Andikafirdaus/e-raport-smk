@extends('layouts.siswa')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Profil Saya</h1>
            <p class="mb-0 text-muted small">Kelola informasi akun dan foto profil</p>
        </div>
    </div>

    <div class="row">

        <!-- Kartu Profil Kiri -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card shadow text-center py-4">
                <!-- Foto Profil -->
                <div class="position-relative d-inline-block mx-auto mb-3" style="width:110px;height:110px;">
                    @if($siswa->foto)
                        <img src="{{ asset('storage/'.$siswa->foto) }}" alt="Foto Profil"
                             id="previewFoto"
                             class="rounded-circle border shadow"
                             style="width:110px;height:110px;object-fit:cover;">
                    @else
                        <div id="avatarInitial"
                             class="rounded-circle d-flex align-items-center justify-content-center mx-auto shadow"
                             style="width:110px;height:110px;background:linear-gradient(135deg,#ef6c00,#e65100);font-size:2.8rem;font-weight:800;color:#fff;">
                            {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                        </div>
                        <img id="previewFoto" src="" alt="Preview"
                             class="rounded-circle border shadow d-none"
                             style="width:110px;height:110px;object-fit:cover;position:absolute;top:0;left:0;">
                    @endif
                    <!-- Badge edit foto -->
                    <label for="fotoInput"
                           class="position-absolute rounded-circle d-flex align-items-center justify-content-center"
                           style="bottom:2px;right:2px;width:32px;height:32px;background:#ef6c00;color:#fff;cursor:pointer;border:2px solid #fff;box-shadow:0 2px 6px rgba(0,0,0,0.2);"
                           title="Ganti Foto">
                        <i class="fas fa-camera fa-xs"></i>
                    </label>
                </div>

                <h5 class="font-weight-bold mb-1">{{ $siswa->nama }}</h5>
                <p class="text-muted small mb-1">NISN: {{ $siswa->nisn }}</p>
                <span class="badge badge-warning px-3 py-1" style="border-radius:50px;">
                    <i class="fas fa-user-graduate mr-1"></i> Siswa
                </span>

                <hr class="mx-4">

                <div class="text-left px-4">
                    <p class="small mb-1 text-muted">
                        <i class="fas fa-id-card mr-2 text-warning"></i>
                        <strong>NIS:</strong> {{ $siswa->nis ?? '-' }}
                    </p>
                    <p class="small mb-1 text-muted">
                        <i class="fas fa-venus-mars mr-2 text-info"></i>
                        <strong>J. Kelamin:</strong> {{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </p>
                    <p class="small mb-0 text-muted">
                        <i class="fas fa-envelope mr-2 text-success"></i>
                        <strong>Email:</strong> {{ $siswa->email ?? '-' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Form Edit Kanan -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="fas fa-user-edit mr-2"></i> Edit Profil
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('siswa.profil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Input file foto (hidden, triggered by kamera badge) -->
                        <input type="file" name="foto" id="fotoInput" accept="image/*" class="d-none">

                        <!-- Nama -->
                        <div class="form-group">
                            <label class="font-weight-bold text-sm">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama"
                                   class="form-control @error('nama') is-invalid @enderror"
                                   value="{{ old('nama', $siswa->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Info read-only -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-sm">NISN</label>
                                    <input type="text" class="form-control bg-light" value="{{ $siswa->nisn }}" readonly>
                                    <small class="text-muted">NISN tidak dapat diubah</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-sm">NIS</label>
                                    <input type="text" class="form-control bg-light" value="{{ $siswa->nis ?? '-' }}" readonly>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h6 class="font-weight-bold text-gray-700 mb-3">
                            <i class="fas fa-key mr-2 text-warning"></i> Ganti Password
                            <small class="text-muted font-weight-normal ml-2">(Kosongkan jika tidak ingin mengubah)</small>
                        </h6>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-sm">Password Baru</label>
                                    <input type="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Minimal 6 karakter">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-sm">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation"
                                           class="form-control"
                                           placeholder="Ulangi password baru">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning btn-block font-weight-bold">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
// Preview foto sebelum upload
document.getElementById('fotoInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(ev) {
        const preview = document.getElementById('previewFoto');
        const avatar  = document.getElementById('avatarInitial');
        preview.src = ev.target.result;
        preview.classList.remove('d-none');
        if (avatar) avatar.classList.add('d-none');
    };
    reader.readAsDataURL(file);
});
</script>
@endsection
