<?php

namespace App\Http\Controllers;

use App\Services\WeeklyPhysicalReportService;
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
        $data = $service->build($minggu, $proyek);
        $summary = $data['summary'];
        $book = new Spreadsheet();
        $sheet = $book->getActiveSheet();
        $sheet->setTitle('Laporan Fisik Mingguan');
        $sheet->setShowGridlines(false);
        foreach (['A'=>6,'B'=>34,'C'=>11,'D'=>9,'E'=>11,'F'=>12,'G'=>12,'H'=>12,'I'=>12,'J'=>12,'K'=>12] as $col => $width) $sheet->getColumnDimension($col)->setWidth($width);
        $sheet->mergeCells('A1:K1'); $sheet->mergeCells('A2:K2');
        $sheet->setCellValue('A1', 'II.    LAPORAN FISIK MINGGUAN');
        $sheet->setCellValue('A2', 'PT RENO ABIRAMA SAKTI');
        $sheet->getStyle('A1:K2')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(14);
        $sheet->getStyle('A1:K2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->mergeCells('A4:F8'); $sheet->mergeCells('G4:H8'); $sheet->mergeCells('I4:K8');
        $sheet->setCellValue('A4', "PEMERINTAH KABUPATEN KEDIRI\nDINAS LINGKUNGAN HIDUP\n\nKEGIATAN: {$summary['kegiatan']}\nLOKASI: {$summary['lokasi']}");
        $sheet->setCellValue('G4', "MINGGU : {$summary['minggu_ke']}\nPERIODE : {$summary['tanggal_mulai']->format('d F Y')} s/d {$summary['tanggal_selesai']->format('d F Y')}");
        $sheet->setCellValue('I4', "KONTRAKTOR / KONTRAKTOR PELAKSANA\n{$summary['kontraktor']}");
        $this->wrapCenter($sheet, 'A4:K8'); $this->border($sheet, 'A4:K8');
        $sheet->mergeCells('A10:K13');
        $sheet->setCellValue('A10', "KEGIATAN       : {$summary['kegiatan']}\nSUB KEGIATAN : {$summary['sub_kegiatan']}\nPEKERJAAN     : {$summary['pekerjaan']}\nLOKASI             : {$summary['lokasi']}\nTAHUN ANGGARAN : {$summary['tahun_anggaran']}");
        $sheet->getStyle('A10')->getAlignment()->setWrapText(true); $this->border($sheet, 'A10:K13');
        $headers = ['NO','ITEM PEKERJAAN','VOLUME','SAT','BOBOT (%)','S/D MINGGU LALU\nVOLUME','BOBOT (%)','MINGGU INI\nVOLUME','BOBOT (%)','S/D MINGGU INI\nVOLUME','BOBOT (%)'];
        $sheet->fromArray([$headers], null, 'A15');
        $sheet->getStyle('A15:K15')->getFont()->setBold(true)->getColor()->setRGB('000000');
        $sheet->getStyle('A15:K15')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('DDEBD2'); $this->wrapCenter($sheet, 'A15:K15'); $this->border($sheet, 'A15:K15');
        $row = 16;
        foreach ($data['rows'] as $item) { $sheet->fromArray([[$item['no'],$item['item'],$item['volume'],$item['sat'],$item['bobot'],$item['lalu_volume'],$item['lalu_bobot'],$item['ini_volume'],$item['ini_bobot'],$item['sampai_volume'],$item['sampai_bobot']]], null, "A{$row}"); $row++; }
        $sheet->fromArray([['','','','',100,'','', '',array_sum($data['rows']->pluck('ini_bobot')->all()),'',array_sum($data['rows']->pluck('sampai_bobot')->all())]], null, "A{$row}");
        $sheet->getStyle("A16:K{$row}")->getNumberFormat()->setFormatCode('0.000%'); $sheet->getStyle("A16:A{$row}")->getNumberFormat()->setFormatCode('0'); $this->border($sheet, "A16:K{$row}"); $sheet->getStyle("A16:K{$row}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $sheet->getPageSetup()->setOrientation('landscape')->setPaperSize('9')->setFitToWidth(1)->setFitToHeight(0);
        $sheet->getPageMargins()->setTop(.2)->setRight(.2)->setBottom(.2)->setLeft(.2);
        $filename = 'Laporan-Fisik-Mingguan-' . Str::slug($proyek) . '-Minggu-' . $minggu . '.xlsx';
        return response()->streamDownload(fn () => (new Xlsx($book))->save('php://output'), $filename, ['Content-Type'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);
    }

    private function border($sheet, string $range): void { $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setRGB('000000'); }
    private function wrapCenter($sheet, string $range): void { $sheet->getStyle($range)->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER); }
}
