@extends('layouts.app')

@section('content')

    <div class="space-y-6">

        @php
            $monthsList = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];
            $monthName = $monthsList[(int)$month] ?? '';
        @endphp

        {{-- HEADER --}}
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6">
            <div>
                <h2 class="text-title-md2 font-bold text-black dark:text-white">
                    Laporan Minggu Ke-{{ $summary['minggu_ke'] }} (Bulan {{ $monthName }} {{ $year }})
                </h2>
                <p class="text-sm mt-1 text-slate-500 dark:text-slate-400">
                    @if($summary['nama_proyek'] === 'all')
                        Menampilkan laporan dari <span class="font-semibold text-black dark:text-white">semua proyek</span>
                    @else
                        Proyek: <span class="font-semibold text-black dark:text-white">{{ $summary['nama_proyek'] }}</span>
                    @endif
                </p>
            </div>

            <div class="flex flex-wrap items-center justify-end gap-3 mt-4 sm:mt-0">
                <a href="{{ route('weekly.index') }}"
                    class="inline-flex items-center justify-center rounded-md border border-stroke py-2.5 px-5 text-center font-medium hover:bg-gray dark:border-strokedark dark:hover:bg-meta-4 transition">
                    ← Kembali
                </a>

                @if($summary['nama_proyek'] !== 'all')
                    <button type="button" onclick="pilihJenisLaporanMingguan('{{ route('pdf.weekly', ['minggu' => $summary['minggu_ke'], 'proyek' => $summary['nama_proyek'], 'year' => $year, 'month' => $month]) }}', '{{ route('excel.weekly', ['minggu' => $summary['minggu_ke'], 'proyek' => $summary['nama_proyek'], 'year' => $year, 'month' => $month]) }}', '{{ route('pdf.weekly.physical', ['minggu' => $summary['minggu_ke'], 'proyek' => $summary['nama_proyek'], 'year' => $year, 'month' => $month]) }}', '{{ route('excel.weekly.physical', ['minggu' => $summary['minggu_ke'], 'proyek' => $summary['nama_proyek'], 'year' => $year, 'month' => $month]) }}')" class="inline-flex items-center justify-center rounded-md bg-blue-600 py-2.5 px-5 text-sm font-medium text-white hover:bg-blue-700 transition">Cetak Mingguan</button>
                @else
                    <button type="button" onclick="cetakDariSemuaProyek({{ $summary['minggu_ke'] }})" class="inline-flex items-center justify-center rounded-md bg-blue-600 py-2.5 px-5 text-sm font-medium text-white hover:bg-blue-700 transition">Cetak Mingguan</button>
                @endif
            </div>
        </div>

        {{-- INFORMASI --}}
        @if($summary['nama_proyek'] !== 'all')
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
                        <div class="flex justify-between border-b border-stroke pb-3 dark:border-strokedark">
                            <span class="text-sm text-slate-500 dark:text-slate-400">Tahun Anggaran</span>
                            <span
                                class="text-sm font-medium text-black dark:text-white text-right">{{ $summary['tahun_anggaran'] }}</span>
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
                            <span class="text-sm text-slate-500 dark:text-slate-400">Kontraktor / Kontraktor Pelaksana</span>
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
        @endif

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

        {{-- REKAP ITEM PEKERJAAN --}}
        @if($summary['nama_proyek'] !== 'all')
        <div
            class="rounded-xl border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5">
            <h4 class="mb-4 text-title-sm font-bold text-black dark:text-white">Rekap Item Pekerjaan (Sesuai PDF Laporan Fisik)</h4>
            <div class="max-w-full overflow-x-auto pb-4">
                <table class="w-full table-auto">
                    <thead class="bg-gray-50 dark:bg-meta-4 border-b border-stroke dark:border-strokedark">
                        <tr class="text-left text-sm font-semibold text-black dark:text-white">
                            <th class="w-[50px] py-3 px-4 font-medium text-center">NO</th>
                            <th class="min-w-[250px] py-3 px-4 font-medium">ITEM PEKERJAAN</th>
                            <th class="py-3 px-4 font-medium text-center">BOBOT S/D MINGGU INI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stroke dark:divide-strokedark">
                        @forelse($rekapFisik as $row)
                            @if(!empty($row['is_header']))
                                <tr class="bg-gray-100 dark:bg-meta-4/30">
                                    <td class="py-3 px-4 text-left font-bold text-black dark:text-white pl-4">{{ $row['no'] }}</td>
                                    <td class="py-3 px-4 font-bold text-black dark:text-white" colspan="2">{{ $row['item'] }}</td>
                                </tr>
                            @else
                                <tr class="hover:bg-gray-50 dark:hover:bg-meta-4/50 transition text-sm">
                                    <td class="py-3 px-4 text-right text-black dark:text-white pr-4">{{ $row['no'] }}</td>
                                    <td class="py-3 px-4 text-gray-800 dark:text-gray-200">{{ $row['item'] }}</td>
                                    <td class="py-3 px-4 text-center text-gray-800 dark:text-gray-200">{{ number_format($row['sampai_bobot'] * 100, 3) }}%</td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-6 text-gray-500 dark:text-gray-400">Belum ada item pekerjaan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- TABEL HARIAN --}}
        <div
            class="rounded-xl border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                <h4 class="text-title-sm font-bold text-black dark:text-white">Daftar Kemajuan Harian</h4>
                <div class="mt-3 sm:mt-0 relative w-full sm:w-64">
                    <input type="text" id="searchInput" placeholder="Cari tanggal, proyek..." class="w-full rounded border border-stroke bg-transparent py-2 pl-10 pr-4 outline-none focus:border-blue-500 dark:border-form-strokedark dark:bg-form-input dark:focus:border-blue-500 text-black dark:text-white transition">
                    <span class="absolute left-3 top-2.5 text-slate-400">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </div>
            </div>
            <div class="max-w-full overflow-x-auto pb-4">
                <table class="w-full table-auto" id="tabelHarian">
                    <thead class="bg-gray-50 dark:bg-meta-4 border-b border-stroke dark:border-strokedark">
                        <tr class="text-left text-sm font-semibold text-black dark:text-white">
                            <th class="min-w-[120px] py-4 px-4 font-medium cursor-pointer hover:bg-gray-200 dark:hover:bg-meta-4/80 transition group sortable" title="Urutkan berdasarkan Tanggal">Tanggal <span class="inline-block ml-1 opacity-0 group-hover:opacity-100 transition sort-icon">⇅</span></th>
                            <th class="min-w-[150px] py-4 px-4 font-medium cursor-pointer hover:bg-gray-200 dark:hover:bg-meta-4/80 transition group sortable" title="Urutkan berdasarkan Proyek">Proyek <span class="inline-block ml-1 opacity-0 group-hover:opacity-100 transition sort-icon">⇅</span></th>
                            <th class="min-w-[250px] py-4 px-4 font-medium cursor-pointer hover:bg-gray-200 dark:hover:bg-meta-4/80 transition group sortable" title="Urutkan berdasarkan Pekerjaan">Pekerjaan <span class="inline-block ml-1 opacity-0 group-hover:opacity-100 transition sort-icon">⇅</span></th>
                            <th class="py-4 px-4 font-medium text-center cursor-pointer hover:bg-gray-200 dark:hover:bg-meta-4/80 transition group sortable" title="Urutkan berdasarkan Status">Status <span class="inline-block ml-1 opacity-0 group-hover:opacity-100 transition sort-icon">⇅</span></th>
                            <th class="py-4 px-4 font-medium text-center">Foto</th>
                            @if($summary['nama_proyek'] === 'all')
                                <th class="py-4 px-4 font-medium text-center lg:min-w-[100px]">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stroke dark:divide-strokedark" id="tableBody">
                        @forelse($laporans as $laporan)
                            <tr class="hover:bg-gray-50 dark:hover:bg-meta-4/50 transition">
                                <td class="py-4 px-4 text-sm font-medium text-black dark:text-white">
                                    {{ $laporan->tanggal->format('d M Y') }}
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-800 dark:text-gray-200">
                                    {{ $laporan->nama_proyek }}
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
                                @if($summary['nama_proyek'] === 'all')
                                <td class="py-4 px-4 text-center align-middle">
                                    <div class="flex flex-col gap-1.5">
                                        <a href="{{ route('laporan.show', $laporan->id) }}" class="w-full inline-flex justify-center items-center rounded bg-blue-50 py-1.5 px-2 text-xs font-medium text-blue-600 hover:bg-blue-500 hover:text-white dark:bg-blue-500/10 dark:text-blue-400 transition">Detail</a>
                                    </div>
                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $summary['nama_proyek'] === 'all' ? '6' : '5' }}" class="text-center py-10 text-gray-500 dark:text-gray-400">Belum ada laporan
                                    harian pada minggu ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('tableBody');
        const headers = document.querySelectorAll('th.sortable');
        
        if(!tableBody) return;

        // --- Fitur Pencarian ---
        if(searchInput) {
            searchInput.addEventListener('keyup', function () {
                const filter = searchInput.value.toLowerCase();
                const rows = tableBody.getElementsByTagName('tr');
                for (let i = 0; i < rows.length; i++) {
                    // Hanya sembunyikan baris yang memiliki class hover:bg-gray-50 (mengabaikan baris "Belum ada laporan")
                    if(!rows[i].classList.contains('hover:bg-gray-50')) continue;
                    const rowText = rows[i].textContent.toLowerCase();
                    if (rowText.includes(filter)) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            });
        }

        // --- Fitur Sorting ---
        headers.forEach(header => {
            header.addEventListener('click', () => {
                const table = header.closest('table');
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr.hover\\:bg-gray-50'));
                
                // Cari index kolom
                const index = Array.from(header.parentElement.children).indexOf(header);
                
                // Tentukan arah sorting (Ascending / Descending)
                const isAsc = header.classList.contains('asc');
                const direction = isAsc ? -1 : 1;
                
                // Reset semua icon
                headers.forEach(h => { 
                    h.classList.remove('asc', 'desc'); 
                    h.querySelector('.sort-icon').textContent = '⇅';
                    h.querySelector('.sort-icon').classList.remove('opacity-100', 'text-blue-600', 'dark:text-blue-400');
                });
                
                // Set arah yang baru
                header.classList.add(isAsc ? 'desc' : 'asc');
                header.querySelector('.sort-icon').textContent = isAsc ? '↓' : '↑';
                header.querySelector('.sort-icon').classList.add('opacity-100', 'text-blue-600', 'dark:text-blue-400');

                rows.sort((a, b) => {
                    const aColText = a.children[index].textContent.trim();
                    const bColText = b.children[index].textContent.trim();
                    
                    // Deteksi jika format tanggal DD MMM YYYY (misal: 10 Aug 2026)
                    const dateA = new Date(aColText);
                    const dateB = new Date(bColText);
                    if(!isNaN(dateA) && !isNaN(dateB) && aColText.match(/^\d{2} [A-Za-z]{3} \d{4}$/)) {
                        return direction * (dateA - dateB);
                    }
                    
                    return direction * aColText.localeCompare(bColText);
                });

                rows.forEach(row => tbody.appendChild(row));
            });
        });
    });
