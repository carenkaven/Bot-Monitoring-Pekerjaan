@extends('layouts.app')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Verifikasi Laporan
            </h2>
            <p class="text-sm mt-1 text-slate-500 dark:text-slate-400">Daftar laporan pekerjaan yang menunggu persetujuan.
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 flex w-full border-l-6 border-green-500 bg-green-100 px-7 py-4 shadow-md dark:bg-green-900/30">
            <div class="mr-5 flex h-9 w-full max-w-[36px] items-center justify-center rounded-lg bg-green-500">
                <svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M15.2984 0.826822C15.6881 1.20015 15.6881 1.80554 15.2984 2.17887L5.89736 11.1893C5.50766 11.5626 4.87574 11.5626 4.48604 11.1893L0.865954 7.72004C0.476251 7.3467 0.47625 6.74132 0.865954 6.36798C1.25566 5.99465 1.88758 5.99465 2.27727 6.36798L5.1917 9.16147L13.8871 0.826822C14.2768 0.453488 14.9087 0.453488 15.2984 0.826822Z"
                        fill="white"></path>
                </svg>
            </div>
            <div class="w-full">
                <h5 class="mb-1 text-lg font-bold text-black dark:text-green-400">Sukses!</h5>
                <p class="text-base leading-relaxed text-black dark:text-white">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div
        class="rounded-xl border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5">
        <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-end">
            <form method="GET" class="flex w-full sm:w-1/2 md:w-1/3">
                <div class="relative w-full">
                    <button class="absolute left-4 top-1/2 -translate-y-1/2">
                        <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.16666 3.33332C5.94502 3.33332 3.33332 5.94502 3.33332 9.16666C3.33332 12.3883 5.94502 15 9.16666 15C12.3883 15 15 12.3883 15 9.16666C15 5.94502 12.3883 3.33332 9.16666 3.33332ZM1.66666 9.16666C1.66666 5.02452 5.02452 1.66666 9.16666 1.66666C13.3088 1.66666 16.6667 5.02452 16.6667 9.16666C16.6667 11.0261 15.9897 12.7276 14.8872 14.0487L18.0892 17.2508C18.4147 17.5762 18.4147 18.1039 18.0892 18.4293C17.7638 18.7548 17.2361 18.7548 16.9107 18.4293L13.7086 15.2273C12.4283 16.1437 10.8524 16.6667 9.16666 16.6667C5.02452 16.6667 1.66666 13.3088 1.66666 9.16666Z" />
                        </svg>
                    </button>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari proyek, lokasi..."
                        class="w-full rounded-md border border-gray-300 bg-transparent py-2 pl-12 pr-4 outline-none focus:border-blue-500 active:border-blue-500 dark:border-gray-700 dark:focus:border-blue-500">
                </div>
                <button type="submit"
                    class="ml-2 rounded-md bg-gray-200 px-4 py-2 font-medium text-gray-800 hover:bg-gray-300 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">Cari</button>
            </form>
        </div>

        <div class="max-w-full overflow-x-auto pb-4">
            <table class="w-full table-auto">
                <thead class="bg-gray-50 dark:bg-meta-4 border-b border-stroke dark:border-strokedark">
                    <tr class="text-left text-sm font-semibold text-black dark:text-white">
                        <th class="py-4 px-2 font-medium">Tanggal</th>
                        <th class="py-4 px-2 font-medium">Karyawan</th>
                        <th class="py-4 px-2 font-medium">Proyek</th>
                        <th class="py-4 px-2 font-medium">Lokasi</th>
                        <th class="py-4 px-2 font-medium">PIC</th>
                        <th class="w-16 py-4 px-2 font-medium text-center">Status</th>
                        <th class="w-32 py-4 px-2 font-medium text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stroke dark:divide-strokedark">
                    @forelse($laporans as $laporan)
                        <tr class="hover:bg-gray-50 dark:hover:bg-meta-4/50 transition">
                            <td class="py-4 px-2 text-sm text-black dark:text-white">
                                {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d-m-Y') }}
                            </td>
                            <td class="py-4 px-2 text-sm text-black dark:text-white">
                                {{ $laporan->karyawan->nama ?? '-' }}
                            </td>
                            <td class="py-4 px-2 text-sm font-semibold text-gray-800 dark:text-gray-200">
                                {{ $laporan->nama_proyek }}
                            </td>
                            <td class="py-4 px-2 text-sm text-gray-500 dark:text-gray-400">
                                {{ $laporan->lokasi }}
                            </td>
                            <td class="py-4 px-2 text-sm text-gray-500 dark:text-gray-400">
                                {{ $laporan->pic ?? '-' }}
                            </td>
                            <td class="py-4 px-2 text-center text-sm">
                                @if($laporan->status == "Menunggu")
                                    <span title="Menunggu" aria-label="Status: Menunggu"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l2.5 2.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="sr-only">Menunggu</span>
                                    </span>
                                @elseif($laporan->status == "Disetujui")
                                    <span title="Disetujui" aria-label="Status: Disetujui"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 13 4 4L19 7" />
                                        </svg>
                                        <span class="sr-only">Disetujui</span>
                                    </span>
                                @else
                                    <span title="Ditolak" aria-label="Status: Ditolak"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 6 12 12M18 6 6 18" />
                                        </svg>
                                        <span class="sr-only">Ditolak</span>
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-2">
                                <div class="flex items-center justify-center gap-1.5 whitespace-nowrap">
                                    <a href="{{ route('verifikasi.show', $laporan) }}"
                                        title="Lihat detail laporan" aria-label="Lihat detail laporan"
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-blue-500/10 text-blue-600 hover:bg-blue-500 hover:text-white dark:bg-blue-500/20 dark:text-blue-400 dark:hover:bg-blue-500 dark:hover:text-white transition">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z" />
                                            <circle cx="12" cy="12" r="2.5" stroke-width="2" />
                                        </svg>
                                        <span class="sr-only">Lihat detail</span>
                                    </a>
                                    <form action="{{ route('verifikasi.setujui', $laporan->id) }}" method="POST"
                                        class="inline block m-0 p-0"
                                        onsubmit="confirmFormSubmit(event, 'Apakah Anda yakin ingin menyetujui laporan ini?', this)">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            title="Setujui laporan" aria-label="Setujui laporan"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-green-500/10 text-green-600 hover:bg-green-500 hover:text-white dark:bg-green-500/20 dark:text-green-400 dark:hover:bg-green-500 dark:hover:text-white transition">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 13 4 4L19 7" />
                                            </svg>
                                            <span class="sr-only">Setujui</span>
                                        </button>
                                    </form>
                                    <form action="{{ route('verifikasi.tolak', $laporan->id) }}" method="POST"
                                        class="inline block m-0 p-0" onsubmit="submitTolak(event, this)">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="catatan" class="catatan-input">
                                        <button type="submit"
                                            title="Tolak laporan" aria-label="Tolak laporan"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-red-500/10 text-red-600 hover:bg-red-500 hover:text-white dark:bg-red-500/20 dark:text-red-400 dark:hover:bg-red-500 dark:hover:text-white transition">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 6 12 12M18 6 6 18" />
                                            </svg>
                                            <span class="sr-only">Tolak</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-10 text-gray-500 dark:text-gray-400">Tidak ada laporan
                                menunggu verifikasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($laporans->hasPages())
            <div class="mt-4 p-4 border-t border-gray-100 dark:border-gray-800">
                {{ $laporans->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        function submitTolak(event, form) {
            event.preventDefault();
            Swal.fire({
                title: 'Tolak Laporan',
                input: 'textarea',
                inputLabel: 'Masukkan alasan penolakan:',
                inputPlaceholder: 'Ketik alasan di sini...',
                showCancelButton: true,
                confirmButtonText: 'Tolak Laporan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                preConfirm: (alasan) => {
                    if (!alasan || alasan.trim() === '') {
                        Swal.showValidationMessage('Alasan penolakan wajib diisi!');
                        return false;
                    }
                    return alasan;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.querySelector('.catatan-input').value = result.value;
                    form.submit();
                }
            });
        }
    </script>
@endpush
