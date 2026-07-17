@extends('layouts.app')

@section('content')

    <div class="space-y-6">

        <div class="flex justify-between items-center">

            <div>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-white">Laporan Saya</h1>
                <p class="text-gray-500 dark:text-gray-400">Daftar laporan harian yang Anda kirim melalui WhatsApp Bot.</p>
            </div>

        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 rounded-xl p-4">
                {{ session('success') }}
            </div>
        @endif

        <div
            class="rounded-xl border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5">
            <div class="max-w-full overflow-x-auto pb-4">
                <table class="w-full table-auto">
                    <thead class="bg-gray-50 dark:bg-meta-4 border-b border-stroke dark:border-strokedark">
                        <tr class="text-left text-sm font-semibold text-black dark:text-white">
                            <th class="py-4 px-2 font-medium">Tanggal</th>
                            <th class="py-4 px-2 font-medium">Nama Proyek</th>
                            <th class="py-4 px-2 font-medium">Lokasi</th>
                            <th class="py-4 px-2 font-medium text-center">Status</th>
                            <th class="py-4 px-2 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-stroke dark:divide-strokedark">

                        @forelse($laporans as $laporan)

                            <tr class="hover:bg-gray-50 dark:hover:bg-meta-4/50 transition">

                                <td class="py-4 px-2 text-black dark:text-white">
                                    {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d-m-Y') }}</td>

                                <td class="py-4 px-2">{{ $laporan->nama_proyek }}</td>

                                <td class="py-4 px-2">{{ $laporan->lokasi }}</td>

                                <td class="py-4 px-2 text-center">
                                    @include('partials.status-badge', ['status' => $laporan->status])
                                </td>

                                <td class="py-4 px-2 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('laporan-saya.show', $laporan->id) }}"
                                            class="inline-flex rounded bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-600 hover:bg-blue-600 hover:text-white transition dark:bg-blue-500/20 dark:text-blue-400 dark:hover:bg-blue-500 dark:hover:text-white">
                                            Detail
                                        </a>
                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center py-12 text-gray-400 dark:text-gray-500">
                                    Anda belum memiliki laporan.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

            @if($laporans->hasPages())
                <div class="mt-4 p-4 border-t border-gray-100 dark:border-gray-800">
                    {{ $laporans->links() }}
                </div>
            @endif

        </div>

    </div>

@endsection