</script>

<script>
    async function cetakDariSemuaProyek(minggu) {
        const proyeks = {!! json_encode($proyeks) !!};
        let inputOptions = {};
        
        // Cek jika tidak ada proyek
        if (!proyeks || proyeks.length === 0) {
            Swal.fire({
                icon: 'info',
                title: 'Kosong',
                text: 'Tidak ada proyek pada minggu ini.'
            });
            return;
        }

        proyeks.forEach(p => { inputOptions[p] = p; });

        const { value: proyek } = await Swal.fire({
            title: 'Pilih Proyek',
            text: `Pilih proyek mana yang ingin dicetak (Laporan Minggu ${minggu})`,
            input: 'select',
            inputOptions: inputOptions,
            inputPlaceholder: 'Pilih Proyek...',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Selanjutnya',
            cancelButtonText: 'Batal'
        });

        if (proyek) {
            const urlLamaPdf = `{{ url('pdf/weekly') }}/${minggu}/${encodeURIComponent(proyek)}?year={{ $year }}&month={{ $month }}`;
            const urlLamaExcel = `{{ url('excel/weekly') }}/${minggu}/${encodeURIComponent(proyek)}?year={{ $year }}&month={{ $month }}`;
            const urlBaruPdf = `{{ url('pdf/weekly-fisik') }}/${minggu}/${encodeURIComponent(proyek)}?year={{ $year }}&month={{ $month }}`;
            const urlBaruExcel = `{{ url('excel/weekly-fisik') }}/${minggu}/${encodeURIComponent(proyek)}?year={{ $year }}&month={{ $month }}`;
            
            pilihJenisLaporanMingguan(urlLamaPdf, urlLamaExcel, urlBaruPdf, urlBaruExcel);
        }
    }
</script>
@endpush
@endsection
