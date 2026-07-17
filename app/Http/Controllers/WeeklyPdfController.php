<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class WeeklyPdfController extends Controller
{
    public function weekly($minggu, $proyek)
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL SELURUH LAPORAN PROYEK
        |--------------------------------------------------------------------------
        */

        $semuaLaporan = Laporan::with([

            'karyawan',
            'pekerjaans',
            'tenagas',
            'materials',
            'alats',
            'fotos',
            'verifikasi.user',

        ])

        ->where('nama_proyek', $proyek)

        ->orderBy('tanggal')

        ->get();

        abort_if(

            $semuaLaporan->isEmpty(),

            404,

            'Laporan proyek tidak ditemukan.'

        );

        /*
        |--------------------------------------------------------------------------
        | HITUNG TANGGAL MULAI PROYEK
        |--------------------------------------------------------------------------
        */

        $tanggalMulaiProyek = Carbon::parse(

            $semuaLaporan->min('tanggal')

        );

        /*
        |--------------------------------------------------------------------------
        | FILTER BERDASARKAN MINGGU
        |--------------------------------------------------------------------------
        */

        $laporans = $semuaLaporan->filter(function ($laporan) use (

            $tanggalMulaiProyek,

            $minggu

        ) {
            return $this->resolveWeekKey($laporan, $tanggalMulaiProyek) === (string) $minggu;

        })->values();

        abort_if(

            $laporans->isEmpty(),

            404,

            'Laporan minggu ini tidak ditemukan.'

        );

        /*
        |--------------------------------------------------------------------------
        | PERIODE MINGGU
        |--------------------------------------------------------------------------
        */

        $tanggalMulai = Carbon::parse($laporans->min('tanggal'));

        $tanggalSelesai = Carbon::parse($laporans->max('tanggal'));

        $laporanPertama = $laporans->first();

        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

        $summary = [

            'minggu_ke'       => $minggu,

            'nama_proyek'     => $proyek,

            'kegiatan'        => $laporanPertama->kegiatan,

            'sub_kegiatan'    => $laporanPertama->sub_kegiatan,

            'lokasi'          => $laporanPertama->lokasi,

            'kontraktor'      => $laporanPertama->kontraktor,

            'konsultan'       => $laporanPertama->konsultan,

            'pic'             => $laporanPertama->pic,

            'tanggal_mulai'   => $tanggalMulai,

            'tanggal_selesai' => $tanggalSelesai,

            'total_laporan'   => $laporans->count(),

            'disetujui' => $laporans
                ->where('status', Laporan::STATUS_DISETUJUI)
                ->count(),

            'ditolak' => $laporans
                ->where('status', Laporan::STATUS_DITOLAK)
                ->count(),

            'menunggu' => $laporans
                ->where('status', Laporan::STATUS_MENUNGGU)
                ->count(),

        ];

        /*
        |--------------------------------------------------------------------------
        | REKAP MATERIAL
        |--------------------------------------------------------------------------
        */
                /*
        |--------------------------------------------------------------------------
        | REKAP MATERIAL
        |--------------------------------------------------------------------------
        */

        $materials = [];

        foreach ($laporans as $laporan) {

            foreach ($laporan->materials as $material) {

                $nama = trim($material->nama_material);

                if (!isset($materials[$nama])) {

                    $materials[$nama] = [

                        'nama_material' => $nama,

                        'volume' => 0,

                        'satuan' => $material->satuan,

                    ];

                }

                $materials[$nama]['volume'] += (float) $material->volume;

            }

        }

        $materials = collect($materials)->values();

        /*
        |--------------------------------------------------------------------------
        | REKAP ALAT
        |--------------------------------------------------------------------------
        */

        $alats = [];

        foreach ($laporans as $laporan) {

            foreach ($laporan->alats as $alat) {

                $nama = trim($alat->nama_alat);

                if (!isset($alats[$nama])) {

                    $alats[$nama] = [

                        'nama_alat' => $nama,

                        'jumlah' => 0,

                    ];

                }

                $alats[$nama]['jumlah'] += (int) $alat->jumlah;

            }

        }

        $alats = collect($alats)->values();

        /*
        |--------------------------------------------------------------------------
        | REKAP TENAGA
        |--------------------------------------------------------------------------
        */

        $tenagas = [

            'Pekerja'   => 0,

            'Tukang'    => 0,

            'Mandor'    => 0,

            'Pelaksana' => 0,

        ];

        foreach ($laporans as $laporan) {

            foreach ($laporan->tenagas as $tenaga) {

                $tenagas['Pekerja'] += (int) $tenaga->pekerja;

                $tenagas['Tukang'] += (int) $tenaga->tukang;

                $tenagas['Mandor'] += (int) $tenaga->mandor;

                $tenagas['Pelaksana'] += (int) $tenaga->pelaksana;

            }

        }

        /*
        |--------------------------------------------------------------------------
        | REKAP PEKERJAAN
        |--------------------------------------------------------------------------
        */
                /*
        |--------------------------------------------------------------------------
        | REKAP PEKERJAAN
        |--------------------------------------------------------------------------
        */

        $pekerjaans = [];

        foreach ($laporans as $laporan) {

            foreach ($laporan->pekerjaans as $pekerjaan) {

                $nama = trim($pekerjaan->nama_pekerjaan);

                if (!isset($pekerjaans[$nama])) {

                    $pekerjaans[$nama] = [

                        'nama_pekerjaan' => $nama,

                        'jumlah' => 0,

                    ];

                }

                $pekerjaans[$nama]['jumlah']++;

            }

        }

        $pekerjaans = collect($pekerjaans)->values();

        /*
        |--------------------------------------------------------------------------
        | FOTO DOKUMENTASI
        |--------------------------------------------------------------------------
        */

        $fotos = collect();

        foreach ($laporans as $laporan) {

            foreach ($laporan->fotos as $foto) {

                $fotos->push($foto);

            }

        }

        /*
        |--------------------------------------------------------------------------
        | GENERATE PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(

            'pdf.weekly',

            [

                'summary'     => $summary,

                'laporans'    => $laporans,

                'materials'   => $materials,

                'alats'       => $alats,

                'tenagas'     => $tenagas,

                'pekerjaans'  => $pekerjaans,

                'fotos'       => $fotos,

            ]

        )->setPaper('A4', 'portrait');

        return $pdf->stream(

            'Laporan-Mingguan-' .

            $summary['nama_proyek'] .

            '-Minggu-' .

            $summary['minggu_ke'] .

            '.pdf'

        );

    }

    private function resolveWeekKey(Laporan $laporan, Carbon $tanggalMulaiProyek): string
    {
        $mingguKe = trim((string) $laporan->minggu_ke);

        if ($mingguKe !== '') {
            return $mingguKe;
        }

        $selisihHari = $tanggalMulaiProyek->diffInDays(
            Carbon::parse($laporan->tanggal)
        );

        return (string) (floor($selisihHari / 7) + 1);
    }

}
