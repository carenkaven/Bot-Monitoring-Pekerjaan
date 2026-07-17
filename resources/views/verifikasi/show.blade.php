@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Detail Verifikasi Laporan
        </h2>
        <p class="text-sm mt-1 text-slate-500 dark:text-slate-400">Detail laporan pekerjaan harian proyek.</p>
    </div>
    
    <a href="{{ route('verifikasi.index') }}" class="inline-flex items-center justify-center rounded-md bg-gray-200 py-2.5 px-6 font-medium text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition">
        Kembali
    </a>
</div>

<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mb-6">
    <!-- Data Laporan -->
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
            <h3 class="font-bold text-gray-800 dark:text-white">Data Laporan</h3>
        </div>
        <div class="p-6">
            <div class="flex flex-col gap-3">
                <div class="flex justify-between border-b border-gray-100 pb-3 dark:border-gray-800">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal</span>
                    <span class="text-sm font-semibold text-gray-800 dark:text-white">{{ $laporan->tanggal }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-100 pb-3 dark:border-gray-800">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</span>
                    <span class="inline-flex rounded-full bg-yellow-100 py-1 px-3 text-xs font-semibold text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500">{{ $laporan->status }}</span>
                </div>
                <div class="flex flex-col pt-1">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Catatan Laporan</span>
                    <p class="text-sm text-gray-800 dark:text-gray-300 bg-gray-50 p-3 rounded-lg dark:bg-gray-800/50">{{ $laporan->catatan ?: '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Karyawan -->
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
            <h3 class="font-bold text-gray-800 dark:text-white">Data Karyawan</h3>
        </div>
        <div class="p-6">
            <div class="flex flex-col gap-3">
                <div class="flex justify-between border-b border-gray-100 pb-3 dark:border-gray-800">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama</span>
                    <span class="text-sm font-semibold text-gray-800 dark:text-white">{{ $laporan->karyawan->nama }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-100 pb-3 dark:border-gray-800">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Jabatan</span>
                    <span class="text-sm text-gray-800 dark:text-gray-300">{{ $laporan->karyawan->jabatan }}</span>
                </div>
                <div class="flex justify-between pt-1">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">WhatsApp</span>
                    <a href="https://wa.me/{{ $laporan->karyawan->no_hp }}" target="_blank" class="text-sm font-medium text-green-600 hover:text-green-700 hover:underline dark:text-green-500 dark:hover:text-green-400 ">{{ $laporan->karyawan->no_hp }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Informasi Proyek -->
<div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900 mb-6">
    <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h3 class="font-bold text-gray-800 dark:text-white">Informasi Proyek</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach([
                'Nama Proyek' => $laporan->nama_proyek,
                'Kegiatan' => $laporan->kegiatan,
                'Sub Kegiatan' => $laporan->sub_kegiatan,
                'Pekerjaan' => $laporan->pekerjaan,
                'Lokasi' => $laporan->lokasi,
                'Kontraktor' => $laporan->kontraktor,
                'Konsultan' => $laporan->konsultan,
                'PIC' => $laporan->pic,
                'Minggu Ke' => $laporan->minggu_ke,
            ] as $k => $v)
            <div class="border-b border-gray-100 pb-3 dark:border-gray-800">
                <span class="block text-xs font-semibold uppercase text-gray-400 dark:text-gray-500 mb-1">{{ $k }}</span>
                <span class="block text-sm font-medium text-gray-800 dark:text-gray-200">{{ $v ?: '-' }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Pekerjaan & Tenaga Kerja -->
<div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
            <h3 class="font-bold text-gray-800 dark:text-white">Pekerjaan</h3>
        </div>
        <div class="p-6">
            <ul class="flex flex-col gap-2">
                @forelse($laporan->pekerjaans as $item)
                <li class="rounded-lg bg-gray-50 px-4 py-3 text-sm font-medium text-gray-700 border border-gray-200 dark:border-gray-700 dark:bg-gray-800/50 dark:text-gray-300">
                    {{ $item->nama_pekerjaan }}
                </li>
                @empty
                <li class="rounded-lg border border-dashed border-gray-300 py-6 text-center text-sm text-gray-500 dark:border-gray-700 dark:text-gray-400">Tidak ada data pekerjaan.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
            <h3 class="font-bold text-gray-800 dark:text-white">Tenaga Kerja</h3>
        </div>
        <div class="p-6">
            @forelse($laporan->tenagas as $t)
            <div class="grid grid-cols-4 gap-4 text-center">
                @foreach(['Pekerja' => $t->pekerja, 'Tukang' => $t->tukang, 'Mandor' => $t->mandor, 'Pelaksana' => $t->pelaksana] as $l => $v)
                <div class="rounded-lg bg-blue-50 py-3 px-2 border border-blue-100 dark:border-blue-900/50 dark:bg-blue-900/20">
                    <span class="block text-xs font-semibold uppercase text-blue-600 dark:text-blue-400 mb-1">{{ $l }}</span>
                    <span class="block text-xl font-bold text-blue-700 dark:text-blue-300">{{ $v }}</span>
                </div>
                @endforeach
            </div>
            @empty
            <div class="rounded-lg border border-dashed border-gray-300 py-6 text-center text-sm text-gray-500 dark:border-gray-700 dark:text-gray-400">Tidak ada data tenaga kerja.</div>
            @endforelse
        </div>
    </div>
</div>

<!-- Material & Alat -->
<div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
            <h3 class="font-bold text-gray-800 dark:text-white">Material</h3>
        </div>
        <div class="p-6 overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="text-left text-xs font-medium text-gray-400 dark:text-gray-500 border-b border-gray-200 dark:border-gray-700 pb-2">
                        <th class="pb-3 px-2">Material</th>
                        <th class="pb-3 px-2">Volume</th>
                        <th class="pb-3 px-2">Satuan</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 dark:text-gray-300">
                    @forelse($laporan->materials as $m)
                    <tr class="border-b border-gray-50 dark:border-gray-800 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-800/30">
                        <td class="py-3 px-2">{{ $m->nama_material }}</td>
                        <td class="py-3 px-2">{{ $m->volume }}</td>
                        <td class="py-3 px-2">{{ $m->satuan }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-6 text-center text-gray-500 border border-dashed rounded dark:border-gray-700">Tidak ada data material.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
            <h3 class="font-bold text-gray-800 dark:text-white">Alat</h3>
        </div>
        <div class="p-6 overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="text-left text-xs font-medium text-gray-400 dark:text-gray-500 border-b border-gray-200 dark:border-gray-700 pb-2">
                        <th class="pb-3 px-2">Nama Alat</th>
                        <th class="pb-3 px-2">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 dark:text-gray-300">
                    @forelse($laporan->alats as $alat)
                    <tr class="border-b border-gray-50 dark:border-gray-800 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-800/30">
                        <td class="py-3 px-2">{{ $alat->nama_alat }}</td>
                        <td class="py-3 px-2">{{ $alat->jumlah }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="py-6 text-center text-gray-500 border border-dashed rounded dark:border-gray-700">Tidak ada data alat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Dokumentasi -->
<div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900 mb-6">
    <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
        <h3 class="font-bold text-gray-800 dark:text-white">Dokumentasi</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @forelse($laporan->fotos as $foto)
            <div class="group relative rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm aspect-square bg-gray-100 dark:bg-gray-800">
                <img src="{{ asset('storage/'.$foto->foto) }}" class="object-cover w-full h-full transition group-hover:scale-105" alt="Foto Proyek">
            </div>
            @empty
            <div class="col-span-full rounded-xl border border-dashed border-gray-300 py-12 text-center dark:border-gray-700">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tidak ada dokumentasi foto.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Aksi Verifikasi -->
<div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900 shadow-md">
    <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/30 rounded-t-xl">
        <h3 class="font-bold text-gray-800 dark:text-white text-lg">Aksi Verifikasi</h3>
    </div>
    <div class="p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start w-full">
            <form action="{{ route('verifikasi.tolak', $laporan->id) }}" method="POST" class="flex flex-col sm:flex-row gap-3 w-full">
                @csrf
                @method('PATCH')
                <div class="w-full sm:flex-1">
                    <input type="text" name="catatan" placeholder="Ketik alasan penolakan (Wajib jika menolak)..." required class="w-full rounded-lg border border-gray-300 bg-white py-3 px-4 outline-none transition focus:border-red-500 active:border-red-500 dark:border-gray-600 dark:bg-gray-900 dark:focus:border-red-500">
                </div>
                <button class="inline-flex justify-center items-center rounded-lg border border-red-500 py-3 px-8 font-medium text-red-500 hover:bg-red-500 hover:text-white transition whitespace-nowrap">
                    Tolak Laporan
                </button>
            </form>
            
            <form action="{{ route('verifikasi.setujui', $laporan->id) }}" method="POST" class="w-full sm:w-auto">
                @csrf
                @method('PATCH')
                <button class="inline-flex w-full justify-center items-center rounded-lg bg-green-500 py-3 px-10 font-medium text-white hover:bg-green-600 shadow-sm transition whitespace-nowrap">
                    Setujui Laporan
                </button>
            </form>
        </div>
    </div>
</div>

@endsection