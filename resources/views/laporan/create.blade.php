@extends('layouts.app')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">
                {{ isset($laporan) ? 'Edit' : 'Tambah' }} Laporan Harian
            </h2>
            <p class="text-slate-500 dark:text-slate-400 mt-2 font-medium">
                Isi seluruh data laporan pekerjaan proyek pelaporan harian.
            </p>
        </div>
    </div>

    @if($errors->any())
        <div
            class="mb-6 flex w-full border-l-6 border-red-500 bg-red-500 bg-opacity-[15%] px-7 py-4 shadow-md dark:bg-[#1B1B24] dark:bg-opacity-30">
            <div class="mr-5 flex h-9 w-full max-w-[36px] items-center justify-center rounded-lg bg-red-500">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10.8248 11.6669C10.7415 11.6669 10.6582 11.6335 10.5915 11.5835L7.9915 9.46685L5.3915 11.5835C5.25817 11.6835 5.07484 11.6835 4.9415 11.5668C4.80817 11.4502 4.7915 11.2669 4.8915 11.1335L7.6915 8.01685C7.82484 7.86685 8.15817 7.86685 8.2915 8.01685L11.0915 11.1335C11.1915 11.2669 11.1748 11.4502 11.0415 11.5668C10.9748 11.6335 10.8915 11.6669 10.8248 11.6669Z"
                        fill="white"></path>
                    <path
                        d="M8 15.3333C3.96667 15.3333 0.666667 12.0333 0.666667 8C0.666667 3.96667 3.96667 0.666667 8 0.666667C12.0333 0.666667 15.3333 3.96667 15.3333 8C15.3333 12.0333 12.0333 15.3333 8 15.3333ZM8 2C4.68333 2 2 4.68333 2 8C2 11.3167 4.68333 14 8 14C11.3167 14 14 11.3167 14 8C14 4.68333 11.3167 2 8 2Z"
                        fill="white"></path>
                    <path
                        d="M7.99984 10.3335C7.63317 10.3335 7.33317 10.0335 7.33317 9.66683V5.00016C7.33317 4.6335 7.63317 4.3335 7.99984 4.3335C8.3665 4.3335 8.6665 4.6335 8.6665 5.00016V9.66683C8.6665 10.0335 8.3665 10.3335 7.99984 10.3335Z"
                        fill="white"></path>
                </svg>
            </div>
            <div class="w-full">
                <h5 class="mb-2 text-md font-bold text-[#B45454]">Terdapat Kesalahan Input</h5>
                <ul class="list-disc pl-4 text-sm font-medium text-[#CD5D5D]">
                    @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div
        class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-transparent dark:border-slate-700/50 overflow-hidden">
        <div class="border-b border-gray-100 py-6 px-8 dark:border-slate-700/50">
            <h3 class="font-bold text-xl text-slate-800 dark:text-white">
                Formulir Data Laporan
            </h3>
        </div>
        @php $l = $laporan ?? null; @endphp
        <form action="{{ $l ? route('laporan.update', $l) : route('laporan.store') }}" method="POST"
            data-testid="form-laporan">
            @csrf
            @if($l) @method('PUT') @endif

            <div class="p-8">
                <div class="mb-6 flex flex-col gap-6 sm:flex-row">
                    <div class="w-full sm:w-1/2">
                        <label class="font-semibold text-slate-700 dark:text-slate-300 block mb-2">Karyawan (PIC Bot) <span
                                class="text-red-500">*</span></label>
                        <select name="karyawan_id" required
                            class="w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white py-3 px-5 outline-none transition focus:ring-blue-500 dark:focus:ring-blue-500/50">
                            <option value="" disabled selected class="text-gray-500">-- Pilih Karyawan --</option>
                            @foreach($karyawans as $k)
                                <option value="{{ $k->id }}" @selected(old('karyawan_id', $l->karyawan_id ?? null) == $k->id)>
                                    {{ $k->nama }} ({{ $k->jabatan }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full sm:w-1/2">
                        <label class="font-semibold text-slate-700 dark:text-slate-300 block mb-2">Tanggal <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" required
                            value="{{ old('tanggal', optional($l?->tanggal)->format('Y-m-d')) }}"
                            class="w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white py-3 px-5 outline-none transition focus:ring-blue-500 dark:focus:ring-blue-500/50">
                    </div>
                </div>

                @php
                    $fields = [
                        ['nama_proyek', 'Nama Proyek', true],
                        ['kegiatan', 'Kegiatan', true],
                        ['sub_kegiatan', 'Sub Kegiatan', false],
                        ['pekerjaan', 'Pekerjaan', true],
                        ['lokasi', 'Lokasi', true],
                        ['kontraktor', 'Kontraktor', false],
                        ['konsultan', 'Konsultan', false],
                        ['pic', 'PIC', false],
                        ['minggu_ke', 'Minggu Ke', false],
                    ];
                    // Chunk ke dalam baris dengan 2 kolom
                    $chunks = array_chunk($fields, 2);
                @endphp

                @foreach($chunks as $chunk)
                    <div class="mb-6 flex flex-col gap-6 sm:flex-row">
                        @foreach($chunk as [$name, $label, $req])
                            <div class="w-full sm:w-1/2">
                                <label class="font-semibold text-slate-700 dark:text-slate-300 block mb-2">{{ $label }}
                                    @if($req)<span class="text-red-500">*</span>@endif</label>
                                <input type="text" name="{{ $name }}" value="{{ old($name, $l->$name ?? '') }}" @if($req) required
                                @endif
                                    class="w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white py-3 px-5 outline-none transition focus:ring-blue-500 dark:focus:ring-blue-500/50">
                            </div>
                        @endforeach
                    </div>
                @endforeach

                <div class="mb-6">
                    <label class="font-semibold text-slate-700 dark:text-slate-300 block mb-2">Status</label>
                    <select name="status"
                        class="w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white py-3 px-5 outline-none transition focus:ring-blue-500 dark:focus:ring-blue-500/50">
                        @foreach(['Menunggu', 'Disetujui', 'Ditolak'] as $s)
                            <option value="{{ $s }}" @selected(old('status', $l->status ?? 'Menunggu') === $s)>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-8">
                    <label class="font-semibold text-slate-700 dark:text-slate-300 block mb-2">Catatan</label>
                    <textarea name="catatan" rows="4" placeholder="Ketik catatan jika diperlukan"
                        class="w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white py-3 px-5 outline-none transition focus:ring-blue-500 dark:focus:ring-blue-500/50">{{ old('catatan', $l->catatan ?? '') }}</textarea>
                </div>

                <div class="flex items-center gap-4 justify-end pt-2">
                    <a href="{{ route('laporan.index') }}"
                        class="flex justify-center rounded-xl bg-slate-200 dark:bg-slate-700 px-8 py-3 font-semibold text-slate-800 dark:text-slate-100 hover:bg-slate-300 dark:hover:bg-slate-600 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex justify-center rounded-xl bg-blue-600 px-8 py-3 font-semibold text-white hover:bg-blue-700 shadow-md shadow-blue-500/20 transition">
                        {{ $l ? 'Update' : 'Simpan' }} Laporan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection