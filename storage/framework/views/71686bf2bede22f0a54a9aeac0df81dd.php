<?php $__env->startSection('content'); ?>

<div class="space-y-6">

    <div class="flex justify-between items-center">

        <div>
            <h1 class="text-3xl font-bold text-slate-800">Laporan Saya</h1>
            <p class="text-gray-500">Daftar laporan harian yang Anda kirim melalui WhatsApp Bot.</p>
        </div>

    </div>

    <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-300 text-green-700 rounded-xl p-4">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        <table class="w-full">

            <thead class="bg-slate-100">
                <tr>
                    <th class="p-4 text-left">Tanggal</th>
                    <th class="text-left">Nama Proyek</th>
                    <th class="text-left">Lokasi</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                <?php $__empty_1 = true; $__currentLoopData = $laporans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $laporan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <tr class="border-t hover:bg-slate-50">

                    <td class="p-4"><?php echo e(\Carbon\Carbon::parse($laporan->tanggal)->format('d-m-Y')); ?></td>

                    <td><?php echo e($laporan->nama_proyek); ?></td>

                    <td><?php echo e($laporan->lokasi); ?></td>

                    <td class="text-center">
                        <?php echo $__env->make('partials.status-badge', ['status' => $laporan->status], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </td>

                    <td>
                        <div class="flex justify-center gap-2">
                            <a href="<?php echo e(route('laporan-saya.show', $laporan->id)); ?>"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                                Detail
                            </a>
                        </div>
                    </td>

                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <tr>
                    <td colspan="5" class="text-center py-12 text-gray-400">
                        Anda belum memiliki laporan.
                    </td>
                </tr>

                <?php endif; ?>

            </tbody>

        </table>

        <div class="p-5">
            <?php echo e($laporans->links()); ?>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\usera\Downloads\monitoring-laporanpkn-refactor\monitoring-laporanpkn1\resources\views/karyawan/laporan/index.blade.php ENDPATH**/ ?>