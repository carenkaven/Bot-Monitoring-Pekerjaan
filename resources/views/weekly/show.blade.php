@extends('layouts.app')

@section('content')

    <div class="space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6">
            <div>
                <h2 class="text-title-md2 font-bold text-black dark:text-white">
                    Detail Laporan Mingguan
                </h2>
                <p class="text-sm mt-1 text-slate-500 dark:text-slate-400">
                    Proyek: <span class="font-semibold text-black dark:text-white">{{ $summary['nama_proyek'] }}</span>
                </p>
            </div>

            <div>
                <a href="{{ route('weekly.index') }}"
                    class="inline-flex items-center justify-center gap-2.5 rounded-md bg-slate-600 py-2.5 px-6 text-center font-medium text-white hover:bg-opacity-90 dark:bg-slate-700 transition">
                    ← Kembali
                </a>
            </div>
        </div>

        {{-- INFORMASI --}}
        <div class="rounded-xl border border-stroke bg-white p-6 shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10">
                <div>
                    <h4 class="mb-4 text-title-sm font-semibold text-black dark:text-white">Informasi Utama</h4>
                    <div class="flex flex-col gap-3">
                        <div class="flex justify-between border-b border-stroke pb-3 dark:border-strokedark">
                            <span class="text-sm text-slate-500 dark:text-slate-400">Nama Proyek</span>
                            <span
                                class="text-sm font-medium text-black dark:text-white text-right">{{ $summary['nama_proyek'] }}</span>
                        </div>
                        <div class="flex justify-between border-b border-stroke pb-3 dark:border-strokedark">
                            <span class="text-sm text-slate-500 dark:text-slate-400">Minggu Ke</span>
                            <span class="text-sm font-medium text-black dark:text-white text-right">Minggu
                                {{ $summary['minggu_ke'] }}</span>
                        </div>
                        <div class="flex justify-between border-b border-stroke pb-3 dark:border-strokedark">
                            <span class="text-sm text-slate-500 dark:text-slate-400">Periode</span>
                            <span class="text-sm font-medium text-black dark:text-white text-right">
                                {{ \Carbon\Carbon::parse($summary['tanggal_mulai'])->translatedFormat('d F Y') }} -
                                {{ \Carbon\Carbon::parse($summary['tanggal_selesai'])->translatedFormat('d F Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between border-b border-stroke pb-3 dark:border-strokedark">
                            <span class="text-sm text-slate-500 dark:text-slate-400">Lokasi</span>
                            <span
                                class="text-sm font-medium text-black dark:text-white text-right">{{ $summary['lokasi'] }}</span>
                        </div>
                        <div class="flex justify-between pb-1">
                            <span class="text-sm text-slate-500 dark:text-slate-400">PIC</span>
                            <span
                                class="text-sm font-medium text-black dark:text-white text-right">{{ $summary['pic'] }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="mb-4 text-title-sm font-semibold text-black dark:text-white">Detail Kegiatan</h4>
                    <div class="flex flex-col gap-3">
                        <div class="flex justify-between border-b border-stroke pb-3 dark:border-strokedark">
                            <span class="text-sm text-slate-500 dark:text-slate-400">Kontraktor</span>
                            <span
                                class="text-sm font-medium text-black dark:text-white text-right">{{ $summary['kontraktor'] ?: '-' }}</span>
                        </div>
                        <div class="flex justify-between border-b border-stroke pb-3 dark:border-strokedark">
                            <span class="text-sm text-slate-500 dark:text-slate-400">Konsultan</span>
                            <span
                                class="text-sm font-medium text-black dark:text-white text-right">{{ $summary['konsultan'] ?: '-' }}</span>
                        </div>
                        <div class="flex justify-between border-b border-stroke pb-3 dark:border-strokedark">
                            <span class="text-sm text-slate-500 dark:text-slate-400">Kegiatan Utama</span>
                            <span
                                class="text-sm font-medium text-black dark:text-white text-right">{{ $summary['kegiatan'] }}</span>
                        </div>
                        <div class="flex justify-between pb-1">
                            <span class="text-sm text-slate-500 dark:text-slate-400">Sub Kegiatan</span>
                            <span
                                class="text-sm font-medium text-black dark:text-white text-right">{{ $summary['sub_kegiatan'] ?: '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- STATISTIK --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            <div
                class="rounded-xl border border-stroke bg-blue-600 p-5 shadow-default dark:border-strokedark dark:bg-blue-700 hover:shadow-lg transition">
                <div class="text-sm font-medium text-blue-100">Total Harian</div>
                <div class="mt-2 flex items-baseline gap-2">
                    <h4 class="text-title-lg font-bold text-white">{{ $summary['total_laporan'] }}</h4>
                    <span class="text-sm text-blue-200">Laporan</span>
                </div>
            </div>

            <div
                class="rounded-xl border border-stroke bg-green-600 p-5 shadow-default dark:border-strokedark dark:bg-green-700 hover:shadow-lg transition">
                <div class="text-sm font-medium text-green-100">Disetujui</div>
                <div class="mt-2 flex items-baseline gap-2">
                    <h4 class="text-title-lg font-bold text-white">{{ $summary['disetujui'] }}</h4>
                    <span class="text-sm text-green-200">Laporan</span>
                </div>
            </div>

            <div
                class="rounded-xl border border-stroke bg-red-600 p-5 shadow-default dark:border-strokedark dark:bg-red-700 hover:shadow-lg transition">
                <div class="text-sm font-medium text-red-100">Ditolak</div>
                <div class="mt-2 flex items-baseline gap-2">
                    <h4 class="text-title-lg font-bold text-white">{{ $summary['ditolak'] }}</h4>
                    <span class="text-sm text-red-200">Laporan</span>
                </div>
            </div>

            <div
                class="rounded-xl border border-stroke bg-yellow-500 p-5 shadow-default dark:border-strokedark dark:bg-yellow-600 hover:shadow-lg transition">
                <div class="text-sm font-medium text-yellow-50">Menunggu</div>
                <div class="mt-2 flex items-baseline gap-2">
                    <h4 class="text-title-lg font-bold text-white">{{ $summary['menunggu'] }}</h4>
                    <span class="text-sm text-yellow-100">Laporan</span>
                </div>
            </div>
        </div>

        {{-- TABEL HARIAN --}}
        <div
            class="rounded-xl border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5">
            <h4 class="mb-4 text-title-sm font-bold text-black dark:text-white">Daftar Kemajuan Harian</h4>
            <div class="max-w-full overflow-x-auto pb-4">
                <table class="w-full table-auto">
                    <thead class="bg-gray-50 dark:bg-meta-4 border-b border-stroke dark:border-strokedark">
                        <tr class="text-left text-sm font-semibold text-black dark:text-white">
                            <th class="min-w-[120px] py-4 px-4 font-medium">Tanggal</th>
                            <th class="min-w-[250px] py-4 px-4 font-medium">Pekerjaan</th>
                            <th class="py-4 px-4 font-medium text-center">Status</th>
                            <th class="py-4 px-4 font-medium text-center">Foto</th>
                            <th class="py-4 px-4 font-medium text-center lg:min-w-[100px]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stroke dark:divide-strokedark">
                        @forelse($laporans as $laporan)
                            <tr class="hover:bg-gray-50 dark:hover:bg-meta-4/50 transition">
                                <td class="py-4 px-4 text-sm font-medium text-black dark:text-white">
                                    {{ $laporan->tanggal->format('d M Y') }}
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-800 dark:text-gray-200">
                                    {{ Str::limit($laporan->pekerjaan, 60) }}
                                </td>
                                <td class="py-4 px-4 text-center text-sm">
                                    @if($laporan->status == "Menunggu")
                                        <span
                                            class="inline-flex rounded-full bg-yellow-100 py-1 px-3 text-xs font-semibold text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500">Menunggu</span>
                                    @elseif($laporan->status == "Disetujui")
                                        <span
                                            class="inline-flex rounded-full bg-green-100 py-1 px-3 text-xs font-semibold text-green-800 dark:bg-green-900/30 dark:text-green-400">Disetujui</span>
                                    @else
                                        <span
                                            class="inline-flex rounded-full bg-red-100 py-1 px-3 text-xs font-semibold text-red-800 dark:bg-red-900/30 dark:text-red-400">Ditolak</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-center text-sm font-medium text-slate-500 dark:text-slate-400">
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded bg-gray-100 py-1 px-2.5 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                                        <svg class="fill-current" width="12" height="12" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7 6C7 5.44772 7.44772 5 8 5H12C12.5523 5 13 5.44772 13 6V7H16C17.1046 7 18 7.89543 18 9V16C18 17.1046 17.1046 18 16 18H4C2.89543 18 2 17.1046 2 16V9C2 7.89543 2.89543 7 4 7H7V6ZM8 7H12V6.5C12 6.22386 11.7761 6 11.5 6H8.5C8.22386 6 8 6.22386 8 6.5V7ZM4 8C3.44772 8 3 8.44772 3 9V16C3 16.5523 3.44772 17 4 17H16C16.5523 17 17 16.5523 17 16V9C17 8.44772 16.5523 8 16 8H4ZM10 15C8.34315 15 7 13.6569 7 12C7 10.3431 8.34315 9 10 9C11.6569 9 13 10.3431 13 12C13 13.6569 11.6569 15 10 15ZM10 14C11.1046 14 12 13.1046 12 12C12 10.8954 11.1046 10 10 10C8.89543 10 8 10.8954 8 12C8 13.1046 8.89543 14 10 14Z"
                                                fill="currentColor"></path>
                                        </svg>
                                        {{ $laporan->fotos->count() }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <a href="{{ route('pdf.harian', $laporan->id) }}" target="_blank"
                                        class="inline-flex rounded-lg bg-red-500/10 py-1.5 px-4 text-sm font-medium text-red-600 hover:bg-red-500 hover:text-white dark:bg-red-500/20 dark:text-red-400 dark:hover:bg-red-500 dark:hover:text-white transition">PDF</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-gray-500 dark:text-gray-400">Belum ada laporan
                                    harian pada minggu ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection