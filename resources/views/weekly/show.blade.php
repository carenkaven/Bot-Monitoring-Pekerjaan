@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">

                Detail Laporan Mingguan

            </h1>

            <p class="text-gray-500">

                {{ $summary['nama_proyek'] }}

            </p>

        </div>

        <div>

            <a href="{{ route('weekly.index') }}"
               class="bg-slate-600 hover:bg-slate-700 text-white px-5 py-2 rounded-xl">

                ← Kembali

            </a>

        </div>

    </div>

    {{-- INFORMASI --}}
    <div class="bg-white rounded-2xl shadow p-6">

        <div class="grid grid-cols-2 gap-5">

            <div>

                <table class="w-full text-sm">

                    <tr>
                        <td class="font-semibold w-40">Nama Proyek</td>
                        <td>{{ $summary['nama_proyek'] }}</td>
                    </tr>

                    <tr>
                        <td class="font-semibold">Minggu</td>
                        <td>Minggu {{ $summary['minggu_ke'] }}</td>
                    </tr>

                    <tr>
                        <td class="font-semibold">Periode</td>
                        <td>

                            {{ \Carbon\Carbon::parse($summary['tanggal_mulai'])->translatedFormat('d F Y') }}

                            -

                            {{ \Carbon\Carbon::parse($summary['tanggal_selesai'])->translatedFormat('d F Y') }}

                        </td>
                    </tr>

                    <tr>
                        <td class="font-semibold">Lokasi</td>
                        <td>{{ $summary['lokasi'] }}</td>
                    </tr>

                    <tr>
                        <td class="font-semibold">PIC</td>
                        <td>{{ $summary['pic'] }}</td>
                    </tr>

                </table>

            </div>

            <div>

                <table class="w-full text-sm">

                    <tr>
                        <td class="font-semibold w-40">Kontraktor</td>
                        <td>{{ $summary['kontraktor'] }}</td>
                    </tr>

                    <tr>
                        <td class="font-semibold">Konsultan</td>
                        <td>{{ $summary['konsultan'] }}</td>
                    </tr>

                    <tr>
                        <td class="font-semibold">Kegiatan</td>
                        <td>{{ $summary['kegiatan'] }}</td>
                    </tr>

                    <tr>
                        <td class="font-semibold">Sub Kegiatan</td>
                        <td>{{ $summary['sub_kegiatan'] }}</td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-4 gap-5">

        <div class="bg-blue-600 rounded-xl text-white p-5">

            <div class="text-sm">

                Total Laporan

            </div>

            <div class="text-3xl font-bold">

                {{ $summary['total_laporan'] }}

            </div>

        </div>

        <div class="bg-green-600 rounded-xl text-white p-5">

            <div class="text-sm">

                Disetujui

            </div>

            <div class="text-3xl font-bold">

                {{ $summary['disetujui'] }}

            </div>

        </div>

        <div class="bg-red-600 rounded-xl text-white p-5">

            <div class="text-sm">

                Ditolak

            </div>

            <div class="text-3xl font-bold">

                {{ $summary['ditolak'] }}

            </div>

        </div>

        <div class="bg-yellow-500 rounded-xl text-white p-5">

            <div class="text-sm">

                Menunggu

            </div>

            <div class="text-3xl font-bold">

                {{ $summary['menunggu'] }}

            </div>

        </div>

    </div>

    {{-- TABEL HARIAN --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <table class="w-full">

            <thead class="bg-slate-100">

                <tr>

                    <th class="p-4">Tanggal</th>

                    <th>Pekerjaan</th>

                    <th>Status</th>

                    <th>Foto</th>

                    <th>PDF</th>

                </tr>

            </thead>

            <tbody>

                @foreach($laporans as $laporan)

                <tr class="border-t">

                    <td class="text-center">

                        {{ $laporan->tanggal->format('d M Y') }}

                    </td>

                    <td>

                        {{ $laporan->pekerjaan }}

                    </td>

                    <td class="text-center">

                        @if($laporan->status=='Disetujui')

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

                                Disetujui

                            </span>

                        @elseif($laporan->status=='Ditolak')

                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">

                                Ditolak

                            </span>

                        @else

                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">

                                Menunggu

                            </span>

                        @endif

                    </td>

                    <td class="text-center">

                        {{ $laporan->fotos->count() }}

                    </td>

                    <td class="text-center">

                        <a href="{{ route('pdf.harian',$laporan->id) }}"

                           target="_blank"

                           class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg">

                            PDF

                        </a>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection