<?php

namespace App\Http\Controllers;

use App\Services\WeeklyPhysicalReportService;
use Barryvdh\DomPDF\Facade\Pdf;

class WeeklyPhysicalPdfController extends Controller
{
    public function weekly(string $minggu, string $proyek, WeeklyPhysicalReportService $service)
    {
        $data = $service->build($minggu, $proyek);
        return Pdf::loadView('pdf.weekly-physical', $data)
            ->setPaper('A4', 'landscape')
            ->stream('Laporan-Fisik-Mingguan-' . $minggu . '.pdf');
    }
}
