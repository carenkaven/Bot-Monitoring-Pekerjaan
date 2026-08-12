<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelController extends Controller
{
    public function harian(Laporan $laporan)
    {
        $laporan->load(['fotos']);

        $book = new Spreadsheet();
        $sheet = $book->getActiveSheet();
        $sheet->setTitle('Laporan Harian');
        $sheet->setShowGridlines(false);

        foreach (['A' => 8, 'B' => 15, 'C' => 15, 'D' => 15, 'E' => 15, 'F' => 15, 'G' => 15, 'H' => 14, 'I' => 14, 'J' => 14] as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $sheet->mergeCells('A1:A4');
        $sheet->mergeCells('B1:J2');
        $sheet->mergeCells('B3:J4');
        $sheet->setCellValue('B1', 'PT RENO ABIRAMA SAKTI');
        $sheet->setCellValue('B3', 'DOKUMENTASI PEKERJAAN HARIAN');
        $this->center($sheet, 'A1:J4');
        $sheet->getStyle('B1')->getFont()->setBold(true)->setSize(18);
        $sheet->getStyle('B3')->getFont()->setBold(true)->setSize(14);
        $this->addImage($sheet, public_path('images/logo-ras.png'), 'A1', 70, 70);

        $sheet->mergeCells('H6:J14');
        $info = [
            'Nama Proyek' => $laporan->nama_proyek,
            'Kegiatan' => $laporan->kegiatan,
            'Sub Kegiatan' => $laporan->sub_kegiatan,
            'Pekerjaan' => $laporan->pekerjaan,
            'Lokasi' => $laporan->lokasi,
            'Kontraktor / Kontraktor Pelaksana' => $laporan->kontraktor,
            'Konsultan' => $laporan->konsultan,
            'Minggu Ke' => $laporan->minggu_ke,
        ];
        $line = 6;
        foreach ($info as $label => $value) {
            $sheet->setCellValue("A{$line}", $label);
            $sheet->setCellValue("B{$line}", ':');
            $sheet->mergeCells("C{$line}:G{$line}");
            $sheet->setCellValue("C{$line}", $value ?? '-');
            $line++;
        }
        $sheet->setCellValue('H6', "KONTRAKTOR / KONTRAKTOR PELAKSANA\n\n" . ($laporan->kontraktor ?? '-'));
        $this->center($sheet, 'H6:J14');
        $sheet->getStyle('H6')->getFont()->setBold(true);
        $this->border($sheet, 'A6:J14');

        $headerRow = 16;
        $sheet->mergeCells("B{$headerRow}:G{$headerRow}");
        $sheet->mergeCells("H{$headerRow}:J{$headerRow}");
        $sheet->setCellValue("A{$headerRow}", 'No');
        $sheet->setCellValue("B{$headerRow}", 'Foto Dokumentasi');
        $sheet->setCellValue("H{$headerRow}", 'Keterangan');
        $sheet->getStyle("A{$headerRow}:J{$headerRow}")->getFont()->setBold(true);
        $sheet->getStyle("A{$headerRow}:J{$headerRow}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('E5E7EB');
        $this->center($sheet, "A{$headerRow}:J{$headerRow}");
        $this->border($sheet, "A{$headerRow}:J{$headerRow}");

        $fotos = $laporan->fotos;
        $rows = $fotos->isEmpty() ? [null] : $fotos;
        foreach ($rows as $index => $foto) {
            $start = $headerRow + 1 + ($index * 14);
            $end = $start + 13;
            $sheet->getRowDimension($start)->setRowHeight(24);
            for ($row = $start + 1; $row <= $end; $row++) {
                $sheet->getRowDimension($row)->setRowHeight(20);
            }
            $sheet->mergeCells("A{$start}:A{$end}");
            $sheet->mergeCells("B{$start}:G{$end}");
            $sheet->mergeCells("H{$start}:J{$end}");
            $sheet->setCellValue("A{$start}", $index + 1);
            $sheet->setCellValue("H{$start}", "Minggu Ke\n" . ($laporan->minggu_ke ?? '-') . "\n\nKETERANGAN\n" . ($foto?->keterangan ?? ($fotos->isEmpty() ? 'Belum ada dokumentasi pekerjaan.' : '-')));
            $sheet->getStyle("H{$start}")->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_TOP);
            $this->center($sheet, "A{$start}:A{$end}");
            $this->border($sheet, "A{$start}:J{$end}");

            if ($foto) {
                $path = public_path('storage/' . $foto->foto);
                if (is_file($path)) {
                    $this->addImage($sheet, $path, "B" . ($start + 1), 430, 235);
                } else {
                    $sheet->setCellValue("B{$start}", 'FOTO TIDAK DITEMUKAN');
                    $this->center($sheet, "B{$start}:G{$end}");
                }
            } else {
                $sheet->setCellValue("B{$start}", 'Belum ada foto dokumentasi');
                $this->center($sheet, "B{$start}:G{$end}");
            }
        }

        $sheet->getPageSetup()->setOrientation('portrait')->setPaperSize('9');
        $sheet->getPageMargins()->setTop(0.25)->setRight(0.25)->setBottom(0.25)->setLeft(0.25);
        $sheet->getPageSetup()->setFitToWidth(1)->setFitToHeight(0);
        $sheet->getPageSetup()->setHorizontalCentered(true);

        $filename = 'Laporan-Harian-' . Str::slug($laporan->nama_proyek) . '-' . $laporan->id . '.xlsx';
        return response()->streamDownload(function () use ($book) {
            (new Xlsx($book))->save('php://output');
        }, $filename, ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);
    }

    private function addImage($sheet, string $path, string $cell, int $width, int $height): void
    {
        if (!is_file($path)) {
            return;
        }
        $drawing = new Drawing();
        $drawing->setPath($path)->setCoordinates($cell)->setWidth($width)->setHeight($height)->setWorksheet($sheet);
    }

    private function border($sheet, string $range): void
    {
        $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setRGB('000000');
    }

    private function center($sheet, string $range): void
    {
        $sheet->getStyle($range)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle($range)->getAlignment()->setWrapText(true);
    }
}
