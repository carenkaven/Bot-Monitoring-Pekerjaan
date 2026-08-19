<?php

namespace App\Services;

use App\Models\Laporan;
use Carbon\Carbon;

class WeeklyPhysicalReportService
{
    public function build(string $minggu, string $proyek): array
    {
        $all = Laporan::with(['pekerjaans'])
            ->where('nama_proyek', $proyek)
            ->orderBy('tanggal')
            ->get();

        abort_if($all->isEmpty(), 404, 'Laporan proyek tidak ditemukan.');
        $start = Carbon::parse($all->min('tanggal'));
        
        if ($minggu === 'custom' && request()->has('start') && request()->has('end')) {
            $startDate = Carbon::parse(request('start'))->startOfDay();
            $endDate = Carbon::parse(request('end'))->endOfDay();
            $current = $all->filter(function ($report) use ($startDate, $endDate) {
                return Carbon::parse($report->tanggal)->between($startDate, $endDate);
            })->values();
            abort_if($current->isEmpty(), 404, 'Laporan pada rentang tanggal ini tidak ditemukan.');
        } else {
            if (request()->has('year') && request()->has('month')) {
                $year = request('year');
                $month = request('month');
                $current = $all->filter(function ($report) use ($minggu, $year, $month) {
                    $tanggal = Carbon::parse($report->tanggal);
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
                $current = $all->filter(fn (Laporan $report) => $this->weekKey($report, $start) === $minggu)->values();
            }
            abort_if($current->isEmpty(), 404, 'Laporan minggu ini tidak ditemukan.');
        }

        $first = $current->first();
        $groupedItems = [];
        foreach ($current as $report) {
            $kegiatan = strtoupper(trim($report->kegiatan ?: 'UMUM'));
            
            $workItems = $report->pekerjaans->pluck('nama_pekerjaan')->filter()->values();
            if ($workItems->isEmpty()) {
                $workItems = collect([$report->pekerjaan]);
            }
            
            foreach ($workItems as $work) {
                $key = mb_strtolower(trim($work));
                $groupedItems[$kegiatan][$key] ??= ['name' => trim($work), 'volume' => null, 'sat' => '-', 'bobot' => 0, 'count' => 0];
                $groupedItems[$kegiatan][$key]['bobot'] = max($groupedItems[$kegiatan][$key]['bobot'], (float) ($report->progress ?? 0) / 100);
                $groupedItems[$kegiatan][$key]['count']++;
            }
        }
        
        $rows = [];
        $groupIndex = 0;
        foreach ($groupedItems as $kegiatanName => $items) {
            $letter = chr(65 + $groupIndex); // A, B, C, etc.
            
            $rows[] = [
                'no' => $letter,
                'item' => $kegiatanName,
                'is_header' => true,
                'volume' => null,
                'sat' => null,
                'bobot' => null,
                'lalu_volume' => null,
                'lalu_bobot' => null,
                'ini_volume' => null,
                'ini_bobot' => null,
                'sampai_volume' => null,
                'sampai_bobot' => null,
            ];
            
            $itemIndex = 1;
            foreach ($items as $item) {
                $bobot = $item['bobot'];
                $rows[] = [
                    'no' => $itemIndex,
                    'item' => $item['name'],
                    'is_header' => false,
                    'volume' => $item['volume'],
                    'sat' => $item['sat'],
                    'bobot' => $bobot,
                    'lalu_volume' => null,
                    'lalu_bobot' => 0,
                    'ini_volume' => null,
                    'ini_bobot' => $bobot,
                    'sampai_volume' => null,
                    'sampai_bobot' => $bobot,
                ];
                $itemIndex++;
            }
            $groupIndex++;
        }
        
        $rows = collect($rows)->values();

        $tanggalMulai = Carbon::parse($current->min('tanggal'));
        $tanggalSelesai = Carbon::parse($current->max('tanggal'));

        if ($minggu !== 'custom' && request()->has('year') && request()->has('month')) {
            $rYear = request('year');
            $rMonth = request('month');
            $tanggalMulai = Carbon::create($rYear, $rMonth, 1);
            if ($minggu == 1) {
                $tanggalSelesai = $tanggalMulai->copy()->day(7);
            } elseif ($minggu == 2) {
                $tanggalMulai->day(8);
                $tanggalSelesai = $tanggalMulai->copy()->day(14);
            } elseif ($minggu == 3) {
                $tanggalMulai->day(15);
                $tanggalSelesai = $tanggalMulai->copy()->day(21);
            } elseif ($minggu == 4) {
                $tanggalMulai->day(22);
                $tanggalSelesai = $tanggalMulai->copy()->day(28);
            } elseif ($minggu == 5) {
                $tanggalMulai->day(29);
                $tanggalSelesai = $tanggalMulai->copy()->endOfMonth();
            }
        } elseif ($minggu === 'custom' && request()->has('start') && request()->has('end')) {
            $tanggalMulai = Carbon::parse(request('start'))->startOfDay();
            $tanggalSelesai = Carbon::parse(request('end'))->endOfDay();
        }

        return [
            'summary' => [
                'minggu_ke' => $minggu === 'custom' ? Carbon::parse(request('start'))->format('d/m/y') . ' - ' . Carbon::parse(request('end'))->format('d/m/y') : $minggu,
                'nama_proyek' => $proyek,
                'kegiatan' => $first->kegiatan,
                'sub_kegiatan' => $first->sub_kegiatan,
                'pekerjaan' => $first->pekerjaan,
                'lokasi' => $first->lokasi,
                'tahun_anggaran' => $current->min('tanggal') ? Carbon::parse($current->min('tanggal'))->year : date('Y'),
                'kontraktor' => $first->kontraktor,
                'konsultan' => $first->konsultan,
                'pic' => $first->pic,
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
            ],
            'rows' => $rows,
        ];
    }

    public function weekKey(Laporan $report, Carbon $start): string
    {
        $explicit = trim((string) $report->minggu_ke);
        if ($explicit !== '') return $explicit;
        return (string) (floor($start->diffInDays(Carbon::parse($report->tanggal)) / 7) + 1);
    }
}
