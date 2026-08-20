<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Traits\RotatesPortraitImages;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DailyNewExcelController extends Controller
{
    use RotatesPortraitImages;

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

        // Row 2: Pekerjaan
        $sheet->mergeCells('A2:B2'); $sheet->setCellValue('A2', 'Pekerjaan');
        $sheet->setCellValue('C2', ':');
        $sheet->mergeCells('D2:H2'); $sheet->setCellValue('D2', $laporan->pekerjaan ?: '-');

        // Row 3: Lokasi
        $sheet->mergeCells('A3:B3'); $sheet->setCellValue('A3', 'Lokasi');
        $sheet->setCellValue('C3', ':');
        $sheet->mergeCells('D3:H3'); $sheet->setCellValue('D3', $laporan->lokasi ?: '-');

        // Row 4: Tahun Anggaran
        $sheet->mergeCells('A4:B4'); $sheet->setCellValue('A4', 'Tahun Anggaran');
        $sheet->setCellValue('C4', ':');
        $sheet->mergeCells('D4:H4'); $sheet->setCellValue('D4', optional($laporan->tanggal)->format('Y') ?: date('Y'));

        // Row 5: Minggu Ke
        $sheet->mergeCells('A5:B5'); $sheet->setCellValue('A5', 'Minggu Ke');
        $sheet->setCellValue('C5', ':');
        $sheet->mergeCells('D5:H5'); $sheet->setCellValue('D5', $laporan->minggu_ke ?: '-');

        // Row 6: Periode
        $sheet->mergeCells('A6:B6'); $sheet->setCellValue('A6', 'Periode');
        $sheet->setCellValue('C6', ':');
        $sheet->mergeCells('D6:H6'); $sheet->setCellValue('D6', optional($laporan->tanggal)->format('d F Y') ?: '-');

        // Row 7: Tanggal
        $sheet->mergeCells('A7:B7'); $sheet->setCellValue('A7', 'Tanggal');
        $sheet->setCellValue('C7', ':');
        $sheet->mergeCells('D7:H7'); $sheet->setCellValue('D7', optional($laporan->tanggal)->format('d F Y') ?: '-');

        $sheet->getStyle('A2:A7')->getFont()->setBold(true);
        $this->wrap($sheet, 'A2:H7', Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C2:C7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $this->outlineBorder($sheet, 'A2:H7');

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
            $material = $laporan->materials->values()->get($i);
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
        $tenagaList = [];
        foreach ($laporan->tenagas as $t) {
            if ($t->jenis_tenaga) {
                $tenagaList[] = ['jenis' => $t->jenis_tenaga, 'jumlah' => $t->jumlah, 'satuan' => $t->satuan ?? 'org'];
            } else {
                if ($t->pekerja !== null) $tenagaList[] = ['jenis' => 'Pekerja', 'jumlah' => $t->pekerja, 'satuan' => 'org'];
                if ($t->tukang !== null) $tenagaList[] = ['jenis' => 'Tukang', 'jumlah' => $t->tukang, 'satuan' => 'org'];
                if ($t->mandor !== null) $tenagaList[] = ['jenis' => 'Mandor', 'jumlah' => $t->mandor, 'satuan' => 'org'];
                if ($t->pelaksana !== null) $tenagaList[] = ['jenis' => 'Pelaksana lapangan', 'jumlah' => $t->pelaksana, 'satuan' => 'org'];
            }
        }

        for ($i = 0; $i < 10; $i++) {
            $row++;
            $tenaga = $tenagaList[$i] ?? null;
            $alat = $laporan->alats[$i] ?? null;
            $sheet->fromArray([[$i + 1, $tenaga['jenis'] ?? '', $tenaga['jumlah'] ?? '', isset($tenaga) ? $tenaga['satuan'] : '', $i + 1, $alat->nama_alat ?? '', $alat->jumlah ?? '', $alat ? 'unit' : '']], null, "A{$row}");
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
        $startHour = $laporan->jam_mulai ? (int) substr($laporan->jam_mulai, 0, 2) : null;
        $endHour = $laporan->jam_selesai ? (int) substr($laporan->jam_selesai, 0, 2) : null;
        $cuacaStr = strtolower($laporan->cuaca ?? '');
        $cuacaType = 'none';
        if (str_contains($cuacaStr, 'hujan deras') || str_contains($cuacaStr, 'hujan lebat')) {
            $cuacaType = 'hujan';
        } elseif (str_contains($cuacaStr, 'gerimis') || str_contains($cuacaStr, 'hujan ringan') || str_contains($cuacaStr, 'hujan')) {
            $cuacaType = 'gerimis';
        } elseif (str_contains($cuacaStr, 'berawan') || str_contains($cuacaStr, 'mendung')) {
            $cuacaType = 'berawan';
        } else {
            $cuacaType = 'cerah';
        }

        for ($hour = 0; $hour < 24; $hour++) {
            $row++;
            $sheet->mergeCells("A{$row}:C{$row}");
            $sheet->mergeCells("D{$row}:E{$row}");
            $sheet->mergeCells("F{$row}:H{$row}");
            $sheet->setCellValue("A{$row}", sprintf('%02d.00 - %02d.00', $hour, ($hour + 1) % 24));
            
            $jamType = 'none';
            if ($startHour !== null && $endHour !== null) {
                if ($hour >= $startHour && $hour < $endHour) {
                    $jamType = ($hour == 12) ? 'istirahat' : 'kerja';
                }
            }
            $cellCuacaType = ($jamType !== 'none') ? $cuacaType : 'none';

            if ($jamType === 'kerja') {
                $sheet->getStyle("D{$row}:E{$row}")->getFill()->setFillType(Fill::FILL_PATTERN_DARKUP)->getStartColor()->setRGB('000000');
                $sheet->getStyle("D{$row}:E{$row}")->getFill()->getEndColor()->setRGB('808080');
            } elseif ($jamType === 'istirahat') {
                $sheet->getStyle("D{$row}:E{$row}")->getFill()->setFillType(Fill::FILL_PATTERN_LIGHTGRID)->getStartColor()->setRGB('000000');
                $sheet->getStyle("D{$row}:E{$row}")->getFill()->getEndColor()->setRGB('D9D9D9');
            } else {
                $sheet->getStyle("D{$row}:E{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFFFFF');
            }

            if ($cellCuacaType === 'gerimis') {
                $sheet->getStyle("F{$row}:H{$row}")->getFill()->setFillType(Fill::FILL_PATTERN_DARKUP)->getStartColor()->setRGB('000000');
                $sheet->getStyle("F{$row}:H{$row}")->getFill()->getEndColor()->setRGB('808080');
            } elseif ($cellCuacaType === 'hujan') {
                $sheet->getStyle("F{$row}:H{$row}")->getFill()->setFillType(Fill::FILL_PATTERN_LIGHTGRID)->getStartColor()->setRGB('000000');
                $sheet->getStyle("F{$row}:H{$row}")->getFill()->getEndColor()->setRGB('D9D9D9');
            } else {
                $sheet->getStyle("F{$row}:H{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFFFFF');
            }
            
            $sheet->getRowDimension($row)->setRowHeight(12);
        }
        $this->border($sheet, "A{$timeTop}:H{$row}");
        $this->center($sheet, "A{$timeTop}:H{$row}");

        // Notasi diletakkan setelah tabel waktu
        $noteTop = $row + 2;
        
        // Notasi Jam Kerja
        $sheet->mergeCells("B{$noteTop}:D{$noteTop}"); $sheet->setCellValue("B{$noteTop}", "Notasi Jam Kerja :");
        $rowNj = $noteTop + 1;
        $sheet->getStyle("B{$rowNj}")->getFill()->setFillType(Fill::FILL_PATTERN_DARKUP)->getStartColor()->setRGB('000000'); 
        $sheet->getStyle("B{$rowNj}")->getFill()->getEndColor()->setRGB('808080');
        $this->border($sheet, "B{$rowNj}:B{$rowNj}");
        $sheet->mergeCells("C{$rowNj}:D{$rowNj}"); $sheet->setCellValue("C{$rowNj}", 'Kerja');
        
        $rowNj++;
        $sheet->getStyle("B{$rowNj}")->getFill()->setFillType(Fill::FILL_PATTERN_LIGHTGRID)->getStartColor()->setRGB('000000'); 
        $sheet->getStyle("B{$rowNj}")->getFill()->getEndColor()->setRGB('D9D9D9');
        $this->border($sheet, "B{$rowNj}:B{$rowNj}");
        $sheet->mergeCells("C{$rowNj}:D{$rowNj}"); $sheet->setCellValue("C{$rowNj}", 'Istirahat');
        
        $rowNj++;
        $sheet->getStyle("B{$rowNj}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFFFFF'); $this->border($sheet, "B{$rowNj}:B{$rowNj}");
        $sheet->mergeCells("C{$rowNj}:D{$rowNj}"); $sheet->setCellValue("C{$rowNj}", 'Tidak bekerja');
        
        // Notasi Cuaca
        $sheet->mergeCells("F{$noteTop}:H{$noteTop}"); $sheet->setCellValue("F{$noteTop}", "Notasi Cuaca :");
        $rowNc = $noteTop + 1;
        $sheet->getStyle("F{$rowNc}")->getFill()->setFillType(Fill::FILL_PATTERN_DARKUP)->getStartColor()->setRGB('000000'); 
        $sheet->getStyle("F{$rowNc}")->getFill()->getEndColor()->setRGB('808080');
        $this->border($sheet, "F{$rowNc}:F{$rowNc}");
        $sheet->mergeCells("G{$rowNc}:H{$rowNc}"); $sheet->setCellValue("G{$rowNc}", 'Gerimis');
        
        $rowNc++;
        $sheet->getStyle("F{$rowNc}")->getFill()->setFillType(Fill::FILL_PATTERN_LIGHTGRID)->getStartColor()->setRGB('000000'); 
        $sheet->getStyle("F{$rowNc}")->getFill()->getEndColor()->setRGB('D9D9D9');
        $this->border($sheet, "F{$rowNc}:F{$rowNc}");
        $sheet->mergeCells("G{$rowNc}:H{$rowNc}"); $sheet->setCellValue("G{$rowNc}", 'Hujan Deras');
        
        $rowNc++;
        $sheet->getStyle("F{$rowNc}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFFFFF'); $this->border($sheet, "F{$rowNc}:F{$rowNc}");
        $sheet->mergeCells("G{$rowNc}:H{$rowNc}"); $sheet->setCellValue("G{$rowNc}", 'Cerah');
        
        $rowNc++;
        $sheet->getStyle("F{$rowNc}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFFFFF'); 
        $this->border($sheet, "F{$rowNc}:F{$rowNc}");
        $sheet->mergeCells("G{$rowNc}:H{$rowNc}"); $sheet->setCellValue("G{$rowNc}", 'Berawan/Mendung');

        $textTop = $noteTop + 6;
        $sheet->mergeCells("A{$textTop}:C{$textTop}"); $sheet->setCellValue("A{$textTop}", 'KENDALA');
        $sheet->mergeCells("D{$textTop}:E{$textTop}"); $sheet->setCellValue("D{$textTop}", 'KETERANGAN');
        $sheet->mergeCells("F{$textTop}:H{$textTop}"); $sheet->setCellValue("F{$textTop}", 'CATATAN / PROGRESS');
        $this->header($sheet, "A{$textTop}:H{$textTop}");
        
        $textBottom = $textTop + 1;
        $sheet->mergeCells("A{$textBottom}:C{$textBottom}"); $sheet->setCellValue("A{$textBottom}", $laporan->kendala ?: '-');
        $sheet->mergeCells("D{$textBottom}:E{$textBottom}"); $sheet->setCellValue("D{$textBottom}", $laporan->keterangan ?: '-');
        $sheet->mergeCells("F{$textBottom}:H{$textBottom}"); $sheet->setCellValue("F{$textBottom}", $laporan->catatan ?: '-');
        
        $this->wrap($sheet, "A{$textBottom}:H{$textBottom}", Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("A{$textBottom}:H{$textBottom}")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $this->border($sheet, "A{$textTop}:C{$textBottom}");
        $this->border($sheet, "D{$textTop}:E{$textBottom}");
        $this->border($sheet, "F{$textTop}:H{$textBottom}");
        $sheet->getRowDimension($textBottom)->setRowHeight(60);

        // Foto ditempatkan di bawah blok teks.
        $photoTop = $textBottom + 2;
        $photoBottom = $photoTop + 6; // 6 rows for photos
        $sheet->mergeCells("A{$photoTop}:H{$photoTop}");
        $sheet->setCellValue("A{$photoTop}", 'FOTO DOKUMENTASI');
        $this->header($sheet, "A{$photoTop}:H{$photoTop}");
        $sheet->mergeCells("A" . ($photoTop + 1) . ":H{$photoBottom}");
        $sheet->setCellValue("A" . ($photoTop + 1), $laporan->fotos->isEmpty() ? 'Belum ada foto dokumentasi' : '');
        $this->center($sheet, "A" . ($photoTop + 1) . ":H{$photoBottom}");
        $this->border($sheet, "A{$photoTop}:H{$photoBottom}");
        for ($photoRow = $photoTop + 1; $photoRow <= $photoBottom; $photoRow++) {
            $sheet->getRowDimension($photoRow)->setRowHeight(25); // Total height = 6 * 25 = 150px
        }
        $anchors = [
            ['col' => 'B', 'offset' => 10], 
            ['col' => 'D', 'offset' => 10], 
            ['col' => 'G', 'offset' => 10], 
        ];
        foreach ($laporan->fotos->take(3) as $index => $foto) {
            $path = storage_path('app/public/' . ltrim($foto->foto, '/\\'));
            if (file_exists($path)) {
                $this->ensureLandscapeImage($path);
                
                $anchor = $anchors[$index] ?? ['col' => 'A', 'offset' => 10];
                $drawing = new Drawing();
                $drawing->setPath($path)
                    ->setCoordinates($anchor['col'] . ($photoTop + 1))
                    ->setOffsetX($anchor['offset'])
                    ->setOffsetY(10)
                    ->setResizeProportional(false) // Force exact dimensions
                    ->setWidth(160)
                    ->setHeight(120) // 4:3 landscape ratio
                    ->setWorksheet($sheet);
            }
        }

        $signRow = max($row, $photoBottom) + 2;
        $sheet->mergeCells("A{$signRow}:D" . ($signRow + 8));
        $sheet->mergeCells("E{$signRow}:H" . ($signRow + 8));
        
        $sheet->setCellValue("A{$signRow}", "Diperiksa oleh:\nKonsultan Pengawas\n\n\n\n________________________\n" . ($laporan->konsultan ?: 'PT. RENO ABIRAMA SAKTI'));
        $sheet->setCellValue("E{$signRow}", (optional($laporan->tanggal)->format('d F Y') ?: '-') . "\nDibuat oleh:\nKontraktor Pelaksana\n\n\n\n________________________\n" . ($laporan->kontraktor ?: '-'));
        
        $this->wrap($sheet, "A{$signRow}:H" . ($signRow + 8), Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A{$signRow}:H" . ($signRow + 8))->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        
        for ($i = 0; $i <= 8; $i++) {
             $sheet->getRowDimension($signRow + $i)->setRowHeight(16);
        }
        
        $botTimeRow = $signRow + 10;
        $sheet->setCellValue("A{$botTimeRow}", "Waktu Pengiriman Laporan (Via Bot WA) : " . ($laporan->created_at ? $laporan->created_at->format('d F Y H:i:s') : '-') . " WIB");
        $sheet->getStyle("A{$botTimeRow}")->getFont()->setItalic(true)->setSize(9)->getColor()->setRGB('555555');

        $sheet->getPageSetup()->setOrientation('portrait')->setPaperSize('9')->setFitToWidth(1)->setFitToHeight(1);
        $sheet->getPageMargins()->setTop(.5)->setRight(.5)->setBottom(.5)->setLeft(.5);

        $filename = 'Laporan-Harian-Baru-' . Str::slug($laporan->nama_proyek) . '-' . $laporan->id . '.xlsx';
        return response()->streamDownload(fn () => (new Xlsx($book))->save('php://output'), $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    private function border($sheet, string $range): void
    {
        $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setRGB('000000');
    }

    private function outlineBorder($sheet, string $range): void
    {
        $sheet->getStyle($range)->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->getColor()->setRGB('000000');
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
