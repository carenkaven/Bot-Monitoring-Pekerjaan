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
        $current = $all->filter(fn (Laporan $report) => $this->weekKey($report, $start) === $minggu)->values();
        abort_if($current->isEmpty(), 404, 'Laporan minggu ini tidak ditemukan.');

        $first = $current->first();
        $items = [];
        foreach ($current as $report) {
            $workItems = $report->pekerjaans->pluck('nama_pekerjaan')->filter()->values();
            if ($workItems->isEmpty()) {
                $workItems = collect([$report->pekerjaan]);
            }
            foreach ($workItems as $work) {
                $key = mb_strtolower(trim($work));
                $items[$key] ??= ['name' => trim($work), 'volume' => null, 'sat' => '-', 'bobot' => 0, 'count' => 0];
                $items[$key]['bobot'] = max($items[$key]['bobot'], (float) ($report->progress ?? 0) / 100);
                $items[$key]['count']++;
            }
        }

        $rows = collect($items)->values()->map(function (array $item, int $index) use ($current) {
            $bobot = $item['bobot'];
            return [
                'no' => $index + 1,
                'item' => $item['name'],
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
        })->values();

        return [
            'summary' => [
                'minggu_ke' => $minggu,
                'nama_proyek' => $proyek,
                'kegiatan' => $first->kegiatan,
                'sub_kegiatan' => $first->sub_kegiatan,
                'pekerjaan' => $first->pekerjaan,
                'lokasi' => $first->lokasi,
                'tahun_anggaran' => $current->min('tanggal') ? Carbon::parse($current->min('tanggal'))->year : date('Y'),
                'kontraktor' => $first->kontraktor,
                'konsultan' => $first->konsultan,
                'pic' => $first->pic,
                'tanggal_mulai' => Carbon::parse($current->min('tanggal')),
                'tanggal_selesai' => Carbon::parse($current->max('tanggal')),
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
