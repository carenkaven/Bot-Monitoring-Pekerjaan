<?php $__env->startSection('content'); ?>
<div class="space-y-8">

    
    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-4xl font-bold text-slate-900 dark:text-white transition-colors duration-300"
                data-testid="dashboard-title">

                Dashboard Monitoring

            </h1>

            <p class="mt-2 text-slate-500 dark:text-slate-400">

                Selamat datang di Sistem Monitoring Laporan Harian PT Reno Abirama Sakti.

            </p>

        </div>

        <div class="rounded-2xl bg-blue-600 px-6 py-4 text-white shadow-lg">

            <p class="text-sm opacity-80">

                Hari Ini

            </p>

            <h3 class="text-2xl font-bold">

                <?php echo e(now()->translatedFormat('d F Y')); ?>


            </h3>

        </div>

    </div>



    
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <?php

            $cards = [

                [
                    'label'=>'Total Laporan',
                    'value'=>$totalLaporan,
                    'color'=>'blue',
                    'sub'=>'Semua laporan masuk',
                    'testid'=>'card-total',
                    'icon'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'
                ],

                [
                    'label'=>'Menunggu',
                    'value'=>$menunggu,
                    'color'=>'amber',
                    'sub'=>'Menunggu verifikasi',
                    'testid'=>'card-menunggu',
                    'icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                ],

                [
                    'label'=>'Disetujui',
                    'value'=>$disetujui,
                    'color'=>'emerald',
                    'sub'=>'Laporan disetujui',
                    'testid'=>'card-disetujui',
                    'icon'=>'M9 12l2 2 4-4M12 22a10 10 0 100-20 10 10 0 000 20z'
                ],

                [
                    'label'=>'Ditolak',
                    'value'=>$ditolak,
                    'color'=>'rose',
                    'sub'=>'Laporan ditolak',
                    'testid'=>'card-ditolak',
                    'icon'=>'M6 18L18 6M6 6l12 12'
                ],

            ];

        ?>


        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <div
            class="bg-white dark:bg-slate-800 rounded-3xl shadow-lg p-6 hover:shadow-xl transition duration-300"
            data-testid="<?php echo e($c['testid']); ?>">

            <div class="flex justify-between items-start">

                <div>

                    <p class="text-slate-500 dark:text-slate-400 text-sm">

                        <?php echo e($c['label']); ?>


                    </p>

                    <h2 class="text-5xl font-bold text-<?php echo e($c['color']); ?>-600 mt-3">

                        <?php echo e($c['value']); ?>


                    </h2>

                    <small class="text-slate-400 dark:text-slate-500">

                        <?php echo e($c['sub']); ?>


                    </small>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-<?php echo e($c['color']); ?>-100 dark:bg-<?php echo e($c['color']); ?>-900/30 flex items-center justify-center">

                    <svg
                        class="w-7 h-7 text-<?php echo e($c['color']); ?>-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="<?php echo e($c['icon']); ?>" />

                    </svg>

                </div>

            </div>

        </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>



    
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        
        <div class="xl:col-span-2 bg-white dark:bg-slate-800 rounded-3xl shadow-lg p-6 transition duration-300">

            <div class="mb-5 flex items-center justify-between">

                <div>

                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">

                        Grafik Laporan Mingguan

                    </h2>

                    <p class="text-slate-500 dark:text-slate-400 text-sm">

                        7 hari terakhir

                    </p>

                </div>

                <div class="flex gap-2">

                    <button
                        data-chart="weekly"
                        class="chart-tab px-4 py-2 rounded-xl bg-blue-600 text-white text-sm">

                        Mingguan

                    </button>

                    <button
                        data-chart="monthly"
                        class="chart-tab px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 text-sm">

                        Bulanan

                    </button>

                </div>

            </div>

            <canvas id="laporanChart" height="120"></canvas>

        </div>



        
        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-lg p-6 transition duration-300">

            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-6">

                Status Laporan

            </h2>

            <canvas id="statusChart" height="220"></canvas>

            <div class="mt-6 space-y-3 text-sm">

                <div class="flex justify-between">

                    <span class="text-slate-700 dark:text-slate-300">

                        Disetujui

                    </span>

                    <span class="font-bold text-emerald-600">

                        <?php echo e($disetujui); ?>


                    </span>

                </div>

                <div class="flex justify-between">

                    <span class="text-slate-700 dark:text-slate-300">

                        Menunggu

                    </span>

                    <span class="font-bold text-amber-500">

                        <?php echo e($menunggu); ?>


                    </span>

                </div>

                <div class="flex justify-between">

                    <span class="text-slate-700 dark:text-slate-300">

                        Ditolak

                    </span>

                    <span class="font-bold text-rose-600">

                        <?php echo e($ditolak); ?>


                    </span>

                </div>

            </div>

        </div>

    </div>



    
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        
        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-lg p-6 transition duration-300">

            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-6">

                Quick Statistics

            </h2>

            <div class="space-y-6">

                <?php $__currentLoopData = [

                    ['Total Laporan',$totalLaporan,'blue',100],

                    ['Disetujui',$disetujui,'emerald',$totalLaporan ? ($disetujui/$totalLaporan)*100 : 0],

                    ['Menunggu',$menunggu,'amber',$totalLaporan ? ($menunggu/$totalLaporan)*100 : 0],

                    ['Ditolak',$ditolak,'rose',$totalLaporan ? ($ditolak/$totalLaporan)*100 : 0],

                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label,$val,$col,$w]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <div>

                    <div class="flex justify-between mb-2 text-sm">

                        <span class="text-slate-600 dark:text-slate-300">

                            <?php echo e($label); ?>


                        </span>

                        <span class="font-bold text-<?php echo e($col); ?>-600">

                            <?php echo e($val); ?>


                        </span>

                    </div>

                    <div class="w-full h-2 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">

                        <div
                            class="h-full rounded-full bg-<?php echo e($col); ?>-500 transition-all"
                            style="width: <?php echo e($w); ?>%">

                        </div>

                    </div>

                </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>

        </div>



        
        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-lg p-6 transition duration-300">

            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-6">

                System Information

            </h2>

            <div class="space-y-5 text-sm">

                <div class="border-l-4 border-blue-500 pl-4">

                    <h4 class="font-semibold text-slate-900 dark:text-white">

                        Monitoring Laporan Harian

                    </h4>

                    <p class="text-slate-500 dark:text-slate-400">

                        Semua laporan dikirim melalui WhatsApp Bot langsung ke sistem.

                    </p>

                </div>

                <div class="border-l-4 border-emerald-500 pl-4">

                    <h4 class="font-semibold text-slate-900 dark:text-white">

                        Verifikasi Admin

                    </h4>

                    <p class="text-slate-500 dark:text-slate-400">

                        Administrator memverifikasi laporan sebelum disahkan.

                    </p>

                </div>

                <div class="border-l-4 border-amber-500 pl-4">

                    <h4 class="font-semibold text-slate-900 dark:text-white">

                        Cetak PDF

                    </h4>

                    <p class="text-slate-500 dark:text-slate-400">

                        Laporan terverifikasi dapat dicetak dalam format A4.

                    </p>

                </div>

                <div class="border-l-4 border-slate-500 pl-4">

                    <h4 class="font-semibold text-slate-900 dark:text-white">

                        Latest Verification

                    </h4>

                    <ul class="mt-2 space-y-2">

                        <?php $__empty_1 = true; $__currentLoopData = $verifikasiTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <li class="flex justify-between">

                            <span class="truncate text-slate-700 dark:text-slate-300">

                                <?php echo e($v->laporan->nama_proyek ?? '-'); ?>


                            </span>

                            <span class="text-xs <?php echo e($v->status==='Disetujui' ? 'text-emerald-600' : 'text-rose-600'); ?>">

                                <?php echo e($v->status); ?>


                                ·

                                <?php echo e(optional($v->tanggal_verifikasi)->diffForHumans()); ?>


                            </span>

                        </li>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <li class="italic text-slate-400 dark:text-slate-500">

                            Belum ada verifikasi.

                        </li>

                        <?php endif; ?>

                    </ul>

                </div>

            </div>

        </div>

    </div>



    
    <?php /**PATH C:\Users\usera\Downloads\monitoring-laporanpkn-refactor\monitoring-laporanpkn1\resources\views/dashboard/index.blade.php ENDPATH**/ ?>