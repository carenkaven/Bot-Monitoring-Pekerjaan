<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Traits\RotatesPortraitImages;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    use RotatesPortraitImages;

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

        // Gunakan path lokal yang kompatibel dengan DomPDF di Windows.
        $fotoBase64 = $laporan->fotos->map(function ($foto) {
            $path = realpath(storage_path('app/public/' . ltrim($foto->foto, '/\\')));
            if ($path && is_readable($path)) {
                $this->ensureLandscapeImage($path);
                
                return [
                    'src'         => str_replace('\\', '/', $path),
                    'keterangan'  => $foto->keterangan ?? '',
                ];
            }
            return null;
        })->filter()->values();

        $pdf = Pdf::loadView('pdf.harian', [
            'laporan'    => $laporan,
            'fotoBase64' => $fotoBase64,
        ])->setOption('chroot', base_path())
          ->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan-Harian.pdf');
    }
}
