

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-title-md2 font-bold text-black dark:text-white hover:text-blue-500 transition-colors" data-testid="dashboard-title">Dashboard Monitoring</h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Selamat datang di Sistem Monitoring Laporan Harian PT Reno Abirama Sakti.</p>
        </div>
        <div class="rounded-xl bg-blue-600 px-6 py-4 text-white shadow-sm flex flex-col items-end shrink-0">
            <p class="text-xs font-medium opacity-80 uppercase tracking-widest">Hari Ini</p>
            <h3 class="text-xl font-bold"><?php echo e(now()->translatedFormat('d F Y')); ?></h3>
        </div>
    </div>

    
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5">
        <?php
            $cards = [
                ['label'=>'Total Laporan','value'=>$totalLaporan,'color'=>'blue','iconColor'=>'text-blue-600 dark:text-blue-500','iconBg'=>'bg-blue-50 dark:bg-blue-500/20','sub'=>'Semua laporan masuk','testid'=>'card-total','icon'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ['label'=>'Menunggu','value'=>$menunggu,'color'=>'yellow','iconColor'=>'text-yellow-600 dark:text-yellow-500','iconBg'=>'bg-yellow-50 dark:bg-yellow-500/20','sub'=>'Menunggu verifikasi','testid'=>'card-menunggu','icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label'=>'Disetujui','value'=>$disetujui,'color'=>'green','iconColor'=>'text-green-600 dark:text-green-500','iconBg'=>'bg-green-50 dark:bg-green-500/20','sub'=>'Laporan disetujui','testid'=>'card-disetujui','icon'=>'M9 12l2 2 4-4M12 22a10 10 0 100-20 10 10 0 000 20z'],
                ['label'=>'Ditolak','value'=>$ditolak,'color'=>'red','iconColor'=>'text-red-600 dark:text-red-500','iconBg'=>'bg-red-50 dark:bg-red-500/20','sub'=>'Laporan ditolak','testid'=>'card-ditolak','icon'=>'M6 18L18 6M6 6l12 12'],
            ];
        ?>
        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="rounded-xl border border-gray-200 bg-white py-6 px-7 shadow-sm dark:border-gray-800 dark:bg-gray-900 hover:shadow-md transition" data-testid="<?php echo e($c['testid']); ?>">
            <div class="flex h-11 w-11 items-center justify-center rounded-full <?php echo e($c['iconBg']); ?>">
                <svg class="w-6 h-6 <?php echo e($c['iconColor']); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($c['icon']); ?>"/>
                </svg>
            </div>

            <div class="mt-4 flex items-end justify-between">
                <div>
                    <h4 class="text-title-md font-bold text-black dark:text-white">
                        <?php echo e($c['value']); ?>

                    </h4>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400"><?php echo e($c['label']); ?></span>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 rounded-xl border border-gray-200 bg-white px-5 pt-7 pb-5 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:px-7.5">
            <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-black dark:text-white">Grafik Laporan</h2>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">7 hari terakhir</p>
                </div>
                <div class="flex gap-2">
                    <button data-chart="weekly" class="chart-tab rounded-md px-4 py-1.5 text-xs font-semibold bg-blue-600 text-white transition hover:opacity-90">Mingguan</button>
                    <button data-chart="monthly" class="chart-tab rounded-md px-4 py-1.5 text-xs font-semibold bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300 transition hover:opacity-90">Bulanan</button>
                </div>
            </div>
            <div class="w-full relative h-[300px]">
                <canvas id="laporanChart"></canvas>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white px-5 pt-7 pb-5 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:px-7.5 h-full flex flex-col">
            <h2 class="text-xl font-bold text-black dark:text-white mb-6">Status Laporan</h2>
            <div class="relative flex-1 flex flex-col justify-center min-h-[220px]">
                <canvas id="statusChart" class="max-h-[220px]"></canvas>
            </div>
            <div class="mt-6 space-y-3 text-sm">
                <div class="flex justify-between pb-2 border-b border-gray-100 dark:border-gray-800"><span class="text-gray-600 dark:text-gray-300">Disetujui</span><span class="font-bold text-green-600 dark:text-green-500"><?php echo e($disetujui); ?></span></div>
                <div class="flex justify-between pb-2 border-b border-gray-100 dark:border-gray-800"><span class="text-gray-600 dark:text-gray-300">Menunggu</span><span class="font-bold text-yellow-600 dark:text-yellow-500"><?php echo e($menunggu); ?></span></div>
                <div class="flex justify-between"><span class="text-gray-600 dark:text-gray-300">Ditolak</span><span class="font-bold text-red-600 dark:text-red-500"><?php echo e($ditolak); ?></span></div>
            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900 px-6 py-6">
            <h2 class="text-xl font-bold text-black dark:text-white mb-6">Analisis Progress</h2>
            <div class="space-y-6">
                <?php $__currentLoopData = [
                    ['Total Laporan',$totalLaporan,'blue',100],
                    ['Disetujui',$disetujui,'green',$totalLaporan? ($disetujui/$totalLaporan)*100 : 0],
                    ['Menunggu',$menunggu,'yellow',$totalLaporan? ($menunggu/$totalLaporan)*100 : 0],
                    ['Ditolak',$ditolak,'red',$totalLaporan? ($ditolak/$totalLaporan)*100 : 0],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label,$val,$col,$w]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>
                    <div class="flex justify-between mb-2 text-sm">
                        <span class="font-medium text-gray-800 dark:text-gray-200"><?php echo e($label); ?></span>
                        <span class="font-bold text-<?php echo e($col); ?>-600 dark:text-<?php echo e($col); ?>-400"><?php echo e($val); ?></span>
                    </div>
                    <div class="w-full h-2 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                        <div class="h-full rounded-full bg-<?php echo e($col); ?>-500 transition-all duration-500 ease-out" style="width: <?php echo e($w); ?>%"></div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900 px-6 py-6">
            <h2 class="text-xl font-bold text-black dark:text-white mb-6">Verifikasi Terbaru</h2>
            <div class="flex flex-col gap-4">
                <?php $__empty_1 = true; $__currentLoopData = $verifikasiTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center justify-between border-l-4 <?php echo e($v->status==='Disetujui' ? 'border-green-500' : 'border-red-500'); ?> pl-4 bg-gray-50 dark:bg-gray-800/50 p-3 rounded-r-lg">
                    <div class="flex flex-col">
                        <span class="font-semibold text-gray-800 dark:text-gray-200 text-sm truncate"><?php echo e($v->laporan->nama_proyek ?? '-'); ?></span>
                        <span class="text-xs text-gray-500 dark:text-gray-400 mt-1"><?php echo e(optional($v->tanggal_verifikasi)->diffForHumans()); ?></span>
                    </div>
                    <div>
                        <span class="inline-flex rounded-full text-xs font-semibold px-3 py-1 text-<?php echo e($v->status==='Disetujui' ? 'green' : 'red'); ?>-600 bg-<?php echo e($v->status==='Disetujui' ? 'green' : 'red'); ?>-100 dark:bg-<?php echo e($v->status==='Disetujui' ? 'green' : 'red'); ?>-900/30 dark:text-<?php echo e($v->status==='Disetujui' ? 'green' : 'red'); ?>-400"><?php echo e($v->status); ?></span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="py-8 text-center text-sm font-medium text-gray-500 border border-dashed border-gray-200 dark:border-gray-700 rounded-lg">
                    Belum ada riwayat verifikasi.
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="rounded-xl border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-sm dark:border-strokedark dark:bg-boxdark sm:px-7.5" data-testid="recent-reports">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold text-black dark:text-white">Laporan Terbaru</h2>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mt-1">Laporan harian yang baru masuk melalui WhatsApp Bot.</p>
            </div>
            <a href="<?php echo e(route('laporan.index')); ?>" class="px-5 py-2 text-sm font-medium rounded-md bg-blue-600 hover:bg-blue-700 text-white transition flex-shrink-0">
                Lihat Semua
            </a>
        </div>
        
        <div class="max-w-full overflow-x-auto pb-4">
            <table class="w-full table-auto">
                <thead class="bg-gray-50 dark:bg-meta-4 border-b border-stroke dark:border-strokedark">
                    <tr class="text-left text-sm font-semibold text-black dark:text-white">
                        <th class="py-4 px-2 font-medium">Tanggal</th>
                        <th class="py-4 px-2 font-medium">Proyek</th>
                        <th class="py-4 px-2 font-medium">Karyawan</th>
                        <th class="py-4 px-2 font-medium text-center">Status</th>
                        <th class="py-4 px-2 font-medium text-center lg:min-w-[120px]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stroke dark:divide-strokedark">
                    <?php $__empty_1 = true; $__currentLoopData = $laporanTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $laporan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-meta-4/50 transition">
                        <td class="py-4 px-2 text-sm font-medium text-black dark:text-white"><?php echo e($laporan->tanggal->format('d M Y')); ?></td>
                        <td class="py-4 px-2 text-sm font-semibold text-gray-800 dark:text-gray-200"><?php echo e($laporan->nama_proyek); ?></td>
                        <td class="py-4 px-2 text-sm font-medium text-gray-800 dark:text-gray-200"><?php echo e($laporan->karyawan->nama ?? '-'); ?></td>
                        <td class="py-4 px-2 text-center text-sm">
                            <?php if($laporan->status=="Menunggu"): ?>
                                <span class="inline-flex rounded-full bg-yellow-100 py-1 px-3 text-xs font-semibold text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500">Menunggu</span>
                            <?php elseif($laporan->status=="Disetujui"): ?>
                                <span class="inline-flex rounded-full bg-green-100 py-1 px-3 text-xs font-semibold text-green-800 dark:bg-green-900/30 dark:text-green-400">Disetujui</span>
                            <?php else: ?>
                                <span class="inline-flex rounded-full bg-red-100 py-1 px-3 text-xs font-semibold text-red-800 dark:bg-red-900/30 dark:text-red-400">Ditolak</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 px-2 text-center">
                            <a href="<?php echo e(route('laporan.show',$laporan)); ?>" class="inline-flex rounded bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-600 hover:bg-blue-600 hover:text-white transition dark:bg-blue-500/20 dark:text-blue-400 dark:hover:bg-blue-500 dark:hover:text-white">Detail</a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="text-center py-10 text-slate-500 dark:text-slate-400 border border-dashed rounded-lg border-stroke dark:border-strokedark">Belum ada laporan yang masuk.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const weekly  = { labels: <?php echo json_encode($weeklyLabels, 15, 512) ?>,  data: <?php echo json_encode($weeklyData, 15, 512) ?> };
const monthly = { labels: <?php echo json_encode($monthlyLabels, 15, 512) ?>, data: <?php echo json_encode($monthlyData, 15, 512) ?> };
const ctx = document.getElementById('laporanChart').getContext('2d');
const grad = ctx.createLinearGradient(0,0,0,300);
grad.addColorStop(0,'rgba(37,99,235,.2)'); grad.addColorStop(1,'rgba(37,99,235,0)');
const laporanChart = new Chart(ctx, {
    type:'line',
    data:{ labels: weekly.labels, datasets:[{ label:'Jumlah Laporan', data: weekly.data, borderWidth:2, borderColor:'#2563eb', backgroundColor:grad, fill:true, tension:.4, pointBackgroundColor:'#2563eb', pointRadius:4 }]},
    options:{ responsive:true, maintainAspectRatio: false, plugins:{ legend:{ display:false }}, scales:{ y:{ beginAtZero:true, ticks:{ precision:0, color:'#9ca3af' }, grid:{color:'rgba(156, 163, 175, 0.1)'}}, x:{ ticks:{ color:'#9ca3af' }, grid:{display:false}}}}
});
document.querySelectorAll('.chart-tab').forEach(btn=>{
    btn.addEventListener('click',()=>{
        document.querySelectorAll('.chart-tab').forEach(b=>{ b.classList.remove('bg-blue-600','text-white'); b.classList.add('bg-gray-100','text-gray-600','dark:bg-gray-800','dark:text-gray-300'); });
        btn.classList.add('bg-blue-600','text-white'); btn.classList.remove('bg-gray-100','text-gray-600','dark:bg-gray-800','dark:text-gray-300');
        const src = btn.dataset.chart==='weekly'?weekly:monthly;
        laporanChart.data.labels = src.labels; laporanChart.data.datasets[0].data = src.data; laporanChart.update();
    });
});
new Chart(document.getElementById('statusChart'),{
    type:'doughnut',
    data:{ labels:['Disetujui','Menunggu','Ditolak'], datasets:[{ data:<?php echo json_encode($statusChart, 15, 512) ?>, backgroundColor:['#10b981','#f59e0b','#ef4444'], borderWidth:0, hoverOffset: 4 }]},
    options:{ responsive:true, maintainAspectRatio: false, cutout:'70%', plugins:{ legend:{ display:false }}}
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Downloads\MAGANG VENA\monitoring-laporanpkn1\resources\views/dashboard/index.blade.php ENDPATH**/ ?>