

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-3xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-slate-800"><?php echo e(isset($laporan) ? 'Edit' : 'Tambah'); ?> Laporan Harian</h1>
        <p class="text-slate-500 mb-8">Isi seluruh data laporan pekerjaan proyek.</p>

        <?php if($errors->any()): ?>
        <div class="bg-rose-100 border border-rose-300 text-rose-700 rounded-xl p-4 mb-6">
            <ul class="list-disc pl-4">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($e); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php $l = $laporan ?? null; ?>

        <form action="<?php echo e($l ? route('laporan.update',$l) : route('laporan.store')); ?>" method="POST" data-testid="form-laporan">
            <?php echo csrf_field(); ?>
            <?php if($l): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="font-semibold text-slate-700 text-sm">Karyawan (PIC Bot)</label>
                    <select name="karyawan_id" required class="w-full mt-2 rounded-xl border-slate-300" data-testid="select-karyawan">
                        <option value="">-- Pilih Karyawan --</option>
                        <?php $__currentLoopData = $karyawans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($k->id); ?>" <?php if(old('karyawan_id', $l->karyawan_id ?? null)==$k->id): echo 'selected'; endif; ?>><?php echo e($k->nama); ?> (<?php echo e($k->jabatan); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div>
                    <label class="font-semibold text-slate-700 text-sm">Tanggal</label>
                    <input type="date" name="tanggal" required value="<?php echo e(old('tanggal', optional($l?->tanggal)->format('Y-m-d'))); ?>"
                           class="w-full mt-2 rounded-xl border-slate-300" data-testid="input-tanggal">
                </div>

                <?php
                    $fields = [
                        ['nama_proyek','Nama Proyek',true],
                        ['kegiatan','Kegiatan',true],
                        ['sub_kegiatan','Sub Kegiatan',false],
                        ['pekerjaan','Pekerjaan',true],
                        ['lokasi','Lokasi',true],
                        ['kontraktor','Kontraktor',false],
                        ['konsultan','Konsultan',false],
                        ['pic','PIC',false],
                        ['minggu_ke','Minggu Ke',false],
                    ];
                ?>
                <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$name,$label,$req]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>
                    <label class="font-semibold text-slate-700 text-sm"><?php echo e($label); ?> <?php if($req): ?><span class="text-rose-500">*</span><?php endif; ?></label>
                    <input type="text" name="<?php echo e($name); ?>" value="<?php echo e(old($name, $l->$name ?? '')); ?>" <?php if($req): ?> required <?php endif; ?>
                           class="w-full mt-2 rounded-xl border-slate-300" data-testid="input-<?php echo e($name); ?>">
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div class="md:col-span-2">
                    <label class="font-semibold text-slate-700 text-sm">Status</label>
                    <select name="status" class="w-full mt-2 rounded-xl border-slate-300" data-testid="select-status">
                        <?php $__currentLoopData = ['Menunggu','Disetujui','Ditolak']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s); ?>" <?php if(old('status', $l->status ?? 'Menunggu')===$s): echo 'selected'; endif; ?>><?php echo e($s); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="font-semibold text-slate-700 text-sm">Catatan</label>
                    <textarea name="catatan" rows="3" class="w-full mt-2 rounded-xl border-slate-300"><?php echo e(old('catatan', $l->catatan ?? '')); ?></textarea>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <a href="<?php echo e(route('laporan.index')); ?>" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-6 py-3 rounded-xl">Batal</a>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold" data-testid="btn-simpan">
                    <?php echo e($l ? 'Update' : 'Simpan'); ?> Laporan
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\usera\Downloads\monitoring-laporanpkn-refactor\monitoring-laporanpkn1\resources\views/laporan/create.blade.php ENDPATH**/ ?>