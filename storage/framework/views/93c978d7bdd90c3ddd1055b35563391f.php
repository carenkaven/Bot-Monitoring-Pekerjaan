<?php $__env->startSection('content'); ?>

    <div class="space-y-6">

        <div class="flex justify-between items-center">

            <div>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-white">Laporan Saya</h1>
                <p class="text-gray-500 dark:text-gray-400">Daftar laporan harian yang Anda kirim melalui WhatsApp Bot.</p>
            </div>

        </div>

        <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-300 text-green-700 rounded-xl p-4">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div
            class="rounded-xl border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5">
            <div class="max-w-full overflow-x-auto pb-4">
                <table class="w-full table-auto">
                    <thead class="bg-gray-50 dark:bg-meta-4 border-b border-stroke dark:border-strokedark">
                        <tr class="text-left text-sm font-semibold text-black dark:text-white">
                            <th class="py-4 px-2 font-medium">Tanggal</th>
                            <th class="py-4 px-2 font-medium">Nama Proyek</th>
                            <th class="py-4 px-2 font-medium">Lokasi</th>
                            <th class="py-4 px-2 font-medium text-center">Status</th>
                            <th class="py-4 px-2 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-stroke dark:divide-strokedark">

                        <?php $__empty_1 = true; $__currentLoopData = $laporans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $laporan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <tr class="hover:bg-gray-50 dark:hover:bg-meta-4/50 transition">

                                <td class="py-4 px-2 text-black dark:text-white">
                                    <?php echo e(\Carbon\Carbon::parse($laporan->tanggal)->format('d-m-Y')); ?></td>

                                <td class="py-4 px-2"><?php echo e($laporan->nama_proyek); ?></td>

                                <td class="py-4 px-2"><?php echo e($laporan->lokasi); ?></td>

                                <td class="py-4 px-2 text-center">
                                    <?php echo $__env->make('partials.status-badge', ['status' => $laporan->status], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                </td>

                                <td class="py-4 px-2 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="<?php echo e(route('laporan-saya.show', $laporan->id)); ?>"
                                            class="inline-flex rounded bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-600 hover:bg-blue-600 hover:text-white transition dark:bg-blue-500/20 dark:text-blue-400 dark:hover:bg-blue-500 dark:hover:text-white">
                                            Detail
                                        </a>
                                    </div>
                                </td>

                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                            <tr>
                                <td colspan="5" class="text-center py-12 text-gray-400 dark:text-gray-500">
                                    Anda belum memiliki laporan.
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>
            </div>

            <?php if($laporans->hasPages()): ?>
                <div class="mt-4 p-4 border-t border-gray-100 dark:border-gray-800">
                    <?php echo e($laporans->links()); ?>

                </div>
            <?php endif; ?>

        </div>

    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\akuna\OneDrive\Dokumen\ARIYA MILAARA\pkn\Bot-Monitoring-Pekerjaan\Bot-Monitoring-Pekerjaan\resources\views/karyawan/laporan/index.blade.php ENDPATH**/ ?>