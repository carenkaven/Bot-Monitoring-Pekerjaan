<?php

namespace App\Http\Controllers;

use App\Services\WeeklyPhysicalReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Laporan;
use Carbon\Carbon;

class WeeklyPhysicalPdfController extends Controller
{
    public function weekly(string $minggu, string $proyek, WeeklyPhysicalReportService $service)
    {
        if ($proyek === 'all') {
            $query = Laporan::select('nama_proyek')->distinct();
            if ($minggu === 'custom' && request()->has('start') && request()->has('end')) {
                $query->whereBetween('tanggal', [
                    Carbon::parse(request('start'))->startOfDay(),
                    Carbon::parse(request('end'))->endOfDay()
                ]);
            } elseif (request()->has('year') && request()->has('month')) {
                $query->whereYear('tanggal', request('year'))->whereMonth('tanggal', request('month'));
            }
            $proyekList = $query->pluck('nama_proyek')->sort()->values();
        } else {
            $proyekList = collect([$proyek]);
        }
        
        abort_if($proyekList->isEmpty(), 404, 'Tidak ada proyek ditemukan.');
        
        $projectsData = [];
        foreach ($proyekList as $p) {
            try {
                $projectsData[] = $service->build($minggu, $p);
            } catch (\Exception $e) {
                // skip if no report
            }
        }
        
        abort_if(empty($projectsData), 404, 'Laporan minggu ini tidak ditemukan.');

        if ($proyek === 'all') {
            return Pdf::loadView('pdf.weekly-physical-all', ['projects' => $projectsData])
                ->setPaper('A4', 'landscape')
                ->stream('Laporan-Fisik-Mingguan-Semua-Proyek-Minggu-' . $minggu . '.pdf');
        } else {
            $data = $projectsData[0];
            return Pdf::loadView('pdf.weekly-physical', $data)
                ->setPaper('A4', 'landscape')
                ->stream('Laporan-Fisik-Mingguan-' . $minggu . '.pdf');
        }
    }
}
