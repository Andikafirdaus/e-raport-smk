<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Rombel;
use Illuminate\Support\Facades\Hash;

class SiswaImportController extends Controller
{
    /**
     * Import data siswa dari file Excel (.xlsx) atau CSV (.csv)
     */
    public function import(Request $request)
    {
        $request->validate([
            'file_import' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ], [
            'file_import.required' => 'Pilih file terlebih dahulu.',
            'file_import.mimes'    => 'Format file harus .xlsx, .xls, atau .csv.',
            'file_import.max'      => 'Ukuran file maksimal 5MB.',
        ]);

        $file      = $request->file('file_import');
        $extension = strtolower($file->getClientOriginalExtension());
        $rows      = [];

        try {
            if ($extension === 'csv') {
                $rows = $this->parseCsv($file->getRealPath());
            } else {
                $rows = $this->parseXlsx($file->getRealPath());
            }
        } catch (\Throwable $e) {
            return back()->withErrors(['file_import' => 'Gagal membaca file: ' . $e->getMessage()]);
        }

        if (empty($rows)) {
            return back()->withErrors(['file_import' => 'File kosong atau format kolom tidak sesuai.']);
        }

        $berhasil  = 0;
        $dilewati  = 0;
        $errorList = [];

        foreach ($rows as $i => $row) {
            $baris = $i + 2;

            $nisn  = trim((string)($row['nisn']  ?? $row['NISN']  ?? ''));
            $nis   = trim((string)($row['nis']   ?? $row['NIS']   ?? ''));
            $nama  = trim((string)($row['nama']  ?? $row['NAMA']  ?? ''));
            $jk    = strtoupper(trim((string)($row['jenis_kelamin'] ?? $row['jk'] ?? $row['JK'] ?? '')));

            if (!$nisn || !$nama) {
                $errorList[] = "Baris {$baris}: NISN atau Nama kosong, dilewati.";
                $dilewati++;
                continue;
            }

            if (in_array($jk, ['L', 'LAKI', 'LAKI-LAKI'])) $jk = 'L';
            elseif (in_array($jk, ['P', 'PEREMPUAN', 'WANITA'])) $jk = 'P';
            else $jk = 'L';

            if (Siswa::where('nisn', $nisn)->exists()) {
                $errorList[] = "Baris {$baris}: NISN {$nisn} sudah ada, dilewati.";
                $dilewati++;
                continue;
            }

            try {
                $tglLahir = $this->parseDate((string)($row['tanggal_lahir'] ?? ''));
                $data = [
                    'nisn'          => $nisn,
                    'nis'           => $nis ?: $nisn,
                    'nama'          => $nama,
                    'jenis_kelamin' => $jk,
                    'tempat_lahir'  => trim((string)($row['tempat_lahir'] ?? '')),
                    'tanggal_lahir' => $tglLahir,
                    'alamat'        => trim((string)($row['alamat'] ?? '')),
                    'status'        => trim((string)($row['status'] ?? 'Aktif')) ?: 'Aktif',
                    'password'      => Hash::make('1234'),
                ];

                $siswa = Siswa::create($data);

                $rombelId = trim((string)($row['rombel_id'] ?? ''));
                if ($rombelId && Rombel::find($rombelId)) {
                    $siswa->rombels()->attach($rombelId);
                }
                $berhasil++;
            } catch (\Throwable $e) {
                $errorList[] = "Baris {$baris}: Gagal ({$e->getMessage()}).";
                $dilewati++;
            }
        }

        $msg = "Import selesai: {$berhasil} siswa berhasil ditambahkan";
        if ($dilewati > 0) $msg .= ", {$dilewati} baris dilewati";
        $msg .= ". Password default: 1234";

        if (!empty($errorList)) {
            $request->session()->flash('import_errors', array_slice($errorList, 0, 10));
        }

        return redirect()->route('siswa.index')->with('success', $msg);
    }

    /** Parse CSV file murni PHP — tidak butuh library eksternal */
    private function parseCsv(string $path): array
    {
        $rows   = [];
        $header = null;
        $handle = fopen($path, 'r');
        // Detect BOM UTF-8
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") rewind($handle);

        // Try semicolon vs comma delimiter
        $firstLine = fgets($handle);
        rewind($handle);
        $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';

        while (($line = fgetcsv($handle, 2000, $delimiter)) !== false) {
            if (!$header) {
                $header = array_map(fn($h) => strtolower(trim($h)), $line);
                continue;
            }
            if (empty(array_filter($line))) continue;
            $rows[] = array_combine($header, array_pad($line, count($header), ''));
        }
        fclose($handle);
        return $rows;
    }

    /** Parse XLSX menggunakan PhpSpreadsheet */
    private function parseXlsx(string $path): array
    {
        if (!class_exists(\PhpOffice\PhpSpreadsheet\IOFactory::class)) {
            throw new \RuntimeException('Library PhpSpreadsheet tidak tersedia. Gunakan format .csv.');
        }

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($path);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($path);
        $sheet       = $spreadsheet->getActiveSheet();
        $data        = $sheet->toArray(null, true, true, false);

        $rows   = [];
        $header = null;
        foreach ($data as $row) {
            $isEmpty = empty(array_filter($row, fn($v) => $v !== null && $v !== ''));
            if (!$header) {
                if ($isEmpty) continue;
                $header = array_map(fn($h) => strtolower(trim((string)($h ?? ''))), $row);
                continue;
            }
            if ($isEmpty) continue;
            $rows[] = array_combine($header, array_pad($row, count($header), ''));
        }
        return $rows;
    }

    private function parseDate(string $val): ?string
    {
        $val = trim($val);
        if (!$val) return null;
        foreach (['Y-m-d', 'd/m/Y', 'd-m-Y', 'm/d/Y', 'Y/m/d', 'd/m/y'] as $fmt) {
            $d = \DateTime::createFromFormat($fmt, $val);
            if ($d) return $d->format('Y-m-d');
        }
        // Handle Excel serial date
        if (is_numeric($val) && class_exists(\PhpOffice\PhpSpreadsheet\Shared\Date::class)) {
            try {
                $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float)$val);
                return $date->format('Y-m-d');
            } catch (\Throwable $e) {}
        }
        return null;
    }
}
