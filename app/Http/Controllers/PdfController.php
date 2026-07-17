<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function harian(Laporan $laporan)
    {
        $laporan->load([
            'karyawan',
            'fotos',
            'materials',
            'alats',
            'tenagas',
            'pekerjaans',
        ]);

        $pdf = Pdf::loadView('pdf.harian', [
            'laporan' => $laporan
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan-Harian.pdf');
    }
}