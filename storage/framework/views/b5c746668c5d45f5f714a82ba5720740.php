

<?php $__env->startSection('content'); ?>

<div class="space-y-6">

    <div class="flex justify-between items-center">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">

                Monitoring Laporan Mingguan

            </h1>

            <p class="text-gray-500">

                Rekap laporan mingguan berdasarkan tanggal laporan.

            </p>

        </div>

    </div>

    <?php if(session('success')): ?>

        <div class="bg-green-100 border border-green-300 text-green-700 rounded-xl p-4">

            <?php echo e(session('success')); ?>


        </div>

    <?php endif; ?>

    

    <div class="bg-white rounded-2xl shadow-lg p-5">

        <form method="GET"
              action="<?php echo e(route('weekly.index')); ?>"
              class="flex gap-3">

            <input
                type="text"
                name="search"
                value="<?php echo e(request('search')); ?>"
                placeholder="Cari nama proyek..."
                class="flex-1 px-4 py-2 border rounded-xl">

            <button
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 rounded-xl">

                Cari

            </button>

            <?php if(request('search')): ?>

                <a href="<?php echo e(route('weekly.index')); ?>"
                   class="bg-gray-500 text-white px-6 py-2 rounded-xl">

                    Reset

                </a>

            <?php endif; ?>

        </form>

    </div>

    

    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <table class="w-full">

            <thead class="bg-slate-100">

            <tr>

                <th class="p-4 text-left">

                    Minggu

                </th>

                <th>

                    Nama Proyek

                </th>

                <th>

                    Periode

                </th>

                <th>

                    Total

                </th>

                <th>

                    Disetujui

                </th>

                <th>

                    Ditolak

                </th>

                <th>

                    Menunggu

                </th>

                <th>

                    Aksi

                </th>

            </tr>

            </thead>

            <tbody>

            <?php $__empty_1 = true; $__currentLoopData = $weeklyReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <tr class="border-t hover:bg-slate-50">

                    <td class="p-4">

                        <span class="font-bold text-blue-600">

                            Minggu <?php echo e($row['minggu_ke']); ?>


                        </span>

                    </td>

                    <td>

                        <?php echo e($row['nama_proyek']); ?>


                    </td>

                    <td>

                        <?php echo e(\Carbon\Carbon::parse($row['tanggal_mulai'])->format('d M Y')); ?>


                        <br>

                        s/d

                        <br>

                        <?php echo e(\Carbon\Carbon::parse($row['tanggal_selesai'])->format('d M Y')); ?>


                    </td>

                    <td class="text-center">

                        <span class="bg-slate-100 px-3 py-1 rounded-full">

                            <?php echo e($row['total_laporan']); ?>


                        </span>

                    </td>

                    <td class="text-center">

                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

                            <?php echo e($row['disetujui']); ?>


                        </span>

                    </td>

                    <td class="text-center">

                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">

                            <?php echo e($row['ditolak']); ?>


                        </span>

                    </td>

                    <td class="text-center">

                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">

                            <?php echo e($row['menunggu']); ?>


                        </span>

                    </td>

                    <td>

                        <div class="flex justify-center gap-2">

                            <a
                                href="<?php echo e(route('weekly.show',[
                                    'minggu'=>$row['minggu_ke'],
                                    'proyek'=>$row['nama_proyek']
                                ])); ?>"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">

                                Detail

                            </a>

                            <a
                                target="_blank"
                                href="<?php echo e(route('pdf.weekly',[
                                    'minggu'=>$row['minggu_ke'],
                                    'proyek'=>$row['nama_proyek']
                                ])); ?>"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">

                                PDF

                            </a>

                        </div>

                    </td>

                </tr>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <tr>

                    <td colspan="8"
                        class="py-10 text-center text-gray-400">

                        Tidak ada data.

                    </td>

                </tr>

            <?php endif; ?>

            </tbody>

        </table>

        <div class="p-5">

            <?php echo e($weeklyReports->links()); ?>


        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\usera\Downloads\monitoring-laporanpkn-refactor\monitoring-laporanpkn1\resources\views/weekly/index.blade.php ENDPATH**/ ?>