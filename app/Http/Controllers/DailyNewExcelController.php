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

class DailyNewExcelController extends Controller
{
    public function harian(Laporan $laporan)
    {
        $laporan->load(['materials', 'tenagas', 'alats', 'pekerjaans', 'fotos']);

        $book = new Spreadsheet();
        $sheet = $book->getActiveSheet();
        $sheet->setTitle('Laporan Harian Baru');
        $sheet->setShowGridlines(false);

        foreach (['A' => 5, 'B' => 22, 'C' => 9, 'D' => 8, 'E' => 10, 'F' => 10, 'G' => 13, 'H' => 13] as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        // Header dan identitas laporan.
        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1', 'LAPORAN HARIAN');
        $sheet->getRowDimension(1)->setRowHeight(20);
        $this->header($sheet, 'A1:H1', true);

        $sheet->mergeCells('A2:H7');
        $sheet->setCellValue('A2', implode("\n", [
            'Pekerjaan       : ' . ($laporan->pekerjaan ?: '-'),
            'Lokasi             : ' . ($laporan->lokasi ?: '-'),
            'Tahun Anggaran : ' . (optional($laporan->tanggal)->format('Y') ?: date('Y')),
            'Minggu Ke       : ' . ($laporan->minggu_ke ?: '-'),
            'Periode            : ' . (optional($laporan->tanggal)->format('d F Y') ?: '-'),
            'Tanggal            : ' . (optional($laporan->tanggal)->format('d F Y') ?: '-'),
        ]));
        $this->wrap($sheet, 'A2:H7', Alignment::HORIZONTAL_LEFT);
        $this->border($sheet, 'A2:H7');

        // Pekerjaan yang dilakukan: selalu 10 baris seperti PDF.
        $row = 9;
        $sheet->mergeCells("A{$row}:H{$row}");
        $sheet->setCellValue("A{$row}", 'PEKERJAAN YANG DILAKUKAN');
        $this->header($sheet, "A{$row}:H{$row}");
        $items = $laporan->pekerjaans->pluck('nama_pekerjaan')->prepend($laporan->pekerjaan)->filter()->unique()->values();
        for ($i = 0; $i < 10; $i++) {
            $row++;
            $sheet->setCellValue("A{$row}", $i + 1);
            $sheet->mergeCells("B{$row}:H{$row}");
            $sheet->setCellValue("B{$row}", $items[$i] ?? '');
            $sheet->getRowDimension($row)->setRowHeight(13);
        }
        $this->center($sheet, "A10:A{$row}");
        $this->border($sheet, "A10:H{$row}");

        // Material: 11 baris seperti PDF.
        $row += 2;
        $sheet->mergeCells("A{$row}:H{$row}");
        $sheet->setCellValue("A{$row}", 'BAHAN / MATERIAL');
        $this->header($sheet, "A{$row}:H{$row}");
        $row++;
        $sheet->fromArray([['NO.', 'NAMA BAHAN', 'VOL.', 'SAT.', 'DITERIMA', 'DITOLAK', 'KETERANGAN', '']], null, "A{$row}");
        $sheet->mergeCells("G{$row}:H{$row}");
        $this->header($sheet, "A{$row}:H{$row}");
        $materialHeader = $row;
        for ($i = 0; $i < 11; $i++) {
            $row++;
            $material = $laporan->materials[$i] ?? null;
            $sheet->fromArray([[$i + 1, $material->nama_material ?? '', $material->volume ?? '', $material->satuan ?? '', '', '', '', '']], null, "A{$row}");
            $sheet->mergeCells("G{$row}:H{$row}");
            $sheet->getRowDimension($row)->setRowHeight(13);
        }
        $this->center($sheet, "A{$materialHeader}:F{$row}");
        $this->border($sheet, "A{$materialHeader}:H{$row}");

        // Tenaga kerja dan alat: dua tabel berdampingan.
        $row += 2;
        $sheet->mergeCells("A{$row}:D{$row}");
        $sheet->mergeCells("E{$row}:H{$row}");
        $sheet->setCellValue("A{$row}", 'TENAGA KERJA');
        $sheet->setCellValue("E{$row}", 'ALAT');
        $this->header($sheet, "A{$row}:H{$row}");
        $row++;
        $sheet->fromArray([['NO.', 'MACAM TENAGA KERJA', 'JUMLAH', 'SAT.', 'NO.', 'NAMA ALAT', 'JUMLAH', 'SATUAN']], null, "A{$row}");
        $this->header($sheet, "A{$row}:H{$row}");
        $peopleHeader = $row;
        for ($i = 0; $i < 10; $i++) {
            $row++;
            $tenaga = $laporan->tenagas[$i] ?? null;
            $alat = $laporan->alats[$i] ?? null;
            $sheet->fromArray([[$i + 1, $tenaga ? 'Pekerja' : '', $tenaga->pekerja ?? '', $tenaga ? 'org' : '', $i + 1, $alat->nama_alat ?? '', $alat->jumlah ?? '', $alat ? 'unit' : '']], null, "A{$row}");
            $sheet->getRowDimension($row)->setRowHeight(13);
        }
        $this->border($sheet, "A{$peopleHeader}:H{$row}");
        $this->center($sheet, "A{$peopleHeader}:H{$row}");

        // Waktu di kiri, notasi dan foto maksimal 3 di kanan.
        $row += 2;
        $timeTop = $row;
        $sheet->mergeCells("A{$row}:C{$row}");
        $sheet->mergeCells("D{$row}:E{$row}");
        $sheet->setCellValue("A{$row}", 'WAKTU');
        $sheet->setCellValue("D{$row}", 'JAM KERJA');
        $sheet->setCellValue("F{$row}", 'CUACA');
        $sheet->mergeCells("F{$row}:H{$row}");
        $this->header($sheet, "A{$row}:H{$row}");
        for ($hour = 0; $hour < 24; $hour++) {
            $row++;
            $sheet->mergeCells("A{$row}:C{$row}");
            $sheet->mergeCells("D{$row}:E{$row}");
            $sheet->mergeCells("F{$row}:H{$row}");
            $sheet->setCellValue("A{$row}", sprintf('%02d.00 - %02d.00', $hour, ($hour + 1) % 24));
            $sheet->setCellValue("D{$row}", $hour === 0 ? (($laporan->jam_mulai ?? '-') . ' - ' . ($laporan->jam_selesai ?? '-')) : '');
            $sheet->setCellValue("F{$row}", $hour === 0 ? ($laporan->cuaca ?? '-') : '');
            $sheet->getRowDimension($row)->setRowHeight(12);
        }
        $this->border($sheet, "A{$timeTop}:H{$row}");
        $this->center($sheet, "A{$timeTop}:H{$row}");

        // Notasi diletakkan setelah tabel waktu agar tidak menimpa baris jam kerja.
        $noteTop = $row + 2;
        $sheet->mergeCells("F{$noteTop}:H" . ($noteTop + 3));
        $sheet->setCellValue("F{$noteTop}", "Notasi Jam Kerja\n\nKerja\nIstirahat\nTidak bekerja");
        $this->wrap($sheet, "F{$noteTop}:H" . ($noteTop + 3));
        $this->border($sheet, "F{$noteTop}:H" . ($noteTop + 3));

        $weatherTop = $noteTop + 5;
        $sheet->mergeCells("F{$weatherTop}:H" . ($weatherTop + 4));
        $sheet->setCellValue("F{$weatherTop}", "Notasi Cuaca\n\nGerimis\nHujan Deras\nCerah\nBerawan/Mendung");
        $this->wrap($sheet, "F{$weatherTop}:H" . ($weatherTop + 4));
        $this->border($sheet, "F{$weatherTop}:H" . ($weatherTop + 4));

        $photoTop = $weatherTop + 6;
        $photoBottom = $photoTop + 9;
        $sheet->mergeCells("F{$photoTop}:H{$photoTop}");
        $sheet->setCellValue("F{$photoTop}", 'FOTO DOKUMENTASI');
        $this->header($sheet, "F{$photoTop}:H{$photoTop}");
        $sheet->mergeCells("F" . ($photoTop + 1) . ":H{$photoBottom}");
        $sheet->setCellValue("F" . ($photoTop + 1), $laporan->fotos->isEmpty() ? 'Belum ada foto dokumentasi' : '');
        $this->center($sheet, "F" . ($photoTop + 1) . ":H{$photoBottom}");
        $this->border($sheet, "F{$photoTop}:H{$photoBottom}");
        foreach ($laporan->fotos->take(3) as $index => $foto) {
            $path = public_path('storage/' . $foto->foto);
            if (is_file($path)) {
                $drawing = new Drawing();
                $drawing->setPath($path)->setCoordinates(chr(70 + ($index % 3)) . ($photoTop + 2))->setWidth(100)->setHeight(85)->setWorksheet($sheet);
            }
        }

        $signRow = max($row, $photoBottom) + 2;
        $sheet->mergeCells("A{$signRow}:D" . ($signRow + 3));
        $sheet->mergeCells("E{$signRow}:H" . ($signRow + 3));
        $sheet->setCellValue("A{$signRow}", "Diperiksa oleh:\nKonsultan Pengawas\n\n__________________\nPT. RENO ABIRAMA SAKTI");
        $sheet->setCellValue("E{$signRow}", (optional($laporan->tanggal)->format('d F Y') ?: '-') . "\nDibuat oleh:\nKontraktor Pelaksana\n\n__________________\n" . ($laporan->kontraktor ?: '-'));
        $this->wrap($sheet, "A{$signRow}:H" . ($signRow + 3), Alignment::HORIZONTAL_CENTER);

        $sheet->getPageSetup()->setOrientation('portrait')->setPaperSize('9')->setFitToWidth(1)->setFitToHeight(1);
        $sheet->getPageMargins()->setTop(.12)->setRight(.12)->setBottom(.12)->setLeft(.12);

        $filename = 'Laporan-Harian-Baru-' . Str::slug($laporan->nama_proyek) . '-' . $laporan->id . '.xlsx';
        return response()->streamDownload(fn () => (new Xlsx($book))->save('php://output'), $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
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

    private function wrap($sheet, string $range, string $horizontal = Alignment::HORIZONTAL_LEFT): void
    {
        $sheet->getStyle($range)->getAlignment()->setHorizontal($horizontal)->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
    }

    private function header($sheet, string $range, bool $title = false): void
    {
        $sheet->getStyle($range)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($title ? 'D9D9D9' : 'D9EAD3');
        $sheet->getStyle($range)->getFont()->setBold(true);
        $this->center($sheet, $range);
        $this->border($sheet, $range);
    }
}
