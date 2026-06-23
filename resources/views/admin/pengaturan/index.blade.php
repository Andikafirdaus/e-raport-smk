@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Pengaturan Penilaian</h1>
            <p class="page-sub mb-0">Konfigurasi bobot komponen nilai akhir siswa</p>
        </div>
        <a href="/dashboard-admin" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="row">

        {{-- CARD FORM BOBOT --}}
        <div class="col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center">
                    <i class="fas fa-sliders-h text-primary mr-2"></i>
                    <h6 class="m-0 font-weight-bold text-primary">Bobot Komponen Penilaian</h6>
                </div>
                <div class="card-body">

                    {{-- Alert jika total tidak 100 --}}
                    @php
                        $total = $bobotUh + $bobotPts + $bobotPas;
                    @endphp
                    @if($total != 100)
                    <div class="alert alert-warning py-2">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Perhatian!</strong> Total bobot saat ini = <strong>{{ $total }}%</strong>.
                        Total bobot harus tepat <strong>100%</strong> agar perhitungan nilai akurat.
                    </div>
                    @endif

                    <form action="{{ route('pengaturan.update') }}" method="POST" id="formBobot">
                        @csrf

                        <div class="row">
                            {{-- Bobot UH --}}
                            <div class="col-md-4">
                                <div class="form-group text-center">
                                    <label class="font-weight-bold d-block mb-2">
                                        <i class="fas fa-pencil-alt text-info mr-1"></i>
                                        Rata-rata UH
                                    </label>
                                    <div class="input-group">
                                        <input type="number"
                                               name="bobot_uh"
                                               id="bobot_uh"
                                               class="form-control form-control-lg text-center font-weight-bold @error('bobot_uh') is-invalid @enderror"
                                               value="{{ old('bobot_uh', $bobotUh) }}"
                                               min="0" max="100" required
                                               oninput="hitungTotal()">
                                        <div class="input-group-append">
                                            <span class="input-group-text font-weight-bold">%</span>
                                        </div>
                                    </div>
                                    <small class="text-muted">Ulangan Harian 1–5</small>
                                    @error('bobot_uh')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Bobot PTS --}}
                            <div class="col-md-4">
                                <div class="form-group text-center">
                                    <label class="font-weight-bold d-block mb-2">
                                        <i class="fas fa-file-alt text-warning mr-1"></i>
                                        PTS
                                    </label>
                                    <div class="input-group">
                                        <input type="number"
                                               name="bobot_pts"
                                               id="bobot_pts"
                                               class="form-control form-control-lg text-center font-weight-bold @error('bobot_pts') is-invalid @enderror"
                                               value="{{ old('bobot_pts', $bobotPts) }}"
                                               min="0" max="100" required
                                               oninput="hitungTotal()">
                                        <div class="input-group-append">
                                            <span class="input-group-text font-weight-bold">%</span>
                                        </div>
                                    </div>
                                    <small class="text-muted">Penilaian Tengah Semester</small>
                                    @error('bobot_pts')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Bobot PAS --}}
                            <div class="col-md-4">
                                <div class="form-group text-center">
                                    <label class="font-weight-bold d-block mb-2">
                                        <i class="fas fa-clipboard-check text-success mr-1"></i>
                                        PAS
                                    </label>
                                    <div class="input-group">
                                        <input type="number"
                                               name="bobot_pas"
                                               id="bobot_pas"
                                               class="form-control form-control-lg text-center font-weight-bold @error('bobot_pas') is-invalid @enderror"
                                               value="{{ old('bobot_pas', $bobotPas) }}"
                                               min="0" max="100" required
                                               oninput="hitungTotal()">
                                        <div class="input-group-append">
                                            <span class="input-group-text font-weight-bold">%</span>
                                        </div>
                                    </div>
                                    <small class="text-muted">Penilaian Akhir Semester</small>
                                    @error('bobot_pas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Total Indicator --}}
                        <div class="text-center my-3">
                            <div class="d-inline-flex align-items-center px-4 py-2 rounded-pill" id="totalBadge"
                                 style="background: #e8f2fc; border: 2px solid #1e3a5f;">
                                <span class="font-weight-bold mr-2">Total Bobot:</span>
                                <span class="font-weight-bold h5 mb-0" id="totalDisplay">{{ $total }}%</span>
                                <i class="ml-2" id="totalIcon"></i>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary px-5" id="btnSimpan">
                                <i class="fas fa-save mr-2"></i> Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- CARD INFO FORMULA --}}
        <div class="col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calculator mr-2"></i> Formula Perhitungan Nilai
                    </h6>
                </div>
                <div class="card-body">
                    <div class="bg-light p-3 rounded mb-3" style="font-family: monospace; font-size: 0.82rem; line-height: 1.9;">
                        <div><span class="text-muted">// Langkah 1: Rata-rata UH Dinamis</span></div>
                        <div><strong>Rata_UH</strong> = <span class="text-info">SUM(UH yang terisi)</span> / <span class="text-info">COUNT(UH yang terisi)</span></div>
                        <br>
                        <div><span class="text-muted">// Langkah 2: Nilai Pengetahuan</span></div>
                        <div><strong>N.Pengetahuan</strong> = (Rata_UH × <span class="text-warning" id="preview_uh">{{ $bobotUh }}</span>%)</div>
                        <div class="pl-4">+ (PTS × <span class="text-warning" id="preview_pts">{{ $bobotPts }}</span>%)</div>
                        <div class="pl-4">+ (PAS × <span class="text-warning" id="preview_pas">{{ $bobotPas }}</span>%)</div>
                        <br>
                        <div><span class="text-muted">// Langkah 3: Remedial (jika ada)</span></div>
                        <div class="text-danger">IF N.Pengetahuan &lt; KKM:</div>
                        <div class="pl-4">IF Remedial ≥ KKM → N.Pengetahuan = <strong>KKM</strong></div>
                        <br>
                        <div><span class="text-muted">// Langkah 4: Nilai Akhir</span></div>
                        <div><strong>N.Akhir</strong> = (N.Pengetahuan + N.Keterampilan) / 2</div>
                    </div>

                    <p class="font-weight-bold small mb-2">Tabel Predikat:</p>
                    <table class="table table-sm table-bordered small mb-0">
                        <thead class="thead-dark">
                            <tr><th>Rentang Nilai</th><th class="text-center">Predikat</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>N &gt; 95</td><td class="text-center font-weight-bold">A+</td></tr>
                            <tr><td>90 &lt; N ≤ 95</td><td class="text-center font-weight-bold">A</td></tr>
                            <tr><td>85 &lt; N ≤ 90</td><td class="text-center font-weight-bold">A-</td></tr>
                            <tr><td>80 &lt; N ≤ 85</td><td class="text-center font-weight-bold">B+</td></tr>
                            <tr><td>75 &lt; N ≤ 80</td><td class="text-center font-weight-bold">B</td></tr>
                            <tr><td>70 &lt; N ≤ 75</td><td class="text-center font-weight-bold">B-</td></tr>
                            <tr><td>65 ≤ N ≤ 70</td><td class="text-center font-weight-bold">C</td></tr>
                            <tr><td>N &lt; 65</td><td class="text-center font-weight-bold text-danger">D</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function hitungTotal() {
    const uh  = parseInt(document.getElementById('bobot_uh').value) || 0;
    const pts = parseInt(document.getElementById('bobot_pts').value) || 0;
    const pas = parseInt(document.getElementById('bobot_pas').value) || 0;
    const total = uh + pts + pas;

    document.getElementById('totalDisplay').textContent = total + '%';
    document.getElementById('preview_uh').textContent  = uh;
    document.getElementById('preview_pts').textContent = pts;
    document.getElementById('preview_pas').textContent = pas;

    const badge = document.getElementById('totalBadge');
    const icon  = document.getElementById('totalIcon');
    const btn   = document.getElementById('btnSimpan');

    if (total === 100) {
        badge.style.background    = '#d4edda';
        badge.style.borderColor   = '#28a745';
        document.getElementById('totalDisplay').style.color = '#155724';
        icon.className = 'fas fa-check-circle text-success ml-2';
        btn.disabled   = false;
    } else {
        badge.style.background    = '#fff3cd';
        badge.style.borderColor   = '#ffc107';
        document.getElementById('totalDisplay').style.color = '#856404';
        icon.className = 'fas fa-exclamation-triangle text-warning ml-2';
        btn.disabled   = true;
    }
}
// Jalankan sekali saat halaman load
hitungTotal();
</script>
@endsection
