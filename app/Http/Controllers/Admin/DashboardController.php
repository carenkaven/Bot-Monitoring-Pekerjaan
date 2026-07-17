<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Laporan;
use App\Models\Verifikasi;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLaporan = Laporan::count();
        $menunggu     = Laporan::menunggu()->count();
        $disetujui    = Laporan::disetujui()->count();
        $ditolak      = Laporan::ditolak()->count();

        /* ================ Weekly (7 hari terakhir) ================ */
        $weeklyStart = Carbon::today()->subDays(6);

        $weeklyRaw = Laporan::selectRaw('DATE(tanggal) as d, COUNT(*) as total')
            ->whereBetween('tanggal', [$weeklyStart, Carbon::today()])
            ->groupBy('d')
            ->pluck('total', 'd');

        $weeklyLabels = [];
        $weeklyData   = [];
        for ($i = 0; $i < 7; $i++) {
            $day = $weeklyStart->copy()->addDays($i);
            $weeklyLabels[] = $day->translatedFormat('D d/m');
            $weeklyData[]   = (int) ($weeklyRaw[$day->toDateString()] ?? 0);
        }

        /* ================ Monthly (12 bulan terakhir) ================ */
        $monthStart = Carbon::today()->startOfMonth()->subMonths(11);

        $monthlyRaw = Laporan::selectRaw("DATE_FORMAT(tanggal,'%Y-%m') as m, COUNT(*) as total")
            ->where('tanggal', '>=', $monthStart)
            ->groupBy('m')
            ->pluck('total', 'm');

        $monthlyLabels = [];
        $monthlyData   = [];
        for ($i = 0; $i < 12; $i++) {
            $m = $monthStart->copy()->addMonths($i);
            $monthlyLabels[] = $m->translatedFormat('M Y');
            $monthlyData[]   = (int) ($monthlyRaw[$m->format('Y-m')] ?? 0);
        }

        $laporanTerbaru = Laporan::with('karyawan')
            ->latest('tanggal')
            ->latest('id')
            ->take(6)
            ->get();

        $verifikasiTerbaru = Verifikasi::with(['laporan', 'user'])
            ->latest('tanggal_verifikasi')
            ->take(5)
            ->get();

        return view('dashboard.index', [
            'totalKaryawan'     => Karyawan::count(),
            'totalLaporan'      => $totalLaporan,
            'menunggu'          => $menunggu,
            'disetujui'         => $disetujui,
            'ditolak'           => $ditolak,
            'laporanTerbaru'    => $laporanTerbaru,
            'verifikasiTerbaru' => $verifikasiTerbaru,
            'weeklyLabels'      => $weeklyLabels,
            'weeklyData'        => $weeklyData,
            'monthlyLabels'     => $monthlyLabels,
            'monthlyData'       => $monthlyData,
            'statusChart'       => [$disetujui, $menunggu, $ditolak],
        ]);
    }
}
