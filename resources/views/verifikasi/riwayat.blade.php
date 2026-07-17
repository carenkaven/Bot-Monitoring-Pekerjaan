@extends('layouts.app')

@section('content')

<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Riwayat Verifikasi
        </h2>
    </div>
</div>

<div class="overflow-hidden rounded-xl border border-gray-200 bg-white px-4 pb-3 pt-6 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:px-6">
    <div class="max-w-full overflow-x-auto">
        <table class="w-full table-auto">
            <thead class="border-y border-gray-200 dark:border-gray-800">
                <tr class="text-left text-sm font-semibold uppercase text-gray-800 dark:text-gray-300">
                    <th class="min-w-[120px] py-4 px-2 font-medium">Tanggal</th>
                    <th class="min-w-[150px] py-4 px-2 font-medium">Karyawan</th>
                    <th class="min-w-[150px] py-4 px-2 font-medium">Proyek</th>
                    <th class="py-4 px-2 font-medium text-center">Status</th>
                    <th class="py-4 px-2 font-medium text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($laporans as $laporan)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                    <td class="py-4 px-2 text-sm text-gray-800 dark:text-gray-200">
                        {{ $laporan->tanggal }}
                    </td>
                    <td class="py-4 px-2 text-sm text-gray-800 dark:text-gray-200">
                        {{ $laporan->karyawan->nama }}
                    </td>
                    <td class="py-4 px-2 text-sm text-gray-800 dark:text-gray-200">
                        {{ $laporan->nama_proyek }}
                    </td>
                    <td class="py-4 px-2 text-center text-sm">
                        @if($laporan->status=="Disetujui")
                            <span class="inline-flex rounded-full bg-green-100 py-1 px-3 text-xs font-semibold text-green-800 dark:bg-green-900/30 dark:text-green-400">Disetujui</span>
                        @else
                            <span class="inline-flex rounded-full bg-red-100 py-1 px-3 text-xs font-semibold text-red-800 dark:bg-red-900/30 dark:text-red-400">Ditolak</span>
                        @endif
                    </td>
                    <td class="py-4 px-2">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('verifikasi.show', $laporan->id) }}" class="inline-flex rounded-lg bg-blue-500/10 py-1.5 px-3 text-sm font-medium text-blue-600 hover:bg-blue-500 hover:text-white dark:bg-blue-500/20 dark:text-blue-400 dark:hover:bg-blue-500 dark:hover:text-white transition">Detail</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-10 text-gray-500 dark:text-gray-400">Belum ada riwayat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($laporans->hasPages())
    <div class="mt-4 p-4 border-t border-gray-100 dark:border-gray-800">
        {{ $laporans->links('pagination::tailwind') }}
    </div>
    @endif
</div>

@endsection