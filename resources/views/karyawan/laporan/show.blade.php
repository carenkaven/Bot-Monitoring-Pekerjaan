@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Detail Laporan Harian</h1>
            <p class="text-slate-500">{{ $laporan->nama_proyek }} · {{ $laporan->tanggal->format('d M Y') }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('laporan-saya.index') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-5 py-2.5 rounded-xl">Kembali</a>
            <a href="{{ route('pdf.harian',$laporan) }}" target="_blank" class="bg-rose-600 hover:bg-rose-700 text-white px-5 py-2.5 rounded-xl">Cetak PDF</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white rounded-3xl shadow-lg p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Informasi Proyek</h2>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                    @foreach([
                        'Nama Proyek'=>$laporan->nama_proyek,
                        'Kegiatan'=>$laporan->kegiatan,
                        'Sub Kegiatan'=>$laporan->sub_kegiatan,
                        'Pekerjaan'=>$laporan->pekerjaan,
                        'Lokasi'=>$laporan->lokasi,
                        'Kontraktor'=>$laporan->kontraktor,
                        'Konsultan'=>$laporan->konsultan,
                        'PIC'=>$laporan->pic,
                        'Minggu Ke'=>$laporan->minggu_ke,
                        'Tanggal'=>$laporan->tanggal->format('d M Y'),
                    ] as $k=>$v)
                    <div class="border-b border-slate-100 py-2">
                        <dt class="text-slate-500 text-xs uppercase">{{ $k }}</dt>
                        <dd class="text-slate-800 font-medium">{{ $v ?: '-' }}</dd>
                    </div>
                    @endforeach
                </dl>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-3xl shadow-lg p-6">
                    <h2 class="text-lg font-bold text-slate-800 mb-4">Material</h2>
                    <table class="w-full text-sm">
                        <thead class="text-left text-slate-500 border-b"><tr><th class="py-2">Material</th><th>Vol</th><th>Satuan</th></tr></thead>
                        <tbody>
                        @forelse($laporan->materials as $m)
                            <tr class="border-b"><td class="py-2">{{ $m->nama_material }}</td><td>{{ $m->volume }}</td><td>{{ $m->satuan }}</td></tr>
                        @empty
                            <tr><td colspan="3" class="text-slate-400 py-3 text-center">Tidak ada material.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bg-white rounded-3xl shadow-lg p-6">
                    <h2 class="text-lg font-bold text-slate-800 mb-4">Alat</h2>
                    <table class="w-full text-sm">
                        <thead class="text-left text-slate-500 border-b"><tr><th class="py-2">Nama Alat</th><th>Jumlah</th></tr></thead>
                        <tbody>
                        @forelse($laporan->alats as $a)
                            <tr class="border-b"><td class="py-2">{{ $a->nama_alat }}</td><td>{{ $a->jumlah }}</td></tr>
                        @empty
                            <tr><td colspan="2" class="text-slate-400 py-3 text-center">Tidak ada alat.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-lg p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Tenaga Kerja</h2>
                @forelse($laporan->tenagas as $t)
                <div class="grid grid-cols-4 gap-4 text-center">
                    @foreach(['Pekerja'=>$t->pekerja,'Tukang'=>$t->tukang,'Mandor'=>$t->mandor,'Pelaksana'=>$t->pelaksana] as $l=>$v)
                    <div class="bg-blue-50 rounded-2xl p-4">
                        <p class="text-xs text-slate-500">{{ $l }}</p>
                        <p class="text-2xl font-bold text-blue-700">{{ $v }}</p>
                    </div>
                    @endforeach
                </div>
                @empty
                <p class="text-slate-400 text-sm">Tidak ada data tenaga kerja.</p>
                @endforelse
            </div>

            <div class="bg-white rounded-3xl shadow-lg p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Dokumentasi Foto</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @forelse($laporan->fotos as $f)
                    <div class="rounded-2xl overflow-hidden bg-slate-100">
                        <img src="{{ asset('storage/'.$f->foto) }}" class="w-full h-40 object-cover">
                        @if($f->keterangan)<div class="p-2 text-xs text-slate-600">{{ $f->keterangan }}</div>@endif
                    </div>
                    @empty
                    <div class="col-span-full text-center py-10 text-slate-400 border-2 border-dashed border-slate-200 rounded-2xl">Belum ada dokumentasi.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-3xl shadow-lg p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Status Verifikasi</h2>
                <div class="text-center py-4">
                    @include('partials.status-badge', ['status' => $laporan->status])
                </div>
                @if($laporan->catatan)
                <div class="mt-4 bg-slate-50 rounded-xl p-3 text-sm text-slate-700">
                    <p class="text-xs uppercase text-slate-500 mb-1">Catatan</p>
                    {{ $laporan->catatan }}
                </div>
                @endif
            </div>

            @if($laporan->verifikasi)
            <div class="bg-white rounded-3xl shadow-lg p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Catatan Admin</h2>
                <p class="text-sm"><span class="text-slate-500">Diverifikasi oleh:</span> <b>{{ $laporan->verifikasi->user->name ?? '-' }}</b></p>
                <p class="text-sm mt-2"><span class="text-slate-500">Tanggal:</span> {{ optional($laporan->verifikasi->tanggal_verifikasi)->format('d M Y H:i') }}</p>
                <p class="text-sm mt-2"><span class="text-slate-500">Catatan:</span> {{ $laporan->verifikasi->catatan ?? '-' }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
