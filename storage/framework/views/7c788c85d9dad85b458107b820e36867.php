

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Detail Laporan Harian</h1>
            <p class="text-slate-500"><?php echo e($laporan->nama_proyek); ?> · <?php echo e($laporan->tanggal->format('d M Y')); ?></p>
        </div>
        <div class="flex gap-3">
            <a href="<?php echo e(route('laporan.index')); ?>" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-5 py-2.5 rounded-xl">Kembali</a>
            <a href="<?php echo e(route('pdf.harian',$laporan)); ?>" target="_blank" class="bg-rose-600 hover:bg-rose-700 text-white px-5 py-2.5 rounded-xl">Cetak PDF</a>
            <?php if($laporan->status==='Menunggu'): ?>
            <a href="<?php echo e(route('verifikasi.show',$laporan)); ?>" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl">Verifikasi</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white rounded-3xl shadow-lg p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Informasi Proyek</h2>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                    <?php $__currentLoopData = [
                        'Nama Proyek'=>$laporan->nama_proyek,
                        'Kegiatan'=>$laporan->kegiatan,
                        'Sub Kegiatan'=>$laporan->sub_kegiatan,
                        'Pekerjaan'=>$laporan->pekerjaan,
                        'Lokasi'=>$laporan->lokasi,
                        'Kontraktor'=>$laporan->kontraktor,
                        'Konsultan'=>$laporan->konsultan,
                        'PIC'=>$laporan->pic,
                        'Minggu Ke'=>$laporan->minggu_ke,
                        'Tanggal'=>$laporan->tanggal->format('d M Y'),
                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border-b border-slate-100 py-2">
                        <dt class="text-slate-500 text-xs uppercase"><?php echo e($k); ?></dt>
                        <dd class="text-slate-800 font-medium"><?php echo e($v ?: '-'); ?></dd>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </dl>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-3xl shadow-lg p-6">
                    <h2 class="text-lg font-bold text-slate-800 mb-4">Material</h2>
                    <table class="w-full text-sm">
                        <thead class="text-left text-slate-500 border-b"><tr><th class="py-2">Material</th><th>Vol</th><th>Satuan</th></tr></thead>
                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $laporan->materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="border-b"><td class="py-2"><?php echo e($m->nama_material); ?></td><td><?php echo e($m->volume); ?></td><td><?php echo e($m->satuan); ?></td></tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="3" class="text-slate-400 py-3 text-center">Tidak ada material.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="bg-white rounded-3xl shadow-lg p-6">
                    <h2 class="text-lg font-bold text-slate-800 mb-4">Alat</h2>
                    <table class="w-full text-sm">
                        <thead class="text-left text-slate-500 border-b"><tr><th class="py-2">Nama Alat</th><th>Jumlah</th></tr></thead>
                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $laporan->alats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="border-b"><td class="py-2"><?php echo e($a->nama_alat); ?></td><td><?php echo e($a->jumlah); ?></td></tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="2" class="text-slate-400 py-3 text-center">Tidak ada alat.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-lg p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Tenaga Kerja</h2>
                <?php $__empty_1 = true; $__currentLoopData = $laporan->tenagas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="grid grid-cols-4 gap-4 text-center">
                    <?php $__currentLoopData = ['Pekerja'=>$t->pekerja,'Tukang'=>$t->tukang,'Mandor'=>$t->mandor,'Pelaksana'=>$t->pelaksana]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-blue-50 rounded-2xl p-4">
                        <p class="text-xs text-slate-500"><?php echo e($l); ?></p>
                        <p class="text-2xl font-bold text-blue-700"><?php echo e($v); ?></p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-slate-400 text-sm">Tidak ada data tenaga kerja.</p>
                <?php endif; ?>
            </div>

            <div class="bg-white rounded-3xl shadow-lg p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Dokumentasi Foto</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <?php $__empty_1 = true; $__currentLoopData = $laporan->fotos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="rounded-2xl overflow-hidden bg-slate-100">
                        <img src="<?php echo e(asset('storage/'.$f->foto)); ?>" class="w-full h-40 object-cover">
                        <?php if($f->keterangan): ?><div class="p-2 text-xs text-slate-600"><?php echo e($f->keterangan); ?></div><?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-full text-center py-10 text-slate-400 border-2 border-dashed border-slate-200 rounded-2xl">Belum ada dokumentasi.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-3xl shadow-lg p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Status</h2>
                <div class="text-center py-4">
                    <?php echo $__env->make('partials.status-badge', ['status' => $laporan->status], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
                <?php if($laporan->catatan): ?>
                <div class="mt-4 bg-slate-50 rounded-xl p-3 text-sm text-slate-700">
                    <p class="text-xs uppercase text-slate-500 mb-1">Catatan</p>
                    <?php echo e($laporan->catatan); ?>

                </div>
                <?php endif; ?>
            </div>

            <div class="bg-white rounded-3xl shadow-lg p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Karyawan</h2>
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-xl">
                        <?php echo e(strtoupper(substr($laporan->karyawan->nama ?? '?',0,1))); ?>

                    </div>
                    <div>
                        <p class="font-bold"><?php echo e($laporan->karyawan->nama ?? '-'); ?></p>
                        <p class="text-xs text-slate-500"><?php echo e($laporan->karyawan->jabatan ?? '-'); ?></p>
                        <p class="text-xs text-slate-500"><?php echo e($laporan->karyawan->no_hp ?? '-'); ?></p>
                    </div>
                </div>
            </div>

            <?php if($laporan->verifikasi): ?>
            <div class="bg-white rounded-3xl shadow-lg p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Verifikasi</h2>
                <p class="text-sm"><span class="text-slate-500">Oleh:</span> <b><?php echo e($laporan->verifikasi->user->name ?? '-'); ?></b></p>
                <p class="text-sm mt-2"><span class="text-slate-500">Tanggal:</span> <?php echo e(optional($laporan->verifikasi->tanggal_verifikasi)->format('d M Y H:i')); ?></p>
                <p class="text-sm mt-2"><span class="text-slate-500">Catatan:</span> <?php echo e($laporan->verifikasi->catatan ?? '-'); ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\usera\Downloads\monitoring-laporanpkn-refactor\monitoring-laporanpkn1\resources\views/laporan/show.blade.php ENDPATH**/ ?>