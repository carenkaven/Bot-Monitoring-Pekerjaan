

<?php $__env->startSection('content'); ?>

<div class="space-y-6">

    
    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">

                Detail Laporan Mingguan

            </h1>

            <p class="text-gray-500">

                <?php echo e($summary['nama_proyek']); ?>


            </p>

        </div>

        <div>

            <a href="<?php echo e(route('weekly.index')); ?>"
               class="bg-slate-600 hover:bg-slate-700 text-white px-5 py-2 rounded-xl">

                ← Kembali

            </a>

        </div>

    </div>

    
    <div class="bg-white rounded-2xl shadow p-6">

        <div class="grid grid-cols-2 gap-5">

            <div>

                <table class="w-full text-sm">

                    <tr>
                        <td class="font-semibold w-40">Nama Proyek</td>
                        <td><?php echo e($summary['nama_proyek']); ?></td>
                    </tr>

                    <tr>
                        <td class="font-semibold">Minggu</td>
                        <td>Minggu <?php echo e($summary['minggu_ke']); ?></td>
                    </tr>

                    <tr>
                        <td class="font-semibold">Periode</td>
                        <td>

                            <?php echo e(\Carbon\Carbon::parse($summary['tanggal_mulai'])->translatedFormat('d F Y')); ?>


                            -

                            <?php echo e(\Carbon\Carbon::parse($summary['tanggal_selesai'])->translatedFormat('d F Y')); ?>


                        </td>
                    </tr>

                    <tr>
                        <td class="font-semibold">Lokasi</td>
                        <td><?php echo e($summary['lokasi']); ?></td>
                    </tr>

                    <tr>
                        <td class="font-semibold">PIC</td>
                        <td><?php echo e($summary['pic']); ?></td>
                    </tr>

                </table>

            </div>

            <div>

                <table class="w-full text-sm">

                    <tr>
                        <td class="font-semibold w-40">Kontraktor</td>
                        <td><?php echo e($summary['kontraktor']); ?></td>
                    </tr>

                    <tr>
                        <td class="font-semibold">Konsultan</td>
                        <td><?php echo e($summary['konsultan']); ?></td>
                    </tr>

                    <tr>
                        <td class="font-semibold">Kegiatan</td>
                        <td><?php echo e($summary['kegiatan']); ?></td>
                    </tr>

                    <tr>
                        <td class="font-semibold">Sub Kegiatan</td>
                        <td><?php echo e($summary['sub_kegiatan']); ?></td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

    
    <div class="grid grid-cols-4 gap-5">

        <div class="bg-blue-600 rounded-xl text-white p-5">

            <div class="text-sm">

                Total Laporan

            </div>

            <div class="text-3xl font-bold">

                <?php echo e($summary['total_laporan']); ?>


            </div>

        </div>

        <div class="bg-green-600 rounded-xl text-white p-5">

            <div class="text-sm">

                Disetujui

            </div>

            <div class="text-3xl font-bold">

                <?php echo e($summary['disetujui']); ?>


            </div>

        </div>

        <div class="bg-red-600 rounded-xl text-white p-5">

            <div class="text-sm">

                Ditolak

            </div>

            <div class="text-3xl font-bold">

                <?php echo e($summary['ditolak']); ?>


            </div>

        </div>

        <div class="bg-yellow-500 rounded-xl text-white p-5">

            <div class="text-sm">

                Menunggu

            </div>

            <div class="text-3xl font-bold">

                <?php echo e($summary['menunggu']); ?>


            </div>

        </div>

    </div>

    
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <table class="w-full">

            <thead class="bg-slate-100">

                <tr>

                    <th class="p-4">Tanggal</th>

                    <th>Pekerjaan</th>

                    <th>Status</th>

                    <th>Foto</th>

                    <th>PDF</th>

                </tr>

            </thead>

            <tbody>

                <?php $__currentLoopData = $laporans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $laporan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <tr class="border-t">

                    <td class="text-center">

                        <?php echo e($laporan->tanggal->format('d M Y')); ?>


                    </td>

                    <td>

                        <?php echo e($laporan->pekerjaan); ?>


                    </td>

                    <td class="text-center">

                        <?php if($laporan->status=='Disetujui'): ?>

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

                                Disetujui

                            </span>

                        <?php elseif($laporan->status=='Ditolak'): ?>

                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">

                                Ditolak

                            </span>

                        <?php else: ?>

                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">

                                Menunggu

                            </span>

                        <?php endif; ?>

                    </td>

                    <td class="text-center">

                        <?php echo e($laporan->fotos->count()); ?>


                    </td>

                    <td class="text-center">

                        <a href="<?php echo e(route('pdf.harian',$laporan->id)); ?>"

                           target="_blank"

                           class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg">

                            PDF

                        </a>

                    </td>

                </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </tbody>

        </table>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Downloads\MAGANG VENA\monitoring-laporanpkn1\resources\views/weekly/show.blade.php ENDPATH**/ ?>