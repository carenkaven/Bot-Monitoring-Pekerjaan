<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Barryvdh\DomPDF\Facade\Pdf;

class DailyNewPdfController extends Controller
{
    public function harian(Laporan $laporan)
    {
        $laporan->load(['materials', 'tenagas', 'alats', 'pekerjaans', 'fotos']);
        return Pdf::loadView('pdf.harian-baru', compact('laporan'))
            ->setPaper('A4', 'portrait')
            ->stream('Laporan-Harian-Baru-' . $laporan->id . '.pdf');
    }
}
