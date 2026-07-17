

<?php $__env->startSection('content'); ?>

    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Monitoring Laporan Mingguan
            </h2>
            <p class="text-sm mt-1 text-slate-500 dark:text-slate-400">
                Rekap laporan mingguan berdasarkan tanggal laporan.
            </p>
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

    
    <div class="mb-6 rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900 p-5">
        <form method="GET" action="<?php echo e(route('weekly.index')); ?>" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <button class="absolute left-4 top-1/2 -translate-y-1/2">
                    <svg class="fill-current text-gray-500" width="20" height="20" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M9.16666 3.33332C5.94502 3.33332 3.33332 5.94502 3.33332 9.16666C3.33332 12.3883 5.94502 15 9.16666 15C12.3883 15 15 12.3883 15 9.16666C15 5.94502 12.3883 3.33332 9.16666 3.33332ZM1.66666 9.16666C1.66666 5.02452 5.02452 1.66666 9.16666 1.66666C13.3088 1.66666 16.6667 5.02452 16.6667 9.16666C16.6667 11.0261 15.9897 12.7276 14.8872 14.0487L18.0892 17.2508C18.4147 17.5762 18.4147 18.1039 18.0892 18.4293C17.7638 18.7548 17.2361 18.7548 16.9107 18.4293L13.7086 15.2273C12.4283 16.1437 10.8524 16.6667 9.16666 16.6667C5.02452 16.6667 1.66666 13.3088 1.66666 9.16666Z" />
                    </svg>
                </button>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama proyek..."
                    class="w-full rounded-md border border-gray-300 bg-transparent py-2.5 pl-12 pr-4 outline-none focus:border-blue-500 active:border-blue-500 dark:border-gray-700 dark:focus:border-blue-500 transition">
            </div>
            <button
                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-md transition font-medium">Cari</button>
            <?php if(request('search')): ?>
                <a href="<?php echo e(route('weekly.index')); ?>"
                    class="bg-gray-500 text-white px-6 py-2.5 rounded-md hover:bg-gray-600 transition font-medium flex items-center justify-center">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    
    <div
        class="rounded-xl border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5">
        <div class="max-w-full overflow-x-auto pb-4">
            <table class="w-full table-auto">
                <thead class="bg-gray-50 dark:bg-meta-4 border-b border-stroke dark:border-strokedark shrink-0">
                    <tr class="text-left text-sm font-semibold text-black dark:text-white">
                        <th class="py-4 px-4 sm:px-6 font-medium">Minggu</th>
                        <th class="py-4 px-2 font-medium">Nama Proyek</th>
                        <th class="py-4 px-2 font-medium">Periode</th>
                        <th class="py-4 px-2 font-medium text-center">Total</th>
                        <th class="py-4 px-2 font-medium text-center">Disetujui</th>
                        <th class="py-4 px-2 font-medium text-center">Ditolak</th>
                        <th class="py-4 px-2 font-medium text-center">Menunggu</th>
                        <th class="py-4 px-2 font-medium text-center lg:min-w-[150px]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stroke dark:divide-strokedark">
                    <?php $__empty_1 = true; $__currentLoopData = $weeklyReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-meta-4/50 transition">
                            <td class="py-4 px-4 sm:px-6">
                                <span
                                    class="inline-flex rounded bg-blue-50 py-1 px-3 text-sm font-medium text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                                    Minggu <?php echo e($row['minggu_ke']); ?>

                                </span>
                            </td>
                            <td class="py-4 px-2 text-sm text-gray-800 dark:text-gray-200 font-medium">
                                <?php echo e($row['nama_proyek']); ?>

                            </td>
                            <td class="py-4 px-2 text-sm text-gray-500 dark:text-gray-400">
                                <?php echo e(\Carbon\Carbon::parse($row['tanggal_mulai'])->format('d M Y')); ?>

                                <span class="mx-1 text-xs">s/d</span>
                                <?php echo e(\Carbon\Carbon::parse($row['tanggal_selesai'])->format('d M Y')); ?>

                            </td>
                            <td class="py-4 px-2 text-center">
                                <span
                                    class="inline-flex rounded-full bg-gray-100 py-1 px-3 text-xs font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                    <?php echo e($row['total_laporan']); ?>

                                </span>
                            </td>
                            <td class="py-4 px-2 text-center">
                                <span
                                    class="inline-flex rounded-full bg-green-100 py-1 px-3 text-xs font-semibold text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    <?php echo e($row['disetujui']); ?>

                                </span>
                            </td>
                            <td class="py-4 px-2 text-center">
                                <span
                                    class="inline-flex rounded-full bg-red-100 py-1 px-3 text-xs font-semibold text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                    <?php echo e($row['ditolak']); ?>

                                </span>
                            </td>
                            <td class="py-4 px-2 text-center">
                                <span
                                    class="inline-flex rounded-full bg-yellow-100 py-1 px-3 text-xs font-semibold text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500">
                                    <?php echo e($row['menunggu']); ?>

                                </span>
                            </td>
                            <td class="py-4 px-2">
                                <div class="flex justify-center gap-2">
                                    <a href="<?php echo e(route('weekly.show', ['minggu' => $row['minggu_ke'], 'proyek' => $row['nama_proyek']])); ?>"
                                        class="inline-flex rounded-lg bg-blue-500/10 py-1.5 px-3 text-sm font-medium text-blue-600 hover:bg-blue-500 hover:text-white dark:bg-blue-500/20 dark:text-blue-400 dark:hover:bg-blue-500 dark:hover:text-white transition">
                                        Detail
                                    </a>
                                    <a target="_blank"
                                        href="<?php echo e(route('pdf.weekly', ['minggu' => $row['minggu_ke'], 'proyek' => $row['nama_proyek']])); ?>"
                                        class="inline-flex rounded-lg bg-red-500/10 py-1.5 px-3 text-sm font-medium text-red-600 hover:bg-red-500 hover:text-white dark:bg-red-500/20 dark:text-red-400 dark:hover:bg-red-500 dark:hover:text-white transition">
                                        PDF
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center py-10 text-gray-500 dark:text-gray-400">
                                Tidak ada data.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if(method_exists($weeklyReports, 'links')): ?>
            <div class="mt-4 p-4 border-t border-gray-100 dark:border-gray-800">
                <?php echo e($weeklyReports->links('pagination::tailwind')); ?>

            </div>
        <?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Downloads\MAGANG VENA\monitoring-laporanpkn1\resources\views/weekly/index.blade.php ENDPATH**/ ?>