<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Carbon\Carbon;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class WeeklyOldExcelController extends Controller
{
    public function weekly(string $minggu, string $proyek)
    {
        $laporans = Laporan::with(['karyawan', 'pekerjaans', 'materials', 'alats', 'tenagas', 'fotos'])
            ->where('nama_proyek', $proyek)->orderBy('tanggal')->get();
        abort_if($laporans->isEmpty(), 404, 'Laporan proyek tidak ditemukan.');
        $start = Carbon::parse($laporans->min('tanggal'));
        if ($minggu === 'custom' && request()->has('start') && request()->has('end')) {
            $startDate = Carbon::parse(request('start'))->startOfDay();
            $endDate = Carbon::parse(request('end'))->endOfDay();
            $laporans = $laporans->filter(function ($laporan) use ($startDate, $endDate) {
                return Carbon::parse($laporan->tanggal)->between($startDate, $endDate);
            })->values();
        } else {
            if (request()->has('year') && request()->has('month')) {
                $year = request('year');
                $month = request('month');
                $laporans = $laporans->filter(function ($laporan) use ($minggu, $year, $month) {
                    $tanggal = Carbon::parse($laporan->tanggal);
                    if ($tanggal->year != $year || $tanggal->month != $month) return false;
                    $day = $tanggal->day;
                    if ($minggu == 1) return $day >= 1 && $day <= 7;
                    if ($minggu == 2) return $day >= 8 && $day <= 14;
                    if ($minggu == 3) return $day >= 15 && $day <= 21;
                    if ($minggu == 4) return $day >= 22 && $day <= 28;
                    if ($minggu == 5) return $day >= 29;
                    return false;
                })->values();
            } else {
                $laporans = $laporans->filter(function ($laporan) use ($start, $minggu) {
                    $key = trim((string) $laporan->minggu_ke);
                    $key = $key !== '' ? $key : (string) (floor($start->diffInDays(Carbon::parse($laporan->tanggal)) / 7) + 1);
                    return $key === $minggu;
                })->values();
            }
        }
        abort_if($laporans->isEmpty(), 404, 'Laporan minggu ini tidak ditemukan.');

        $book = new Spreadsheet();
        $sheet = $book->getActiveSheet();
        $sheet->setTitle('Laporan Mingguan Lama');
        $sheet->setShowGridlines(false);
        $sheet->fromArray([
            ['LAPORAN MINGGUAN'],
            ['Nama Proyek', $proyek],
            ['Minggu Ke', $minggu === 'custom' ? Carbon::parse(request('start'))->format('d/m/y') . ' - ' . Carbon::parse(request('end'))->format('d/m/y') : $minggu],
            ['Periode', Carbon::parse($laporans->min('tanggal'))->format('d-m-Y') . ' s/d ' . Carbon::parse($laporans->max('tanggal'))->format('d-m-Y')],
            ['Kegiatan', $laporans->first()->kegiatan],
            ['Sub Kegiatan', $laporans->first()->sub_kegiatan],
            [],
            ['Tanggal', 'Karyawan', 'Pekerjaan', 'Status', 'Progress', 'Cuaca', 'Kendala', 'Foto'],
        ]);
        $row = 9;
        foreach ($laporans as $laporan) {
            $sheet->fromArray([[$laporan->tanggal?->format('d-m-Y'), $laporan->karyawan->nama ?? '-', $laporan->pekerjaan, $laporan->status, $laporan->progress ?? '-', $laporan->cuaca ?? '-', $laporan->kendala ?? '-', $laporan->fotos->count()]], null, "A{$row}");
            $row++;
        }
        $sheet->getStyle('A1:H1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A8:H8')->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A8:H8')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('2563EB');
        $sheet->getStyle("A8:H" . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        foreach (range('A', 'H') as $column) $sheet->getColumnDimension($column)->setAutoSize(true);
        $sheet->getPageSetup()->setOrientation('landscape')->setFitToWidth(1)->setFitToHeight(0);
        $filename = 'Laporan-Mingguan-Lama-' . Str::slug($proyek) . '-Minggu-' . $minggu . '.xlsx';
        return response()->streamDownload(fn () => (new Xlsx($book))->save('php://output'), $filename, ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);
    }
}
