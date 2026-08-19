<?php $__env->startSection('content'); ?>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Laporan Mingguan
            </h2>
            <p class="text-sm mt-1 text-slate-500 dark:text-slate-400">
                Rekap laporan mingguan berdasarkan bulan dan minggu kalender.
            </p>
        </div>
        <div>
            <button type="button" onclick="bukaModalCetakCustom()" class="inline-flex items-center justify-center rounded-md bg-blue-600 py-2 px-5 text-sm font-medium text-white hover:bg-blue-700 transition shadow-sm">
                Cetak Laporan Custom
            </button>
        </div>
    </div>

    <?php if(session('success')): ?>
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
                <p class="text-base leading-relaxed text-black dark:text-white"><?php echo e(session('success')); ?></p>
            </div>
        </div>
    <?php endif; ?>

    
    <div class="mb-6 rounded-xl border border-stroke bg-white p-5 shadow-default dark:border-strokedark dark:bg-boxdark">
        <form method="GET" action="<?php echo e(route('weekly.index')); ?>" class="flex flex-col sm:flex-row gap-4 items-end">
            <div class="w-full sm:w-1/3">
                <label class="mb-2 block text-sm font-medium text-black dark:text-white">Tahun</label>
                <div class="relative z-20 bg-transparent dark:bg-form-input">
                    <select name="year" class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-blue-500 active:border-blue-500 dark:border-form-strokedark dark:bg-form-input dark:focus:border-blue-500 text-black dark:text-white">
                        <?php for($y = date('Y') - 2; $y <= date('Y') + 1; $y++): ?>
                            <option value="<?php echo e($y); ?>" class="text-black dark:text-white bg-white dark:bg-boxdark" <?php echo e($year == $y ? 'selected' : ''); ?>><?php echo e($y); ?></option>
                        <?php endfor; ?>
                    </select>
                    <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                        <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g opacity="0.8">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z" fill="currentColor"></path>
                            </g>
                        </svg>
                    </span>
                </div>
            </div>
            
            <div class="w-full sm:w-1/3">
                <label class="mb-2 block text-sm font-medium text-black dark:text-white">Bulan</label>
                <div class="relative z-20 bg-transparent dark:bg-form-input">
                    <select name="month" class="relative z-20 w-full appearance-none rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-blue-500 active:border-blue-500 dark:border-form-strokedark dark:bg-form-input dark:focus:border-blue-500 text-black dark:text-white">
                        <?php
                            $months = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                                7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ];
                        ?>
                        <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m => $nama): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($m); ?>" class="text-black dark:text-white bg-white dark:bg-boxdark" <?php echo e($month == $m ? 'selected' : ''); ?>><?php echo e($nama); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                        <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g opacity="0.8">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 8.29289C5.68342 7.90237 6.31658 7.90237 6.70711 8.29289L12 13.5858L17.2929 8.29289C17.6834 7.90237 18.3166 7.90237 18.7071 8.29289C19.0976 8.68342 19.0976 9.31658 18.7071 9.70711L12.7071 15.7071C12.3166 16.0976 11.6834 16.0976 11.2929 15.7071L5.29289 9.70711C4.90237 9.31658 4.90237 8.68342 5.29289 8.29289Z" fill="currentColor"></path>
                            </g>
                        </svg>
                    </span>
                </div>
            </div>

            <div class="w-full sm:w-1/3">
                <button type="submit" class="w-full rounded bg-blue-600 py-3 px-5 font-medium text-white hover:bg-blue-700 transition">Tampilkan</button>
            </div>
        </form>
    </div>

    <h3 class="mb-5 text-xl font-bold text-black dark:text-white">
        <?php echo e($months[(int)$month]); ?> <?php echo e($year); ?>

    </h3>

    
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <?php $__currentLoopData = $weeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $weekNum => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="rounded-xl border border-stroke bg-white px-6 py-6 shadow-default dark:border-strokedark dark:bg-boxdark hover:shadow-lg transition-shadow">
                <h4 class="mb-2 text-title-sm font-bold text-black dark:text-white">Minggu <?php echo e($weekNum); ?></h4>
                <p class="mb-4 text-sm font-medium text-slate-500 dark:text-slate-400">
                    <?php echo e($data['start']); ?>–<?php echo e($data['end']); ?> <?php echo e($months[(int)$month]); ?>

                </p>
                <div class="mb-5">
                    <span class="inline-flex rounded-full bg-blue-50 py-1.5 px-3 text-sm font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                        <?php echo e($data['count']); ?> laporan
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <?php if($data['count'] == 0): ?>
                        <button type="button" onclick="laporanKosong()" class="inline-flex items-center gap-2 text-sm font-medium text-gray-400 cursor-not-allowed group">
                            Lihat
                            <svg class="fill-current" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.11894 1.48803C8.38527 1.2217 8.81702 1.2217 9.08336 1.48803L13.8056 6.21025C14.0719 6.47659 14.0719 6.90833 13.8056 7.17467L9.08336 11.8969C8.81702 12.1632 8.38527 12.1632 8.11894 11.8969C7.8526 11.6306 7.8526 11.1988 8.11894 10.9325L11.6667 7.38473L0.833333 7.38473C0.456639 7.38473 0.151515 7.07961 0.151515 6.70291C0.151515 6.32622 0.456639 6.0211 0.833333 6.0211L11.6667 6.0211L8.11894 2.47334C7.8526 2.207 7.8526 1.77526 8.11894 1.48803Z" fill="currentColor"></path>
                            </svg>
                        </button>
                        
                        <button type="button" onclick="laporanKosong()" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-400 cursor-not-allowed">
                            <svg class="fill-current" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 8H5V4H19V8ZM19 10C20.1046 10 21 10.8954 21 12V18H17V22H7V18H3V12C3 10.8954 3.89543 10 5 10H19ZM15 16H9V20H15V16ZM16 12C16 11.4477 16.4477 11 17 11C17.5523 11 18 11.4477 18 12C18 12.5523 17.5523 13 17 13C16.4477 13 16 12.5523 16 12Z" fill="currentColor"></path>
                            </svg>
                            Cetak
                        </button>
                    <?php else: ?>
                        <a href="<?php echo e(route('weekly.show', ['minggu' => $weekNum, 'proyek' => 'all', 'year' => $year, 'month' => $month])); ?>" 
                           class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition group">
                            Lihat
                            <svg class="fill-current group-hover:translate-x-1 transition-transform" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.11894 1.48803C8.38527 1.2217 8.81702 1.2217 9.08336 1.48803L13.8056 6.21025C14.0719 6.47659 14.0719 6.90833 13.8056 7.17467L9.08336 11.8969C8.81702 12.1632 8.38527 12.1632 8.11894 11.8969C7.8526 11.6306 7.8526 11.1988 8.11894 10.9325L11.6667 7.38473L0.833333 7.38473C0.456639 7.38473 0.151515 7.07961 0.151515 6.70291C0.151515 6.32622 0.456639 6.0211 0.833333 6.0211L11.6667 6.0211L8.11894 2.47334C7.8526 2.207 7.8526 1.77526 8.11894 1.48803Z" fill="currentColor"></path>
                            </svg>
                        </a>
                        
                        <button type="button" onclick="cetakCardBaru(<?php echo e($weekNum); ?>)" class="inline-flex items-center gap-1.5 text-sm font-medium text-orange-600 hover:text-orange-800 dark:text-orange-400 dark:hover:text-orange-300 transition">
                            <svg class="fill-current" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 8H5V4H19V8ZM19 10C20.1046 10 21 10.8954 21 12V18H17V22H7V18H3V12C3 10.8954 3.89543 10 5 10H19ZM15 16H9V20H15V16ZM16 12C16 11.4477 16.4477 11 17 11C17.5523 11 18 11.4477 18 12C18 12.5523 17.5523 13 17 13C16.4477 13 16 12.5523 16 12Z" fill="currentColor"></path>
                            </svg>
                            Cetak
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Modal Cetak Custom -->
    <div id="modalCetakCustom" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-xl dark:bg-boxdark">
            <h3 class="mb-5 text-xl font-bold text-black dark:text-white">Cetak Rentang Waktu (Custom)</h3>
            
            <div class="mb-4">
                <label class="mb-2 block text-sm font-medium text-black dark:text-white">Pilih Proyek</label>
                <select id="customProyek" class="w-full rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-blue-500 dark:border-form-strokedark dark:bg-form-input text-black dark:text-white">
                    <?php $__currentLoopData = $proyeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($p); ?>" class="text-black dark:text-white bg-white dark:bg-boxdark"><?php echo e($p); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="mb-2 block text-sm font-medium text-black dark:text-white">Tanggal Awal</label>
                <input type="date" id="customStart" class="w-full rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-blue-500 dark:border-form-strokedark dark:bg-form-input text-black dark:text-white">
            </div>

            <div class="mb-5">
                <label class="mb-2 block text-sm font-medium text-black dark:text-white">Tanggal Akhir</label>
                <input type="date" id="customEnd" class="w-full rounded border border-stroke bg-transparent py-3 px-5 outline-none transition focus:border-blue-500 dark:border-form-strokedark dark:bg-form-input text-black dark:text-white">
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="tutupModalCetakCustom()" class="rounded border border-stroke py-2 px-6 font-medium text-black hover:bg-slate-100 dark:border-strokedark dark:text-white dark:hover:bg-meta-4 transition">Batal</button>
                <button type="button" onclick="prosesCetakCustom()" class="rounded bg-blue-600 py-2 px-6 font-medium text-white hover:bg-blue-700 transition">Selanjutnya</button>
            </div>
        </div>
    </div>

