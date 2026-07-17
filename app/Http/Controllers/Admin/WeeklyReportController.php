<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class WeeklyReportController extends Controller
{
    public function index(Request $request)
    {
        $laporans = Laporan::orderBy('nama_proyek')
            ->orderBy('tanggal')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = strtolower($request->search);

            $laporans = $laporans->filter(function ($item) use ($search) {

                return str_contains(strtolower($item->nama_proyek), $search);

            });

        }

        /*
        |--------------------------------------------------------------------------
        | GROUP BERDASARKAN PROYEK
        |--------------------------------------------------------------------------
        */

        $weeklyReports = [];

        foreach ($laporans->groupBy('nama_proyek') as $namaProyek => $items) {

            $tanggalMulaiProyek = Carbon::parse(

                $items->min('tanggal')

            );

            foreach ($items->groupBy(fn ($laporan) => $this->resolveWeekKey($laporan, $tanggalMulaiProyek)) as $minggu => $laporanMingguan) {

                $key = $namaProyek . '-' . $minggu;

                $weeklyReports[$key] = [

                    'minggu_ke' => $minggu,

                    'nama_proyek' => $namaProyek,

                    'tanggal_mulai' => Carbon::parse($laporanMingguan->min('tanggal')),

                    'tanggal_selesai' => Carbon::parse($laporanMingguan->max('tanggal')),

                    'total_laporan' => $laporanMingguan->count(),

                    'disetujui' => $laporanMingguan->where('status', Laporan::STATUS_DISETUJUI)->count(),

                    'ditolak' => $laporanMingguan->where('status', Laporan::STATUS_DITOLAK)->count(),

                    'menunggu' => $laporanMingguan->where('status', Laporan::STATUS_MENUNGGU)->count(),

                ];

            }

        }

        /*
        |--------------------------------------------------------------------------
        | SORT
        |--------------------------------------------------------------------------
        */

       $weeklyReports = collect($weeklyReports)
    ->sortBy(function ($item) {
        return $item['nama_proyek'].'-'.$this->formatWeekSortKey($item['minggu_ke']);
    })
    ->values();

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $page = LengthAwarePaginator::resolveCurrentPage();

        $perPage = 10;

        $items = $weeklyReports->slice(

            ($page - 1) * $perPage,

            $perPage

        )->values();

        $weeklyReports = new LengthAwarePaginator(

            $items,

            $weeklyReports->count(),

            $perPage,

            $page,

            [

                'path' => request()->url(),

                'query' => request()->query(),

            ]

        );

        return view(

            'weekly.index',

            compact('weeklyReports')

        );
    }

    public function show($minggu, $proyek)
    {
        $laporans = Laporan::with([

            'karyawan',

            'pekerjaans',

            'materials',

            'alats',

            'tenagas',

            'fotos',

            'verifikasi'

        ])
        ->where('nama_proyek', $proyek)
        ->orderBy('tanggal')
        ->get();

        abort_if($laporans->isEmpty(), 404);

        /*
        |--------------------------------------------------------------------------
        | HITUNG MINGGU BERDASARKAN TANGGAL PERTAMA
        |--------------------------------------------------------------------------
        */

        $tanggalMulai = Carbon::parse(

            $laporans->min('tanggal')

        );

        $laporans = $laporans->filter(function ($laporan) use ($tanggalMulai, $minggu) {

            return $this->resolveWeekKey($laporan, $tanggalMulai) === (string) $minggu;

        });

        abort_if($laporans->isEmpty(), 404);

        $awal = Carbon::parse($laporans->min('tanggal'));

        $akhir = Carbon::parse($laporans->max('tanggal'));

        $summary = [

            'minggu_ke' => $minggu,

            'nama_proyek' => $proyek,

            'tanggal_mulai' => $awal,

            'tanggal_selesai' => $akhir,

            'lokasi' => $laporans->first()->lokasi,

            'kontraktor' => $laporans->first()->kontraktor,

            'konsultan' => $laporans->first()->konsultan,

            'pic' => $laporans->first()->pic,

            'kegiatan' => $laporans->first()->kegiatan,

            'sub_kegiatan' => $laporans->first()->sub_kegiatan,

            'total_laporan' => $laporans->count(),

            'disetujui' => $laporans->where('status', Laporan::STATUS_DISETUJUI)->count(),

            'ditolak' => $laporans->where('status', Laporan::STATUS_DITOLAK)->count(),

            'menunggu' => $laporans->where('status', Laporan::STATUS_MENUNGGU)->count(),

        ];

        return view(

            'weekly.show',

            compact(

                'laporans',

                'summary'

            )

        );
    }

    private function resolveWeekKey(Laporan $laporan, Carbon $tanggalMulaiProyek): string
    {
        $mingguKe = trim((string) $laporan->minggu_ke);

        if ($mingguKe !== '') {
            return $mingguKe;
        }

        $hari = $tanggalMulaiProyek->diffInDays(
            Carbon::parse($laporan->tanggal)
        );

        return (string) (floor($hari / 7) + 1);
    }

    private function formatWeekSortKey(string $mingguKe): string
    {
        if (preg_match('/\d+/', $mingguKe, $matches)) {
            return '0-'.str_pad($matches[0], 6, '0', STR_PAD_LEFT).'-'.strtolower($mingguKe);
        }

        return '1-999999-'.strtolower($mingguKe);
    }
}
