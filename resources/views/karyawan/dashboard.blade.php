@extends('layouts.app')

@section('content')

    <div class="space-y-6">

        <div>
            <h1 class="text-3xl font-bold text-slate-800 dark:text-white">Dashboard Karyawan</h1>
            <p class="mt-1 text-gray-500 dark:text-gray-400">
                Selamat datang, <b class="text-black dark:text-white">{{ Auth::user()->name }}</b>
                @if($karyawan->jabatan) &middot; {{ $karyawan->jabatan }} @endif
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="bg-white dark:bg-boxdark border border-stroke dark:border-strokedark rounded-3xl shadow-lg p-6">
                <p class="text-xs uppercase text-slate-500 dark:text-slate-400">Total Laporan</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-2">{{ $totalLaporan }}</p>
            </div>

            <div class="bg-white dark:bg-boxdark border border-stroke dark:border-strokedark rounded-3xl shadow-lg p-6">
                <p class="text-xs uppercase text-slate-500 dark:text-slate-400">Disetujui</p>
                <p class="text-3xl font-bold text-green-600 mt-2">{{ $disetujui }}</p>
            </div>

            <div class="bg-white dark:bg-boxdark border border-stroke dark:border-strokedark rounded-3xl shadow-lg p-6">
                <p class="text-xs uppercase text-slate-500 dark:text-slate-400">Menunggu</p>
                <p class="text-3xl font-bold text-yellow-500 mt-2">{{ $menunggu }}</p>
            </div>

            <div class="bg-white dark:bg-boxdark border border-stroke dark:border-strokedark rounded-3xl shadow-lg p-6">
                <p class="text-xs uppercase text-slate-500 dark:text-slate-400">Ditolak</p>
                <p class="text-3xl font-bold text-red-600 mt-2">{{ $ditolak }}</p>
            </div>

        </div>

        <div class="bg-white dark:bg-boxdark border border-stroke dark:border-strokedark rounded-3xl shadow-lg">

            <div class="p-6 border-b border-stroke dark:border-strokedark flex justify-between items-center">
                <h2 class="text-xl font-semibold text-black dark:text-white">5 Laporan Terakhir</h2>
                <a href="{{ route('laporan-saya.index') }}"
                    class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium">Lihat semua</a>
            </div>

            <div class="max-w-full overflow-x-auto pb-4">
                <table class="w-full table-auto">
                    <thead class="bg-gray-50 dark:bg-meta-4 border-b border-stroke dark:border-strokedark">
                        <tr class="text-left text-sm font-semibold text-black dark:text-white">
                            <th class="py-4 px-6 font-medium">Tanggal</th>
                            <th class="py-4 px-6 font-medium">Nama Proyek</th>
                            <th class="py-4 px-6 font-medium text-center">Status</th>
                            <th class="py-4 px-6 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stroke dark:divide-strokedark">
                        @forelse($laporanTerakhir as $laporan)
                            <tr class="hover:bg-gray-50 dark:hover:bg-meta-4/50 transition">
                                <td class="px-6 py-4 text-black dark:text-white">{{ $laporan->tanggal->format('d-m-Y') }}</td>
                                <td class="px-6 py-4">{{ $laporan->nama_proyek }}</td>
                                <td class="px-6 py-4 text-center">
                                    @include('partials.status-badge', ['status' => $laporan->status])
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('laporan-saya.show', $laporan->id) }}"
                                        class="inline-flex rounded-lg bg-blue-500/10 py-1.5 px-3.5 text-xs font-medium text-blue-600 hover:bg-blue-600 hover:text-white dark:bg-blue-500/20 dark:text-blue-400 dark:hover:bg-blue-600 dark:hover:text-white transition">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-10 text-gray-400">Belum ada laporan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>

@endsection