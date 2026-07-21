<?php $__env->startSection('content'); ?>
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Detail Laporan Harian
        </h2>
        <p class="text-sm mt-1 text-slate-500 dark:text-slate-400">
            <?php echo e($laporan->nama_proyek); ?> &middot; <?php echo e($laporan->tanggal->format('d M Y')); ?>

        </p>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="<?php echo e(route('laporan.index')); ?>" class="inline-flex items-center justify-center rounded-md bg-gray-200 py-2.5 px-6 font-medium text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition">
            Kembali
        </a>
        <a href="<?php echo e(route('pdf.harian', $laporan)); ?>" target="_blank" class="inline-flex items-center justify-center rounded-md bg-red-500 py-2.5 px-6 font-medium text-white hover:bg-red-600 transition">
            Cetak PDF
        </a>
        <?php if($laporan->status==='Menunggu'): ?>
        <a href="<?php echo e(route('verifikasi.show', $laporan)); ?>" class="inline-flex items-center justify-center rounded-md bg-green-500 py-2.5 px-6 font-medium text-white hover:bg-green-600 transition">
            Verifikasi
        </a>
        <?php endif; ?>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
    
    <!-- Bagian Kiri (Detail Laporan) -->
    <div class="xl:col-span-2 flex flex-col gap-6">
        
        <!-- Informasi Proyek -->
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                <h3 class="font-bold text-gray-800 dark:text-white">Informasi Proyek</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <?php $__currentLoopData = [
                        'Nama Proyek' => $laporan->nama_proyek,
                        'Kegiatan' => $laporan->kegiatan,
                        'Sub Kegiatan' => $laporan->sub_kegiatan,
                        'Pekerjaan' => $laporan->pekerjaan,
                        'Lokasi' => $laporan->lokasi,
                        'Kontraktor' => $laporan->kontraktor,
                        'Konsultan' => $laporan->konsultan,
                        'PIC' => $laporan->pic,
                        'Minggu Ke' => $laporan->minggu_ke,
                        'Tanggal' => $laporan->tanggal->format('d M Y'),
                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border-b border-gray-100 pb-3 dark:border-gray-800">
                        <span class="block text-xs font-semibold uppercase text-gray-400 dark:text-gray-500 mb-1"><?php echo e($k); ?></span>
                        <span class="block text-sm font-medium text-gray-800 dark:text-gray-200"><?php echo e($v ?: '-'); ?></span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        <!-- Material & Alat (Grid 2 Kolom) -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <!-- Material -->
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                    <h3 class="font-bold text-gray-800 dark:text-white">Material</h3>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="text-left text-xs font-medium text-gray-400 dark:text-gray-500">
                                <th class="pb-2">Material</th>
                                <th class="pb-2">Vol</th>
                                <th class="pb-2">Satuan</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm font-medium text-gray-800 dark:text-gray-200">
                            <?php $__empty_1 = true; $__currentLoopData = $laporan->materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="border-t border-gray-100 dark:border-gray-800">
                                <td class="py-2"><?php echo e($m->nama_material); ?></td>
                                <td class="py-2"><?php echo e($m->volume); ?></td>
                                <td class="py-2"><?php echo e($m->satuan); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr class="border-t border-gray-100 dark:border-gray-800">
                                <td colspan="3" class="py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada material.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Alat -->
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                    <h3 class="font-bold text-gray-800 dark:text-white">Alat</h3>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="text-left text-xs font-medium text-gray-400 dark:text-gray-500">
                                <th class="pb-2">Nama Alat</th>
                                <th class="pb-2">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm font-medium text-gray-800 dark:text-gray-200">
                            <?php $__empty_1 = true; $__currentLoopData = $laporan->alats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="border-t border-gray-100 dark:border-gray-800">
                                <td class="py-2"><?php echo e($a->nama_alat); ?></td>
                                <td class="py-2"><?php echo e($a->jumlah); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr class="border-t border-gray-100 dark:border-gray-800">
                                <td colspan="2" class="py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada alat.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tenaga Kerja -->
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                <h3 class="font-bold text-gray-800 dark:text-white">Tenaga Kerja</h3>
            </div>
            <div class="p-6">
                <?php $__empty_1 = true; $__currentLoopData = $laporan->tenagas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                    <?php $__currentLoopData = ['Pekerja' => $t->pekerja, 'Tukang' => $t->tukang, 'Mandor' => $t->mandor, 'Pelaksana' => $t->pelaksana]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="rounded-xl border border-blue-200 bg-blue-50 py-4 px-2 dark:border-blue-900 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400">
                        <span class="block text-xs font-semibold uppercase mb-1"><?php echo e($l); ?></span>
                        <span class="block text-2xl font-bold"><?php echo e($v); ?></span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-center text-gray-500 dark:text-gray-400 text-sm">Tidak ada data tenaga kerja.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Dokumentasi Foto -->
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                <h3 class="font-bold text-gray-800 dark:text-white">Dokumentasi Foto</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <?php $__empty_1 = true; $__currentLoopData = $laporan->fotos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="rounded-lg border border-gray-100 border-opacity-50 bg-gray-50 dark:border-gray-800 dark:bg-gray-800/50 overflow-hidden shadow-sm">
                        <img src="<?php echo e(asset('storage/'.$f->foto)); ?>" class="h-40 w-full object-cover">
                        <?php if($f->keterangan): ?>
                        <div class="p-3">
                            <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($f->keterangan); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-full rounded-lg border border-dashed border-gray-300 py-10 text-center dark:border-gray-700">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada dokumentasi.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div> <!-- /Bagian Kiri -->

    <!-- Bagian Kanan (Sidebar info) -->
    <div class="flex flex-col gap-6">
        
        <!-- Status Panel -->
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                <h3 class="font-bold text-gray-800 dark:text-white">Status Laporan</h3>
            </div>
            <div class="p-6 text-center">
                <?php if($laporan->status=="Menunggu"): ?>
                    <span class="inline-flex rounded-full bg-yellow-100 py-2 px-6 text-sm font-semibold text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500">Menunggu</span>
                <?php elseif($laporan->status=="Disetujui"): ?>
                    <span class="inline-flex rounded-full bg-green-100 py-2 px-6 text-sm font-semibold text-green-800 dark:bg-green-900/30 dark:text-green-400">Disetujui</span>
                <?php else: ?>
                    <span class="inline-flex rounded-full bg-red-100 py-2 px-6 text-sm font-semibold text-red-800 dark:bg-red-900/30 dark:text-red-400">Ditolak</span>
                <?php endif; ?>
                
                <?php if($laporan->catatan): ?>
                <div class="mt-4 rounded-lg bg-gray-50 p-4 text-left border border-gray-100 dark:border-gray-800 dark:bg-gray-800/50">
                    <span class="block text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 mb-2">Catatan</span>
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300"><?php echo e($laporan->catatan); ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pengisi Laporan (Karyawan) -->
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                <h3 class="font-bold text-gray-800 dark:text-white">Pengirim</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-blue-600 text-xl font-bold text-white shadow-sm">
                        <?php echo e(strtoupper(substr($laporan->karyawan->nama ?? '?', 0, 1))); ?>

                    </div>
                    <div>
                        <p class="font-bold text-gray-800 dark:text-white"><?php echo e($laporan->karyawan->nama ?? '-'); ?></p>
                        <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($laporan->karyawan->jabatan ?? '-'); ?></p>
                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500"><?php echo e($laporan->karyawan->no_hp ?? '-'); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tracker Verifikasi -->
        <?php if($laporan->verifikasi): ?>
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-800">
                <h3 class="font-bold text-gray-800 dark:text-white">Riwayat Verifikasi</h3>
            </div>
            <div class="p-6 text-sm">
                <p class="mb-2"><span class="font-medium text-gray-500 dark:text-gray-400">Oleh:</span> <span class="font-semibold text-gray-800 dark:text-white"><?php echo e($laporan->verifikasi->user->name ?? '-'); ?></span></p>
                <p class="mb-2"><span class="font-medium text-gray-500 dark:text-gray-400">Tanggal:</span> <span class="text-gray-800 dark:text-white"><?php echo e(optional($laporan->verifikasi->tanggal_verifikasi)->format('d M Y H:i')); ?></span></p>
                <?php if($laporan->verifikasi->catatan): ?>
                <div class="mt-3">
                    <span class="block font-medium text-gray-500 dark:text-gray-400 mb-1">Catatan:</span>
                    <p class="text-gray-800 dark:text-gray-300 bg-gray-50 dark:bg-gray-800/50 p-3 rounded-md"><?php echo e($laporan->verifikasi->catatan); ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

    </div> <!-- /Bagian Kanan -->

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\akuna\OneDrive\Dokumen\KULIAH ITN MALANG\SEMESTER 7\PKN 2318105\Bot-Monitoring-Pekerjaan\resources\views/laporan/show.blade.php ENDPATH**/ ?>