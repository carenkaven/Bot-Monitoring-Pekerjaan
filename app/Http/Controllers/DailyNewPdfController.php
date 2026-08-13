<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Barryvdh\DomPDF\Facade\Pdf;

class DailyNewPdfController extends Controller
{
    public function harian(Laporan $laporan)
    {
        $laporan->load(['materials', 'tenagas', 'alats', 'pekerjaans', 'fotos']);

        // Konversi foto ke base64 agar DomPDF bisa menampilkan gambar
        $fotoBase64 = $laporan->fotos->take(3)->map(function ($foto) {
            $path = storage_path('app/public/' . $foto->foto);
            if (file_exists($path)) {
                $mime = mime_content_type($path);
                return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path));
            }
            return null;
        })->filter()->values();

        return Pdf::loadView('pdf.harian-baru', compact('laporan', 'fotoBase64'))
            ->setPaper('A4', 'portrait')
            ->stream('Laporan-Harian-Baru-' . $laporan->id . '.pdf');
    }
}
