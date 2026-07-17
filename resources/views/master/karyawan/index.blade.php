@extends('layouts.app')

@section('content')

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">

            <div>

                <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
                    Data Karyawan
                </h1>

                <p class="text-slate-500 dark:text-slate-400 mt-1">
                    Kelola seluruh data karyawan PT Reno Abirama Sakti.
                </p>

            </div>

            <a href="{{ route('karyawan.create') }}"
                class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-medium text-white hover:bg-blue-700 shadow-md shadow-blue-500/20 transition">
                + Tambah Karyawan
            </a>

        </div>

        {{-- Alert Success --}}
        @if(session('success'))

            <div class="bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-xl">

                {{ session('success') }}

            </div>

        @endif

        {{-- Card --}}
        <div
            class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-transparent dark:border-slate-700/50 overflow-hidden">

            {{-- Header Card --}}
            <div
                class="p-6 border-b border-gray-100 dark:border-slate-700/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">

                <div>

                    <h2 class="text-xl font-bold text-slate-800 dark:text-white">
                        Daftar Karyawan
                    </h2>

                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                        Total :
                        <b class="text-slate-800 dark:text-white">{{ $karyawans->total() }}</b>
                        Karyawan
                    </p>

                </div>

                <div class="relative">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" id="searchInput" placeholder="Cari nama karyawan..."
                        class="w-full sm:w-80 rounded-xl border-gray-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-white py-2.5 pl-10 pr-4 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                </div>

            </div>

            {{-- Table --}}
            <div class="max-w-full overflow-x-auto">
                <table class="w-full table-auto" id="tableKaryawan">
                    <thead class="bg-slate-50 dark:bg-slate-900/50 border-b border-gray-100 dark:border-slate-700/50">
                        <tr class="text-left text-sm font-semibold text-slate-600 dark:text-slate-300">
                            <th class="py-4 px-6 font-semibold whitespace-nowrap">No</th>
                            <th class="py-4 px-6 font-semibold whitespace-nowrap">Nama & Email</th>
                            <th class="py-4 px-6 font-semibold whitespace-nowrap">Jabatan</th>
                            <th class="py-4 px-6 font-semibold whitespace-nowrap">WhatsApp</th>
                            <th class="py-4 px-6 font-semibold whitespace-nowrap text-center">Status</th>
                            <th class="py-4 px-6 font-semibold whitespace-nowrap text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700/50">
                        @forelse($karyawans as $item)

                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/20 transition duration-200">

                                <td class="px-6 py-4 text-sm text-slate-700 dark:text-slate-300">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-500/20 flex items-center justify-center text-blue-700 dark:text-blue-400 font-bold uppercase text-sm shadow-sm ring-2 ring-white dark:ring-slate-800">
                                            {{ substr(trim($item->nama ?? ($item->user->name ?? '?')), 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800 dark:text-white">
                                                {{ $item->nama ?? ($item->user->name ?? 'Tanpa Nama') }}
                                            </div>
                                            <div class="text-xs font-medium text-slate-500 dark:text-slate-400 mt-0.5">
                                                {{ $item->email ? $item->email : 'Email tidak ditautkan' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700 dark:text-slate-300 font-medium whitespace-nowrap">
                                    {{ $item->jabatan }}
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700 dark:text-slate-300">
                                    {{ $item->no_hp }}
                                </td>

                                <td class="px-6 py-4 text-center text-sm font-medium">

                                    @if($item->status == 'aktif')

                                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">

                                            Aktif

                                        </span>

                                    @elseif($item->status == 'pending')

                                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm">

                                            Pending

                                        </span>

                                    @elseif($item->status == 'ditolak')

                                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">

                                            Ditolak

                                        </span>

                                    @else

                                        <span class="px-3 py-1 rounded-full bg-slate-200 text-slate-700 text-sm">

                                            Nonaktif

                                        </span>

                                    @endif

                                </td>

                                <td class="px-6 py-4 text-sm">

                                    <div class="flex justify-center gap-2 flex-wrap min-w-[120px]">

                                        @if($item->status == 'pending')

                                            <form action="{{ route('karyawan.approve', $item->id) }}" method="POST" class="inline">

                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    class="inline-flex rounded-lg bg-green-50 dark:bg-green-500/10 py-1.5 px-3 text-xs font-bold text-green-600 hover:bg-green-500 hover:text-white transition shadow-sm border border-green-200 dark:border-green-500/20">

                                                    Verifikasi

                                                </button>

                                            </form>

                                            <form action="{{ route('karyawan.reject', $item->id) }}" method="POST" class="inline"
                                                onsubmit="return confirm('Tolak pendaftaran karyawan ini?')">

                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    class="inline-flex rounded-lg bg-red-50 dark:bg-red-500/10 py-1.5 px-3 text-xs font-bold text-red-600 hover:bg-red-500 hover:text-white transition shadow-sm border border-red-200 dark:border-red-500/20">

                                                    Tolak

                                                </button>

                                            </form>

                                        @endif

                                        @if($item->status == 'aktif')

                                            <form action="{{ route('karyawan.nonaktif', $item->id) }}" method="POST" class="inline">

                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    class="inline-flex rounded-lg bg-orange-50 dark:bg-orange-500/10 py-1.5 px-3 text-xs font-bold text-orange-600 hover:bg-orange-500 hover:text-white transition shadow-sm border border-orange-200 dark:border-orange-500/20">

                                                    Nonaktif

                                                </button>

                                            </form>

                                        @endif

                                        <a href="{{ route('karyawan.edit', $item->id) }}"
                                            class="inline-flex rounded-lg bg-blue-50 dark:bg-blue-500/10 py-1.5 px-3 text-xs font-bold text-blue-600 hover:bg-blue-500 hover:text-white transition shadow-sm border border-blue-200 dark:border-blue-500/20">

                                            Edit

                                        </a>

                                        <form action="{{ route('karyawan.destroy', $item->id) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                class="inline-flex rounded-lg bg-red-50 dark:bg-red-500/10 py-1.5 px-3 text-xs font-bold text-red-600 hover:bg-red-500 hover:text-white transition shadow-sm border border-red-200 dark:border-red-500/20">

                                                Hapus

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="text-center py-10 text-gray-400">

                                    Belum ada data karyawan.

                                </td>

                            </tr>

                        @endforelse
                </table>

            </div>

            <div class="p-6">

                {{ $karyawans->links() }}

            </div>

        </div>

    </div>

    <script>

        document.getElementById('searchInput').addEventListener('keyup', function () {

            let filter = this.value.toLowerCase();

            let rows = document.querySelectorAll('#tableKaryawan tbody tr');

            rows.forEach(function (row) {

                let text = row.innerText.toLowerCase();

                row.style.display = text.includes(filter) ? '' : 'none';

            });

        });

    </script>

@endsection