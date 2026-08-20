@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Detail Laporan Harian
        </h2>
        <p class="text-sm mt-1 text-slate-500 dark:text-slate-400">
            {{ $laporan->nama_proyek }} &middot; {{ $laporan->tanggal->format('d M Y') }}
        </p>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('laporan.index') }}" class="inline-flex items-center justify-center rounded-full bg-slate-100 py-2.5 px-6 font-medium text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700 transition">
            Kembali
        </a>
        <button type="button" onclick="pilihJenisLaporanHarian('{{ route('pdf.harian', $laporan) }}', '{{ route('excel.harian', $laporan) }}', '{{ route('pdf.harian.baru', $laporan) }}', '{{ route('excel.harian.baru', $laporan) }}')" class="inline-flex items-center justify-center rounded-full bg-orange-500 py-2.5 px-6 font-medium text-white hover:bg-orange-600 transition shadow-sm hover:shadow-md">
            Cetak Laporan
        </button>
        @if($laporan->status==='Menunggu')
        <a href="{{ route('verifikasi.show', $laporan) }}" class="inline-flex items-center justify-center rounded-full bg-emerald-500 py-2.5 px-6 font-medium text-white hover:bg-emerald-600 transition shadow-sm hover:shadow-md">
            Verifikasi
        </a>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
    
    <!-- Bagian Kiri (Detail Laporan) -->
    <div class="xl:col-span-2 flex flex-col gap-6">
        
        <!-- Informasi Proyek -->
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                <h3 class="font-bold text-gray-800 dark:text-white">Informasi Proyek</h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                    @foreach([
                        'Nama Proyek' => $laporan->nama_proyek,
                        'Kegiatan' => $laporan->kegiatan,
                        'Sub Kegiatan' => $laporan->sub_kegiatan,
                        'Pekerjaan' => $laporan->pekerjaan,
                        'Lokasi' => $laporan->lokasi,
                        'Kontraktor / Kontraktor Pelaksana' => $laporan->kontraktor,
                        'Konsultan' => $laporan->konsultan,
                        'PIC' => $laporan->pic,
                        'Minggu Ke' => $laporan->minggu_ke,
                        'Tanggal' => $laporan->tanggal->format('d M Y'),
                    ] as $k => $v)
                    <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-800/50">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1">{{ $k }}</dt>
                        <dd class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $v ?: '-' }}</dd>
                    </div>
                    @endforeach
                </dl>
            </div>
        </div>

        <!-- Material & Alat (Grid 2 Kolom) -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <!-- Material -->
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                    <h3 class="font-bold text-gray-800 dark:text-white">Material</h3>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="text-left text-xs font-medium text-gray-400 dark:text-gray-500">
                                <th class="pb-2">Material</th>
                                <th class="pb-2">Vol</th>
                                <th class="pb-2">Satuan</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm font-medium text-gray-800 dark:text-gray-200">
                            @forelse($laporan->materials as $m)
                            <tr class="border-t border-gray-100 dark:border-gray-800">
                                <td class="py-2">{{ $m->nama_material }}</td>
                                <td class="py-2">{{ $m->volume }}</td>
                                <td class="py-2">{{ $m->satuan }}</td>
                            </tr>
                            @empty
                            <tr class="border-t border-gray-100 dark:border-gray-800">
                                <td colspan="3" class="py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada material.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Alat -->
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                    <h3 class="font-bold text-gray-800 dark:text-white">Alat</h3>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="text-left text-xs font-medium text-gray-400 dark:text-gray-500">
                                <th class="pb-2">Nama Alat</th>
                                <th class="pb-2">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm font-medium text-gray-800 dark:text-gray-200">
                            @forelse($laporan->alats as $a)
                            <tr class="border-t border-gray-100 dark:border-gray-800">
                                <td class="py-2">{{ $a->nama_alat }}</td>
                                <td class="py-2">{{ $a->jumlah }}</td>
                            </tr>
                            @empty
                            <tr class="border-t border-gray-100 dark:border-gray-800">
                                <td colspan="2" class="py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada alat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tenaga Kerja -->
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                <h3 class="font-bold text-gray-800 dark:text-white">Tenaga Kerja</h3>
            </div>
            <div class="p-6">
                @if($laporan->tenagas->isNotEmpty())
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                    @foreach($laporan->tenagas as $t)
                        @if($t->jenis_tenaga)
                            <div class="flex min-h-[104px] flex-col items-center justify-center rounded-xl border border-blue-200 bg-blue-50 px-3 py-4 text-center text-blue-600 transition hover:border-blue-300 hover:bg-blue-100 dark:border-blue-900 dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/30">
                                <span class="line-clamp-2 text-[11px] font-bold uppercase leading-tight">{{ $t->jenis_tenaga }}</span>
                                <span class="mt-2 text-2xl font-bold leading-none">{{ $t->jumlah }}</span>
                                <span class="mt-1 text-[10px] font-medium uppercase text-blue-400">{{ $t->satuan ?: 'org' }}</span>
                            </div>
                        @else
                            @php
                                $fallback = [
                                    'Pekerja' => $t->pekerja,
                                    'Tukang' => $t->tukang,
                                    'Mandor' => $t->mandor,
                                    'Pelaksana' => $t->pelaksana
                                ];
                            @endphp
                            @foreach($fallback as $label => $jumlah)
                                @if((int)$jumlah > 0)
                                    <div class="flex min-h-[104px] flex-col items-center justify-center rounded-xl border border-blue-200 bg-blue-50 px-3 py-4 text-center text-blue-600 transition hover:border-blue-300 hover:bg-blue-100 dark:border-blue-900 dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/30">
                                        <span class="line-clamp-2 text-[11px] font-bold uppercase leading-tight">{{ $label }}</span>
                                        <span class="mt-2 text-2xl font-bold leading-none">{{ $jumlah }}</span>
                                        <span class="mt-1 text-[10px] font-medium uppercase text-blue-400">org</span>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </div>
                @else
                <p class="text-center text-gray-500 dark:text-gray-400 text-sm">Tidak ada data tenaga kerja.</p>
                @endif
            </div>
        </div>

        <!-- Dokumentasi Foto -->
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                <h3 class="font-bold text-gray-800 dark:text-white">Dokumentasi Foto</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @forelse($laporan->fotos as $f)
                    <div class="rounded-lg border border-gray-100 border-opacity-50 bg-gray-50 dark:border-gray-800 dark:bg-gray-800/50 overflow-hidden shadow-sm">
                        <img src="{{ asset('storage/'.$f->foto) }}" class="h-40 w-full object-cover">
                        @if($f->keterangan)
                        <div class="p-3">
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $f->keterangan }}</p>
                        </div>
                        @endif
                    </div>
                    @empty
                    <div class="col-span-full rounded-lg border border-dashed border-gray-300 py-10 text-center dark:border-gray-700">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada dokumentasi.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div> <!-- /Bagian Kiri -->

    <!-- Bagian Kanan (Sidebar info) -->
    <div class="flex flex-col gap-6">
        
        <!-- Status Panel -->
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                <h3 class="font-bold text-gray-800 dark:text-white">Status Laporan</h3>
            </div>
            <div class="p-6 text-center">
                @if($laporan->status=="Menunggu")
                    <span class="inline-flex rounded-full bg-yellow-100 py-2 px-6 text-sm font-semibold text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500">Menunggu</span>
                @elseif($laporan->status=="Disetujui")
                    <span class="inline-flex rounded-full bg-green-100 py-2 px-6 text-sm font-semibold text-green-800 dark:bg-green-900/30 dark:text-green-400">Disetujui</span>
                @else
                    <span class="inline-flex rounded-full bg-red-100 py-2 px-6 text-sm font-semibold text-red-800 dark:bg-red-900/30 dark:text-red-400">Ditolak</span>
                @endif
                
                @if($laporan->catatan)
                <div class="mt-4 rounded-lg bg-gray-50 p-4 text-left border border-gray-100 dark:border-gray-800 dark:bg-gray-800/50">
                    <span class="block text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 mb-2">Catatan</span>
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $laporan->catatan }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Pengisi Laporan (Karyawan) -->
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                <h3 class="font-bold text-gray-800 dark:text-white">Pengirim</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-blue-600 text-xl font-bold text-white shadow-sm">
                        {{ strtoupper(substr($laporan->karyawan->nama ?? '?', 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-800 dark:text-white">{{ $laporan->karyawan->nama ?? '-' }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $laporan->karyawan->jabatan ?? '-' }}</p>
                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">{{ $laporan->karyawan->no_hp ?? '-' }}</p>
                    </div>
                </div>
                <div class="mt-4 border-t border-gray-100 dark:border-gray-800 pt-4">
                    <p class="text-xs font-semibold uppercase text-gray-400 dark:text-gray-500 mb-1">Dikirim Melalui WA Pada</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
                        {{ $laporan->created_at ? $laporan->created_at->format('d M Y, H:i:s') . ' WIB' : '-' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Tracker Verifikasi -->
        @if($laporan->verifikasi)
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                <h3 class="font-bold text-gray-800 dark:text-white">Riwayat Verifikasi</h3>
            </div>
            <div class="p-6 text-sm">
                <p class="mb-2"><span class="font-medium text-gray-500 dark:text-gray-400">Oleh:</span> <span class="font-semibold text-gray-800 dark:text-white">{{ $laporan->verifikasi->user->name ?? '-' }}</span></p>
                <p class="mb-2"><span class="font-medium text-gray-500 dark:text-gray-400">Tanggal:</span> <span class="text-gray-800 dark:text-white">{{ optional($laporan->verifikasi->tanggal_verifikasi)->format('d M Y H:i') }}</span></p>
                @if($laporan->verifikasi->catatan)
                <div class="mt-3">
                    <span class="block font-medium text-gray-500 dark:text-gray-400 mb-1">Catatan:</span>
                    <p class="text-gray-800 dark:text-gray-300 bg-gray-50 dark:bg-gray-800/50 p-3 rounded-md">{{ $laporan->verifikasi->catatan }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif

    </div> <!-- /Bagian Kanan -->

</div>
@endsection
