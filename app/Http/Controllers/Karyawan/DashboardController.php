<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard Karyawan: statistik laporan miliknya + 5 laporan terakhir.
     */
    public function index()
    {
        $karyawan = Auth::user()->karyawan;

        if (!$karyawan) {
            abort(403, 'Data karyawan tidak ditemukan.');
        }

        $baseQuery = Laporan::where('karyawan_id', $karyawan->id);

        $totalLaporan = (clone $baseQuery)->count();
        $disetujui    = (clone $baseQuery)->disetujui()->count();
        $menunggu     = (clone $baseQuery)->menunggu()->count();
        $ditolak      = (clone $baseQuery)->ditolak()->count();

        $laporanTerakhir = (clone $baseQuery)
            ->latest('tanggal')
            ->latest('id')
            ->take(5)
            ->get();

        return view('karyawan.dashboard', [
            'karyawan'         => $karyawan,
            'totalLaporan'     => $totalLaporan,
            'disetujui'        => $disetujui,
            'menunggu'         => $menunggu,
            'ditolak'          => $ditolak,
            'laporanTerakhir'  => $laporanTerakhir,
        ]);
    }
}
