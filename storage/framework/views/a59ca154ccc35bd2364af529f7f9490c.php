<?php $__env->startSection('content'); ?>

<div class="space-y-6">

    <div>
        <h1 class="text-3xl font-bold text-slate-800">Dashboard Karyawan</h1>
        <p class="mt-1 text-gray-500">
            Selamat datang, <b><?php echo e(Auth::user()->name); ?></b>
            <?php if($karyawan->jabatan): ?> &middot; <?php echo e($karyawan->jabatan); ?> <?php endif; ?>
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-white rounded-3xl shadow-lg p-6">
            <p class="text-xs uppercase text-slate-500">Total Laporan</p>
            <p class="text-3xl font-bold text-slate-800 mt-2"><?php echo e($totalLaporan); ?></p>
        </div>

        <div class="bg-white rounded-3xl shadow-lg p-6">
            <p class="text-xs uppercase text-slate-500">Disetujui</p>
            <p class="text-3xl font-bold text-green-600 mt-2"><?php echo e($disetujui); ?></p>
        </div>

        <div class="bg-white rounded-3xl shadow-lg p-6">
            <p class="text-xs uppercase text-slate-500">Menunggu</p>
            <p class="text-3xl font-bold text-yellow-500 mt-2"><?php echo e($menunggu); ?></p>
        </div>

        <div class="bg-white rounded-3xl shadow-lg p-6">
            <p class="text-xs uppercase text-slate-500">Ditolak</p>
            <p class="text-3xl font-bold text-red-600 mt-2"><?php echo e($ditolak); ?></p>
        </div>

    </div>

    <div class="bg-white rounded-3xl shadow-lg">

        <div class="p-6 border-b flex justify-between items-center">
            <h2 class="text-xl font-semibold">5 Laporan Terakhir</h2>
            <a href="<?php echo e(route('laporan-saya.index')); ?>" class="text-blue-600 hover:underline text-sm font-medium">Lihat semua</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-left">Tanggal</th>
                        <th class="px-6 py-4 text-left">Nama Proyek</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $laporanTerakhir; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $laporan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-b hover:bg-slate-50">
                        <td class="px-6 py-4"><?php echo e($laporan->tanggal->format('d-m-Y')); ?></td>
                        <td class="px-6 py-4"><?php echo e($laporan->nama_proyek); ?></td>
                        <td class="px-6 py-4 text-center">
                            <?php echo $__env->make('partials.status-badge', ['status' => $laporan->status], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="<?php echo e(route('laporan-saya.show', $laporan->id)); ?>"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                                Detail
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="text-center py-10 text-gray-400">Belum ada laporan.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\usera\Downloads\monitoring-laporanpkn-refactor\monitoring-laporanpkn1\resources\views/karyawan/dashboard.blade.php ENDPATH**/ ?>