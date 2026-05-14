@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Profil Saya</h1>
            <p class="mb-0 text-muted small">Kelola informasi akun administrator</p>
        </div>
        <a href="/dashboard-admin" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm mr-1"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="row">

        <!-- Kartu Profil Kiri -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card shadow">
                <div class="card-body text-center py-5">
                    <!-- Avatar Inisial -->
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center"
                         style="width: 100px; height: 100px; border-radius: 50%;
                                background: linear-gradient(135deg, #4e73df, #224abe);
                                font-size: 2.5rem; font-weight: 800; color: #fff;
                                box-shadow: 0 4px 20px rgba(78,115,223,0.4);">
                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                    </div>
                    <h5 class="font-weight-bold mb-1">{{ $admin->name }}</h5>
                    <p class="text-muted small mb-2">{{ $admin->email }}</p>
                    <span class="badge badge-primary px-3 py-1" style="border-radius:50px;">
                        <i class="fas fa-shield-alt mr-1"></i> Administrator
                    </span>

                    <hr>

                    <div class="text-left px-2">
                        <p class="small mb-1 text-muted">
                            <i class="fas fa-calendar-check mr-2 text-primary"></i>
                            <strong>Bergabung:</strong>
                            {{ $admin->created_at ? $admin->created_at->format('d M Y') : '-' }}
                        </p>
                        <p class="small mb-0 text-muted">
                            <i class="fas fa-clock mr-2 text-success"></i>
                            <strong>Terakhir update:</strong>
                            {{ $admin->updated_at ? $admin->updated_at->diffForHumans() : '-' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Edit Profil Kanan -->
        <div class="col-xl-8 col-lg-7">

            <!-- Form Update Data -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-edit mr-2"></i> Edit Informasi Akun
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="font-weight-bold text-sm">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $admin->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold text-sm">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $admin->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">
                        <h6 class="font-weight-bold text-gray-700 mb-3">
                            <i class="fas fa-key mr-2 text-warning"></i> Ganti Password
                            <small class="text-muted font-weight-normal ml-2">(Kosongkan jika tidak ingin mengubah)</small>
                        </h6>

                        <div class="form-group">
                            <label class="font-weight-bold text-sm">Password Baru</label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Minimal 6 karakter">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold text-sm">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation"
                                   class="form-control"
                                   placeholder="Ulangi password baru">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block font-weight-bold">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
