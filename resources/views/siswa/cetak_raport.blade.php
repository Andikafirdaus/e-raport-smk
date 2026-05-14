<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raport Siswa - {{ $siswa->nama }}</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Times New Roman',Times,serif; font-size:11pt; color:#000; background:#fff; }
        .page { width:210mm; min-height:297mm; margin:0 auto; padding:15mm 18mm; }

        /* ===== HEADER ===== */
        .header { display:flex; align-items:center; border-bottom:3px double #000; padding-bottom:8px; margin-bottom:12px; }
        .header .logo { width:65px; height:65px; margin-right:12px; flex-shrink:0; }
        .header .logo img { width:100%; height:100%; object-fit:contain; }
        .header .school-info { text-align:center; flex-grow:1; }
        .header .school-info h2 { font-size:14pt; font-weight:900; text-transform:uppercase; margin-bottom:2px; }
        .header .school-info p { font-size:9.5pt; margin:1px 0; }

        /* ===== INFO SISWA TABLE ===== */
        .info-table { width:100%; margin-bottom:12px; border-collapse:collapse; }
        .info-table td { padding:2px 4px; font-size:10.5pt; vertical-align:top; }
        .info-table td:first-child { width:34%; font-weight:bold; }
        .info-table td:nth-child(2) { width:4%; text-align:center; }
        .info-table td.spacer { width:8%; }

        /* ===== SECTION TITLE ===== */
        .section-title { font-size:11pt; font-weight:bold; margin:12px 0 6px; }
        .section-letter { font-size:11pt; }

        /* ===== NILAI TABLE ===== */
        .nilai-table { width:100%; border-collapse:collapse; margin-bottom:10px; font-size:10pt; }
        .nilai-table th, .nilai-table td { border:1px solid #333; padding:4px 5px; text-align:center; vertical-align:middle; }
        .nilai-table th { background:#1a237e; color:#fff; font-weight:bold; font-size:9.5pt; }
        .nilai-table .mapel-col { text-align:left; padding-left:6px; }
        .nilai-table .group-header { background:#d1c4e9; font-weight:bold; font-style:italic; text-align:left; padding-left:8px; }
        .nilai-table tfoot td { background:#e8eaf6; font-weight:bold; }
        .nilai-table .no-col { width:5%; }

        /* ===== GENERAL TABLE ===== */
        .gen-table { width:100%; border-collapse:collapse; margin-bottom:10px; font-size:10pt; }
        .gen-table th, .gen-table td { border:1px solid #666; padding:4px 6px; }
        .gen-table th { background:#f0f0f0; font-weight:bold; text-align:center; }

        /* ===== SIGNATURE ===== */
        .ttd-section { display:flex; justify-content:space-between; margin-top:16px; }
        .ttd-box { text-align:center; }
        .ttd-box .space { height:65px; }
        .ttd-box .garis { border-bottom:1px solid #000; margin-bottom:3px; width:100%; }
        .ttd-box p { font-size:10pt; }
        .ttd-box .nama-ttd { font-weight:bold; text-decoration:underline; font-size:10.5pt; }

        .kota-tanggal { text-align:right; margin-top:12px; font-size:10.5pt; }

        /* ===== CATATAN BOX ===== */
        .catatan-box { border:1px solid #999; padding:8px 10px; min-height:55px; font-size:10.5pt; margin-bottom:10px; line-height:1.7; }

        /* ===== KENAIKAN KELAS ===== */
        .kenaikan-box { border:1px solid #333; padding:8px 12px; font-size:11pt; }
        .kenaikan-box strong { font-size:12pt; }

        /* Print button */
        .print-btn { position:fixed; bottom:20px; right:20px; background:#1a237e; color:#fff; border:none; border-radius:50px; padding:12px 24px; font-size:13px; font-weight:700; cursor:pointer; box-shadow:0 4px 15px rgba(0,0,0,0.3); z-index:999; }
        @media print { .print-btn { display:none !important; } body { background:white; } .page { width:100%; } }
    </style>
</head>
<body>

@php
    $sekolah = 'SMK ARRASYADIYYAH';
    $alamat  = 'Cigedong Kelanggaran Unyur Serang - Banten';
    $kepala  = 'Mathlaul Fajri, S.Pd.I';
    $wali    = $rombel && $rombel->waliKelas ? $rombel->waliKelas->nama_guru : '________________________';
    $nip_wali= $rombel && $rombel->waliKelas ? ($rombel->waliKelas->nip ?? '') : '';
    $kelas   = $rombel ? $rombel->kelas->nama_kelas : '-';
    $jurusan = $rombel && $rombel->kelas->jurusan ? $rombel->kelas->jurusan->nama_jurusan : '-';
    $bidang  = $rombel && $rombel->kelas->jurusan ? $rombel->kelas->jurusan->singkatan : '-';
    $tahun   = $rombel ? $rombel->tahunAkademik->tahun_akademik : '-';
    $semester= $rombel ? $rombel->tahunAkademik->semester : '-';
    $tanggal = 'Serang, ' . \Carbon\Carbon::now()->translatedFormat('d F Y');
@endphp

<div class="page">

    {{-- ===== HEADER SEKOLAH ===== --}}
    <div class="header">
        <div class="logo">
            <img src="{{ asset('img/logo-smk.png') }}" alt="Logo SMK"
                 onerror="this.style.display='none'">
        </div>
        <div class="school-info">
            <h2>{{ $sekolah }}</h2>
            <p>{{ $alamat }}</p>
            <p>NSS: - &nbsp;&nbsp; NPSN: -</p>
        </div>
    </div>

    {{-- ===== INFO SISWA ===== --}}
    <table class="info-table">
        <tr>
            <td>Nama Peserta Didik</td><td>:</td>
            <td><strong>{{ strtoupper($siswa->nama) }}</strong></td>
            <td class="spacer"></td>
            <td style="width:30%;font-weight:bold;">Tahun Pelajaran</td><td style="width:4%;text-align:center;">:</td>
            <td><strong>{{ $tahun }}</strong></td>
        </tr>
        <tr>
            <td>Nomor Induk</td><td>:</td>
            <td>{{ $siswa->nis ?? '0' }}</td>
            <td class="spacer"></td>
            <td style="font-weight:bold;">Bidang Keahlian</td><td style="text-align:center;">:</td>
            <td>{{ $bidang }}</td>
        </tr>
        <tr>
            <td>Nama Sekolah</td><td>:</td>
            <td>{{ $sekolah }}</td>
            <td class="spacer"></td>
            <td style="font-weight:bold;">Program Keahlian</td><td style="text-align:center;">:</td>
            <td>{{ $jurusan }}</td>
        </tr>
        <tr>
            <td>Kelas / Semester</td><td>:</td>
            <td>{{ $kelas }} / {{ strtoupper($semester) }}</td>
        </tr>
    </table>

    {{-- ============================== --}}
    {{-- HALAMAN 1: NILAI AKADEMIK     --}}
    {{-- ============================== --}}
    @if($halaman == 1)

    <div style="text-align:center;font-size:13pt;font-weight:bold;text-decoration:underline;margin-bottom:10px;">
        NILAI DAN DESKRIPSI RAPOR
    </div>

    <p class="section-letter"><strong>A. &nbsp; Nilai Akademik</strong></p>

    <table class="nilai-table" style="margin-top:6px;">
        <thead>
            <tr>
                <th class="no-col" rowspan="2">No.</th>
                <th rowspan="2" style="text-align:left;padding-left:8px;width:35%;">Mata Pelajaran</th>
                <th rowspan="2" style="width:11%;">Pengetahuan</th>
                <th rowspan="2" style="width:11%;">Keterampilan</th>
                <th rowspan="2" style="width:11%;">Nilai Akhir</th>
                <th rowspan="2" style="width:10%;">Predikat</th>
            </tr>
            <tr></tr>
        </thead>
        <tbody>
            {{-- ===== KELOMPOK A: Ambil tepat 6 mapel pertama ===== --}}
            <tr><td colspan="6" class="group-header">A. &nbsp; KELOMPOK A ( WAJIB )</td></tr>
            @php
                $kelompokA = $nilais->take(6);
                $noA = 1;
            @endphp
            @forelse($kelompokA as $n)
            <tr>
                <td>{{ $noA++ }}.</td>
                <td class="mapel-col">{{ $n->nama_mapel }}</td>
                <td>{{ $n->nilai_pengetahuan ?? ($n->uh_1 ?? '-') }}</td>
                <td>{{ $n->nilai_keterampilan ?? ($n->uh_2 ?? '-') }}</td>
                <td><strong>{{ $n->nilai_akhir ?? '-' }}</strong></td>
                <td><strong>{{ $n->predikat ?? '-' }}</strong></td>
            </tr>
            @empty
            @for($i=1;$i<=6;$i++)
            <tr>
                <td>{{ $i }}.</td><td class="mapel-col">&nbsp;</td>
                <td>-</td><td>-</td><td>-</td><td>-</td>
            </tr>
            @endfor
            @endforelse

            {{-- ===== KELOMPOK B: index ke-7 dan ke-8 dari database ===== --}}
            <tr><td colspan="6" class="group-header">B. &nbsp; KELOMPOK B ( WAJIB )</td></tr>
            @php
                $kelompokB = $nilais->slice(6, 2);
                $noB = 1;
            @endphp
            @if($kelompokB->count() > 0)
                @foreach($kelompokB as $n)
                <tr>
                    <td>{{ $noB++ }}.</td>
                    <td class="mapel-col">{{ $n->nama_mapel }}</td>
                    <td>{{ $n->nilai_pengetahuan ?? '-' }}</td>
                    <td>{{ $n->nilai_keterampilan ?? '-' }}</td>
                    <td><strong>{{ $n->nilai_akhir ?? '-' }}</strong></td>
                    <td><strong>{{ $n->predikat ?? '-' }}</strong></td>
                </tr>
                @endforeach
                @for($i = $kelompokB->count() + 1; $i <= 2; $i++)
                <tr><td>{{ $i }}.</td><td class="mapel-col">&nbsp;</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>
                @endfor
            @else
                <tr><td>1.</td><td class="mapel-col">&nbsp;</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>
                <tr><td>2.</td><td class="mapel-col">&nbsp;</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>
            @endif

            {{-- ===== KELOMPOK C: index ke-9 dst ===== --}}
            <tr><td colspan="6" class="group-header">C. &nbsp; KELOMPOK C ( TEORI DASAR KEJURUAN )</td></tr>
            @php $noC = 1; $kelompokC = $nilais->slice(8); @endphp
            @forelse($kelompokC as $n)
            <tr>
                <td>{{ $noC++ }}.</td>
                <td class="mapel-col">{{ $n->nama_mapel }}</td>
                <td>{{ $n->nilai_pengetahuan ?? '-' }}</td>
                <td>{{ $n->nilai_keterampilan ?? '-' }}</td>
                <td><strong>{{ $n->nilai_akhir ?? '-' }}</strong></td>
                <td><strong>{{ $n->predikat ?? '-' }}</strong></td>
            </tr>
            @empty
            @for($i=1;$i<=7;$i++)
            <tr><td>{{ $i }}.</td><td class="mapel-col">&nbsp;</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>
            @endfor
            @endforelse

            <tr><td colspan="6" class="group-header">D. &nbsp; KELOMPOK D ( MULOK )</td></tr>
            <tr>
                <td colspan="3" style="text-align:left;padding-left:8px;">
                    Rata - rata &nbsp;&nbsp;&nbsp;
                    {{ number_format($nilais->avg('nilai_pengetahuan') ?? $nilais->avg('nilai_akhir'), 1) }}
                </td>
                <td>{{ number_format($nilais->avg('nilai_keterampilan') ?? 0, 1) }}</td>
                <td><strong>{{ number_format($nilais->avg('nilai_akhir') ?? 0, 1) }}</strong></td>
                <td><strong>{{ $nilais->avg('nilai_akhir') >= 90 ? 'A' : ($nilais->avg('nilai_akhir') >= 80 ? 'B+' : ($nilais->avg('nilai_akhir') >= 75 ? 'B' : 'C')) }}</strong></td>
            </tr>
            <tr>
                <td colspan="6" style="text-align:left;padding-left:8px;font-size:9.5pt;">
                    Peringkat kelas ke : &nbsp;&nbsp; _____ &nbsp;&nbsp; dari &nbsp;&nbsp; _____ &nbsp;&nbsp; Siswa
                </td>
            </tr>
        </tbody>
    </table>

    <p class="section-letter"><strong>B. &nbsp; Catatan Akademik</strong></p>
    <div class="catatan-box">
        {{ $catatan->catatan ?? 'Ananda perlu meningkatkan kompetensi mata pelajaran yang belum memenuhi standar kompetensi minimal sebagai bekal pembelajaran kompetensi berikutnya.' }}
    </div>

    <div class="kota-tanggal">{{ $tanggal }}</div>
    <div class="ttd-section">
        <div class="ttd-box" style="width:40%;">
            <p>Mengetahui,</p>
            <p>Orang Tua / Wali *</p>
            <div class="space"></div>
            <div class="garis"></div>
            <p>...............................,</p>
        </div>
        <div class="ttd-box" style="width:40%;">
            <p>Wali Kelas</p>
            <div class="space"></div>
            <div class="garis"></div>
            <p class="nama-ttd">{{ $wali }}</p>
            @if($nip_wali)<p style="font-size:9.5pt;">NIP. {{ $nip_wali }}</p>@endif
        </div>
    </div>

    @endif {{-- END HALAMAN 1 --}}


    {{-- ============================== --}}
    {{-- HALAMAN 2: PKL, EKSKUL, ABS   --}}
    {{-- ============================== --}}
    @if($halaman == 2)

    <p class="section-letter"><strong>C. &nbsp; Praktik Kerja Lapangan</strong></p>
    <table class="gen-table">
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th>Mitra DU / DI</th>
                <th width="20%">Lokasi</th>
                <th width="18%">Lamanya (Bulan)</th>
                <th width="20%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @for($i=1;$i<=3;$i++)
            <tr><td class="text-center">{{ $i }}.</td><td>-</td><td>-</td><td style="text-align:center;">-</td><td>-</td></tr>
            @endfor
        </tbody>
    </table>

    <p class="section-letter" style="margin-top:10px;"><strong>D. &nbsp; Ekstrakurikuler</strong></p>
    <table class="gen-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Jenis Kegiatan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @for($i=1;$i<=5;$i++)
            <tr>
                <td class="text-center">{{ $i }}.</td>
                <td>@if($i==1 && $catatan) {{ '-' }} @else - @endif</td>
                <td>-</td>
            </tr>
            @endfor
        </tbody>
    </table>

    <p class="section-letter" style="margin-top:10px;"><strong>E. &nbsp; Ketidakhadiran</strong></p>
    <table class="gen-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="40%">Alasan Ketidakhadiran</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1.</td>
                <td>Sakit</td>
                <td>{{ $catatan->sakit ?? '-' }} hari</td>
            </tr>
            <tr>
                <td class="text-center">2.</td>
                <td>Izin</td>
                <td>{{ $catatan->izin ?? '-' }} hari</td>
            </tr>
            <tr>
                <td class="text-center">3.</td>
                <td>Tanpa Keterangan</td>
                <td>{{ $catatan->alpa ?? '-' }} hari</td>
            </tr>
        </tbody>
    </table>

    <p class="section-letter" style="margin-top:10px;"><strong>F. &nbsp; Kenaikan Kelas</strong></p>
    <div class="kenaikan-box">
        <strong>Naik</strong> &nbsp;&nbsp;&nbsp; ke kelas :
        @php
            $kelasSekarang = $kelas;
            $kelasBerikut  = preg_replace_callback('/\d+/', fn($m) => $m[0]+1, $kelasSekarang);
        @endphp
        {{ $kelasBerikut }}
    </div>

    <div class="kota-tanggal" style="margin-top:14px;">{{ $tanggal }}</div>
    <div class="ttd-section">
        <div class="ttd-box" style="width:38%;">
            <p>Mengetahui,</p>
            <p>Orang Tua / Wali *</p>
            <div class="space"></div>
            <div class="garis"></div>
            <p>...............................,</p>
        </div>
        <div class="ttd-box" style="width:38%;">
            <p>Wali kelas</p>
            <div class="space"></div>
            <div class="garis"></div>
            <p class="nama-ttd">{{ $wali }}</p>
        </div>
    </div>
    <div style="text-align:center; margin-top:20px;">
        <p>Mengetahui</p>
        <p>Kepala {{ $sekolah }}</p>
        <div style="height:60px;"></div>
        <p class="nama-ttd">{{ $kepala }}</p>
    </div>

    @endif {{-- END HALAMAN 2 --}}


    {{-- ============================== --}}
    {{-- HALAMAN 3: KARAKTER           --}}
    {{-- ============================== --}}
    @if($halaman == 3)

    <p class="section-letter"><strong>G. &nbsp; Deskripsi Perkembangan Karakter</strong></p>
    <table class="gen-table" style="margin-top:6px;">
        <thead>
            <tr>
                <th width="25%">Karakter yang dibangun</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Integritas</td>
                <td>Ananda memiliki pola kehidupan kemasyarakatan yang tinggi di lingkungan sekolah.</td>
            </tr>
            <tr>
                <td>Religius</td>
                <td>Ananda menunjukkan ketakwaan pada agama yang dianut dan toleran pada penganut agama yang berbeda.</td>
            </tr>
            <tr>
                <td>Nasionalis</td>
                <td>Ananda bersikap, dan berbuat yang menunjukkan kesetiaan, kepedulian terhadap bahasa Indonesia di sekolah.</td>
            </tr>
            <tr>
                <td>Mandiri</td>
                <td>Ananda sering membantu temannya di lingkungan sekolah.</td>
            </tr>
            <tr>
                <td>Gotong royong</td>
                <td>Ananda menunjukkan sikap gotong-royong sebagai relawan dalam kegiatan kerja sosial.</td>
            </tr>
        </tbody>
    </table>

    <p class="section-letter" style="margin-top:10px;"><strong>H. &nbsp; Catatan Perkembangan Karakter</strong></p>
    <div class="catatan-box">
        {{ $catatan->catatan_karakter ?? 'Ananda menunjukkan perkembangan karakter yang baik pada pembelajaran semester ini, sikap sportif, rendah diri, dan pantang menyerah dalam mengerjakan tugas di sekolah.' }}
    </div>

    <div class="kota-tanggal" style="margin-top:14px;">{{ $tanggal }}</div>
    <div class="ttd-section">
        <div class="ttd-box" style="width:38%;">
            <p>Mengetahui,</p>
            <p>Orang Tua / Wali *</p>
            <div class="space"></div>
            <div class="garis"></div>
            <p>...............................,</p>
        </div>
        <div class="ttd-box" style="width:38%;">
            <p>Wali kelas</p>
            <div class="space"></div>
            <div class="garis"></div>
            <p class="nama-ttd">{{ $wali }}</p>
        </div>
    </div>
    <div style="text-align:center; margin-top:20px;">
        <p>Mengetahui</p>
        <p>Kepala {{ $sekolah }}</p>
        <div style="height:60px;"></div>
        <p class="nama-ttd">{{ $kepala }}</p>
    </div>

    @endif {{-- END HALAMAN 3 --}}

</div>

<button class="print-btn" onclick="window.print()">🖨️ Cetak</button>
</body>
</html>
