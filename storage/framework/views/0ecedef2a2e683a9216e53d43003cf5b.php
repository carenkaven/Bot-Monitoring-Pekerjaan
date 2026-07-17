

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Verifikasi Laporan</h1>
            <p class=" dark:text-slate-400">Daftar laporan pekerjaan yang menunggu persetujuan Administrator.</p>
        </div>
    </div>

    <?php if(session('success')): ?>
    <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-xl p-4"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
        <form method="GET" class="p-6 border-b">
            <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari proyek, lokasi, PIC..."
                   class="w-full md:w-96 rounded-xl border-slate-300">
        </form>

        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-600">
                <tr>
                    <th class="px-6 py-4">Tanggal</th>
                    <th>Karyawan</th>
                    <th>Proyek</th>
                    <th>Lokasi</th>
                    <th>PIC</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $laporans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $laporan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="border-t hover:bg-slate-50">
                    <td class="px-6 py-4"><?php echo e($laporan->tanggal->format('d M Y')); ?></td>
                    <td><?php echo e($laporan->karyawan->nama ?? '-'); ?></td>
                    <td class="font-semibold"><?php echo e($laporan->nama_proyek); ?></td>
                    <td><?php echo e($laporan->lokasi); ?></td>
                    <td><?php echo e($laporan->pic ?? '-'); ?></td>
                    <td class="text-center"><?php echo $__env->make('partials.status-badge', ['status'=>$laporan->status], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></td>
                    <td class="text-center">
                        <a href="<?php echo e(route('verifikasi.show',$laporan)); ?>"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-xs">
                           Verifikasi
                        </a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" class="text-center py-12 text-slate-400">Tidak ada laporan menunggu verifikasi.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
        <div class="p-5"><?php echo e($laporans->links()); ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\usera\Downloads\monitoring-laporanpkn-refactor\monitoring-laporanpkn1\resources\views/verifikasi/index.blade.php ENDPATH**/ ?>