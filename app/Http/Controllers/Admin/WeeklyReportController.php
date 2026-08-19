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
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));

        $laporans = Laporan::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->get();

        $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth()->day;

        $weeks = [
            1 => ['start' => 1, 'end' => 7, 'count' => 0],
            2 => ['start' => 8, 'end' => 14, 'count' => 0],
            3 => ['start' => 15, 'end' => 21, 'count' => 0],
            4 => ['start' => 22, 'end' => 28, 'count' => 0],
        ];

        if ($endOfMonth > 28) {
            $weeks[5] = ['start' => 29, 'end' => $endOfMonth, 'count' => 0];
        }

        foreach ($laporans as $lap) {
            $day = (int) Carbon::parse($lap->tanggal)->format('d');
            if ($day <= 7) $weeks[1]['count']++;
            elseif ($day <= 14) $weeks[2]['count']++;
            elseif ($day <= 21) $weeks[3]['count']++;
            elseif ($day <= 28) $weeks[4]['count']++;
            else if (isset($weeks[5])) $weeks[5]['count']++;
        }
        $proyeks = Laporan::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->select('nama_proyek')
            ->distinct()
            ->pluck('nama_proyek');

        return view('weekly.index', compact('year', 'month', 'weeks', 'proyeks'));
    }

    public function show(Request $request, $minggu, $proyek)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));

        $query = Laporan::with([
            'karyawan',
            'pekerjaans',
            'materials',
            'alats',
            'tenagas',
            'fotos',
            'verifikasi'
        ])
        ->whereYear('tanggal', $year)
        ->whereMonth('tanggal', $month);

        if ($proyek !== 'all') {
            $query->where('nama_proyek', $proyek);
        }

        $laporans = $query->orderBy('tanggal', 'desc')->orderBy('nama_proyek', 'asc')->get();

        $laporans = $laporans->filter(function ($laporan) use ($minggu) {
            $day = (int) Carbon::parse($laporan->tanggal)->format('d');
            if ($minggu == 1) return $day >= 1 && $day <= 7;
            if ($minggu == 2) return $day >= 8 && $day <= 14;
            if ($minggu == 3) return $day >= 15 && $day <= 21;
            if ($minggu == 4) return $day >= 22 && $day <= 28;
            if ($minggu == 5) return $day >= 29;
            return false;
        });

        abort_if($laporans->isEmpty(), 404, 'Tidak ada laporan pada minggu ini.');

        $awal = Carbon::parse($laporans->min('tanggal'));
        $akhir = Carbon::parse($laporans->max('tanggal'));

        $summary = [
            'minggu_ke' => $minggu,
            'nama_proyek' => $proyek,
            'tanggal_mulai' => $awal,
            'tanggal_selesai' => $akhir,
            'tahun_anggaran' => $awal->format('Y'),
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

        $rekapFisik = [];
        if ($proyek !== 'all') {
            $physicalService = new \App\Services\WeeklyPhysicalReportService();
            try {
                $physicalData = $physicalService->build($minggu, $proyek);
                $rekapFisik = $physicalData['rows'];
            } catch (\Exception $e) {
                // Biarkan kosong jika tidak dapat ditarik
            }
        }
        $proyeks = Laporan::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->select('nama_proyek')
            ->distinct()
            ->pluck('nama_proyek');

        return view('weekly.show', compact('laporans', 'summary', 'rekapFisik', 'year', 'month', 'proyeks'));
    }
}
