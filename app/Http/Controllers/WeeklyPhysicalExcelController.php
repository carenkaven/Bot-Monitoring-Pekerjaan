<?php

namespace App\Http\Controllers;

use App\Services\WeeklyPhysicalReportService;
use App\Models\Laporan;
use Carbon\Carbon;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class WeeklyPhysicalExcelController extends Controller
{
    public function weekly(string $minggu, string $proyek, WeeklyPhysicalReportService $service)
    {
        if ($proyek === 'all') {
            $query = Laporan::select('nama_proyek')->distinct();
            if ($minggu === 'custom' && request()->has('start') && request()->has('end')) {
                $query->whereBetween('tanggal', [
                    Carbon::parse(request('start'))->startOfDay(),
                    Carbon::parse(request('end'))->endOfDay()
                ]);
            } elseif (request()->has('year') && request()->has('month')) {
                $query->whereYear('tanggal', request('year'))->whereMonth('tanggal', request('month'));
            }
            $proyekList = $query->pluck('nama_proyek')->sort()->values();
        } else {
            $proyekList = collect([$proyek]);
        }

        abort_if($proyekList->isEmpty(), 404, 'Tidak ada proyek ditemukan.');

        $book = new Spreadsheet();
        $book->removeSheetByIndex(0);
        $hasData = false;
        $sheetIndex = 1;

        foreach ($proyekList as $p) {
            try {
                $data = $service->build($minggu, $p);
                $hasData = true;

                $summary = $data['summary'];
                $sheet = $book->createSheet();
                
                $safeTitle = preg_replace('/[*\/\?:\[\]\\\\]/', '', Str::limit($p, 25));
                if (!$safeTitle) $safeTitle = "Project " . $sheetIndex;
                $sheet->setTitle($safeTitle);
                $sheetIndex++;

                $sheet->setShowGridlines(false);
                foreach (['A'=>6,'B'=>34,'C'=>11,'D'=>9,'E'=>11,'F'=>12,'G'=>12,'H'=>12,'I'=>12,'J'=>12,'K'=>12] as $col => $width) $sheet->getColumnDimension($col)->setWidth($width);
                $sheet->mergeCells('A1:K1'); $sheet->mergeCells('A2:K2');
                $sheet->setCellValue('A1', 'II.    LAPORAN FISIK MINGGUAN');
                $sheet->setCellValue('A2', 'PT RENO ABIRAMA SAKTI');
                $sheet->getStyle('A1:K2')->getFont()->setBold(true);
                $sheet->getStyle('A1')->getFont()->setSize(14);
                $sheet->getStyle('A1:K2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->mergeCells('A4:F5');
                $sheet->setCellValue('A4', "PEMERINTAH KABUPATEN KEDIRI\nDINAS LINGKUNGAN HIDUP");
                $sheet->mergeCells('A7:B7'); $sheet->setCellValue('A7', 'KEGIATAN'); $sheet->setCellValue('C7', ':'); $sheet->mergeCells('D7:F7'); $sheet->setCellValue('D7', $summary['kegiatan']);
                $sheet->mergeCells('A8:B8'); $sheet->setCellValue('A8', 'LOKASI');   $sheet->setCellValue('C8', ':'); $sheet->mergeCells('D8:F8'); $sheet->setCellValue('D8', $summary['lokasi']);
                $sheet->getStyle('A7:B8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle('C7:C8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('D7:F8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $sheet->mergeCells('G4:H8');
                $sheet->setCellValue('G4', "MINGGU : {$summary['minggu_ke']}\nPERIODE : {$summary['tanggal_mulai']->locale('id')->isoFormat('D MMMM Y')} s/d {$summary['tanggal_selesai']->locale('id')->isoFormat('D MMMM Y')}");
                $sheet->mergeCells('I4:K8');
                $sheet->setCellValue('I4', "KONTRAKTOR / KONTRAKTOR PELAKSANA\n{$summary['kontraktor']}");
                $this->wrapCenter($sheet, 'A4:F5'); $this->wrapCenter($sheet, 'G4:K8');
                $this->outlineBorder($sheet, 'A4:F8'); $this->outlineBorder($sheet, 'G4:H8'); $this->outlineBorder($sheet, 'I4:K8');

                $sheet->mergeCells('A10:B10'); $sheet->setCellValue('A10', 'KEGIATAN');       $sheet->setCellValue('C10', ':'); $sheet->mergeCells('D10:K10'); $sheet->setCellValue('D10', $summary['kegiatan']);
                $sheet->mergeCells('A11:B11'); $sheet->setCellValue('A11', 'SUB KEGIATAN');   $sheet->setCellValue('C11', ':'); $sheet->mergeCells('D11:K11'); $sheet->setCellValue('D11', $summary['sub_kegiatan']);
                $sheet->mergeCells('A12:B12'); $sheet->setCellValue('A12', 'PEKERJAAN');      $sheet->setCellValue('C12', ':'); $sheet->mergeCells('D12:K12'); $sheet->setCellValue('D12', $summary['pekerjaan']);
                $sheet->mergeCells('A13:B13'); $sheet->setCellValue('A13', 'LOKASI');         $sheet->setCellValue('C13', ':'); $sheet->mergeCells('D13:K13'); $sheet->setCellValue('D13', $summary['lokasi']);
                $sheet->mergeCells('A14:B14'); $sheet->setCellValue('A14', 'TAHUN ANGGARAN'); $sheet->setCellValue('C14', ':'); $sheet->mergeCells('D14:K14'); $sheet->setCellValue('D14', $summary['tahun_anggaran']);
                $sheet->getStyle('A10:B14')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('C10:C14')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('D10:K14')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('A10:K14')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
                $this->outlineBorder($sheet, 'A10:K14');
                $sheet->mergeCells('A16:A18');
                $sheet->mergeCells('B16:B18');
                $sheet->mergeCells('C16:C18');
                $sheet->mergeCells('D16:D18');
                $sheet->mergeCells('E16:E18');
                $sheet->mergeCells('F16:K16');
                $sheet->mergeCells('F17:G17');
                $sheet->mergeCells('H17:I17');
                $sheet->mergeCells('J17:K17');

                $sheet->setCellValue('A16', 'NO');
                $sheet->setCellValue('B16', 'ITEM PEKERJAAN');
                $sheet->setCellValue('C16', 'VOLUME');
                $sheet->setCellValue('D16', 'SAT');
                $sheet->setCellValue('E16', "BOBOT\n(%)");
                $sheet->setCellValue('F16', 'PRESTASI PEKERJAAN');
                $sheet->setCellValue('F17', 'S/D MINGGU LALU');
                $sheet->setCellValue('H17', 'MINGGU INI');
                $sheet->setCellValue('J17', 'S/D MINGGU INI');
                
                $headersRow3 = ['VOLUME', "BOBOT\n(%)", 'VOLUME', "BOBOT\n(%)", 'VOLUME', "BOBOT\n(%)"];
                $sheet->fromArray([$headersRow3], null, 'F18');

                $sheet->getStyle('A16:K18')->getFont()->setBold(true)->getColor()->setRGB('000000');
                $sheet->getStyle('A16:K18')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('DDEBD2'); 
                $this->wrapCenter($sheet, 'A16:K18'); 
                $this->border($sheet, 'A16:K18');

                $row = 19;
                foreach ($data['rows'] as $item) {
                    $sheet->fromArray([[$item['no'],$item['item'],$item['volume'],$item['sat'],$item['bobot'],$item['lalu_volume'],$item['lalu_bobot'],$item['ini_volume'],$item['ini_bobot'],$item['sampai_volume'],$item['sampai_bobot']]], null, "A{$row}");
                    if (!empty($item['is_header'])) {
                        $sheet->getStyle("A{$row}:K{$row}")->getFont()->setBold(true);
                        $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setIndent(1);
                    } else {
                        $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                    }
                    $row++;
                }
                $sheet->fromArray([['','','','',100,'','', '',array_sum($data['rows']->pluck('ini_bobot')->all()),'',array_sum($data['rows']->pluck('sampai_bobot')->all())]], null, "A{$row}");
                $sheet->getStyle("A19:K{$row}")->getNumberFormat()->setFormatCode('0.000%'); $sheet->getStyle("A19:A{$row}")->getNumberFormat()->setFormatCode('0'); $this->border($sheet, "A19:K{$row}"); $sheet->getStyle("A19:K{$row}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
                
                // SIGNATURE BLOCK
                $row += 2;
                $sheet->mergeCells("B{$row}:D{$row}");
                $sheet->mergeCells("E{$row}:H{$row}");
                $sheet->mergeCells("I{$row}:K{$row}");
                $sheet->setCellValue("B{$row}", "Mengetahui:\nPEJABAT PEMBUAT KOMITMEN\nDINAS LINGKUNGAN HIDUP\nKABUPATEN KEDIRI");
                $sheet->setCellValue("E{$row}", "Diperiksa dan Diperiksa oleh:\nKONSULTAN PENGAWAS\n" . ($summary['konsultan'] ?? '-'));
                $sheet->setCellValue("I{$row}", "Kediri, " . $summary['tanggal_selesai']->locale('id')->isoFormat('D MMMM Y') . "\nKontraktor Pelaksana\n" . ($summary['kontraktor'] ?? '-'));
                $sheet->getStyle("B{$row}:K{$row}")->getAlignment()->setWrapText(true)->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $row += 5;
                $sheet->mergeCells("B{$row}:D{$row}");
                $sheet->mergeCells("E{$row}:H{$row}");
                $sheet->mergeCells("I{$row}:K{$row}");
                $sheet->setCellValue("B{$row}", "WENI ARTANTI, ST. MH\nNIP. 19810318 200902 2 004");
                $sheet->setCellValue("E{$row}", "NIKOLAUS ADI KURNIA PUTRA\nDirektur");
                $sheet->setCellValue("I{$row}", ($summary['pic'] ?: '________________________') . "\nPelaksana");
                $sheet->getStyle("B{$row}:K{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getPageSetup()->setOrientation('landscape')->setPaperSize('9')->setFitToWidth(1)->setFitToHeight(0);
                $sheet->getPageMargins()->setTop(.2)->setRight(.2)->setBottom(.2)->setLeft(.2);
            } catch (\Exception $e) {
                // skip if no report
            }
        }

        abort_if(!$hasData, 404, 'Laporan minggu ini tidak ditemukan.');

        $book->setActiveSheetIndex(0);
        $filename = 'Laporan-Fisik-Mingguan-' . ($proyek === 'all' ? 'Semua-Proyek' : Str::slug($proyek)) . '-Minggu-' . $minggu . '.xlsx';
        return response()->streamDownload(fn () => (new Xlsx($book))->save('php://output'), $filename, ['Content-Type'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);
    }

    private function border($sheet, string $range): void { $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setRGB('000000'); }
    private function outlineBorder($sheet, string $range): void { $sheet->getStyle($range)->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->getColor()->setRGB('000000'); }
    private function wrapCenter($sheet, string $range): void { $sheet->getStyle($range)->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER); }
}
