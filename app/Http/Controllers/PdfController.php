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

        // Konversi foto ke base64 agar DomPDF bisa menampilkan gambar
        $fotoBase64 = $laporan->fotos->map(function ($foto) {
            $path = storage_path('app/public/' . $foto->foto);
            if (file_exists($path)) {
                $mime = mime_content_type($path);
                return [
                    'src'         => 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path)),
                    'keterangan'  => $foto->keterangan ?? '',
                ];
            }
            return null;
        })->filter()->values();

        $pdf = Pdf::loadView('pdf.harian', [
            'laporan'    => $laporan,
            'fotoBase64' => $fotoBase64,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan-Harian.pdf');
    }
}