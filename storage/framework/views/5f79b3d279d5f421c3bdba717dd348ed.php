

<?php $__env->startSection('content'); ?>

<div class="space-y-6">

    <div class="flex justify-between items-center">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">
                Monitoring Laporan Harian
            </h1>

            <p class="text-gray-500">
                Seluruh laporan harian yang dikirim melalui WhatsApp Bot.
            </p>

        </div>

        <a href="<?php echo e(route('laporan.create')); ?>"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl">

            + Tambah Laporan

        </a>

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

                    <th class="p-4 text-left">
                        Tanggal
                    </th>

                    <th class="text-left">
                        Karyawan
                    </th>

                    <th class="text-left">
                        Nama Proyek
                    </th>

                    <th class="text-left">
                        Lokasi
                    </th>

                    <th class="text-center">
                        Status
                    </th>

                    <th class="text-center">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                <?php $__empty_1 = true; $__currentLoopData = $laporans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $laporan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <tr class="border-t hover:bg-slate-50">

                    <td class="p-4">

                        <?php echo e(\Carbon\Carbon::parse($laporan->tanggal)->format('d-m-Y')); ?>


                    </td>

                    <td>

                        <?php echo e($laporan->karyawan->nama); ?>


                    </td>

                    <td>

                        <?php echo e($laporan->nama_proyek); ?>


                    </td>

                    <td>

                        <?php echo e($laporan->lokasi); ?>


                    </td>

                    <td class="text-center">

                        <?php if($laporan->status=="Menunggu"): ?>

                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm font-semibold">

                                Menunggu

                            </span>

                        <?php elseif($laporan->status=="Disetujui"): ?>

                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">

                                Disetujui

                            </span>

                        <?php else: ?>

                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm font-semibold">

                                Ditolak

                            </span>

                        <?php endif; ?>

                    </td>

                    <td>

                        <div class="flex justify-center gap-2">

                            <a href="<?php echo e(route('laporan.show',$laporan->id)); ?>"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">

                                Detail

                            </a>

                            <a href="<?php echo e(route('pdf.harian',$laporan->id)); ?>"
                               target="_blank"
                               class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm">

                                PDF

                            </a>

                            <?php if($laporan->status=="Menunggu"): ?>

                                <a href="<?php echo e(route('verifikasi.show',$laporan->id)); ?>"
                                   class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm">

                                    Verifikasi

                                </a>

                            <?php endif; ?>

                        </div>

                    </td>

                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <tr>

                    <td colspan="6"
                        class="text-center py-12 text-gray-400">

                        Belum ada laporan yang masuk.

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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\usera\Downloads\monitoring-laporanpkn-refactor\monitoring-laporanpkn1\resources\views/laporan/index.blade.php ENDPATH**/ ?>