<?php $__env->startPush('scripts'); ?>
<script>
    function laporanKosong() {
        Swal.fire({
            icon: 'info',
            title: 'Laporan Kosong',
            text: 'Belum ada laporan yang masuk untuk minggu ini.'
        });
    }

    function bukaModalCetakCustom() {
        document.getElementById('modalCetakCustom').classList.remove('hidden');
    }

    function tutupModalCetakCustom() {
        document.getElementById('modalCetakCustom').classList.add('hidden');
    }

    function prosesCetakCustom() {
        const proyek = document.getElementById('customProyek').value;
        const start = document.getElementById('customStart').value;
        const end = document.getElementById('customEnd').value;

        if (!proyek || !start || !end) {
            Swal.fire({
                icon: 'warning',
                title: 'Data Tidak Lengkap',
                text: 'Harap lengkapi proyek, tanggal awal, dan tanggal akhir.'
            });
            return;
        }

        if (start > end) {
            Swal.fire({
                icon: 'error',
                title: 'Tanggal Tidak Valid',
                text: 'Tanggal awal tidak boleh lebih besar dari tanggal akhir.'
            });
            return;
        }

        const urlLamaPdf = `<?php echo e(url('pdf/weekly/custom')); ?>/${encodeURIComponent(proyek)}?start=${start}&end=${end}`;
        const urlLamaExcel = `<?php echo e(url('excel/weekly/custom')); ?>/${encodeURIComponent(proyek)}?start=${start}&end=${end}`;
        const urlBaruPdf = `<?php echo e(url('pdf/weekly-fisik/custom')); ?>/${encodeURIComponent(proyek)}?start=${start}&end=${end}`;
        const urlBaruExcel = `<?php echo e(url('excel/weekly-fisik/custom')); ?>/${encodeURIComponent(proyek)}?start=${start}&end=${end}`;

        tutupModalCetakCustom();
        
        // Memanfaatkan fungsi dari app.blade.php
        pilihJenisLaporanMingguan(urlLamaPdf, urlLamaExcel, urlBaruPdf, urlBaruExcel);
    }

    async function cetakCardBaru(minggu) {
        const proyeks = <?php echo json_encode($proyeks); ?>;
        let inputOptions = {};
        proyeks.forEach(p => { inputOptions[p] = p; });

        const { value: proyek } = await Swal.fire({
            title: 'Pilih Proyek',
            text: `Pilih proyek untuk dicetak (Minggu ${minggu})`,
            input: 'select',
            inputOptions: inputOptions,
            inputPlaceholder: 'Pilih Proyek',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Selanjutnya',
            cancelButtonText: 'Batal'
        });

        if (proyek) {
            const urlPdf = `<?php echo e(url('pdf/weekly-fisik')); ?>/${minggu}/${encodeURIComponent(proyek)}?year=<?php echo e($year); ?>&month=<?php echo e($month); ?>`;
            const urlExcel = `<?php echo e(url('excel/weekly-fisik')); ?>/${minggu}/${encodeURIComponent(proyek)}?year=<?php echo e($year); ?>&month=<?php echo e($month); ?>`;
            
            pilihFormatLaporan(`Cetak Laporan Baru (Minggu ${minggu})`, urlPdf, urlExcel);
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PROJECT FANY\Bot-Monitoring-Pekerjaan\resources\views/weekly/index.blade.php ENDPATH**/ ?>