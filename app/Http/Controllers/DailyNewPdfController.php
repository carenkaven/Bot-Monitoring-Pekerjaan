<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Barryvdh\DomPDF\Facade\Pdf;

class DailyNewPdfController extends Controller
{
    public function harian(Laporan $laporan)
    {
        $laporan->load(['materials', 'tenagas', 'alats', 'pekerjaans', 'fotos']);

        // Berikan DomPDF path lokal langsung agar foto tidak berubah menjadi
        // placeholder silang ketika dirender dari data-URI.
        $fotoDokumentasi = $laporan->fotos->take(3)->map(function ($foto) {
            $path = realpath(storage_path('app/public/' . ltrim($foto->foto, '/\\')));
            if (!$path || !is_readable($path)) return null;

            // DomPDF di Windows menerima path lokal C:/...; format file:///C:/...
            // justru dibaca sebagai /C:/... dan menghasilkan placeholder silang.
            return str_replace('\\', '/', $path);
        })->filter()->values();

        return Pdf::loadView('pdf.harian-baru', compact('laporan', 'fotoDokumentasi'))
            ->setOption('chroot', base_path())
            ->setPaper('A4', 'portrait')
            ->stream('Laporan-Harian-Baru-' . $laporan->id . '-' . now()->format('YmdHis') . '.pdf');
    }
}
