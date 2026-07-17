

<?php $__env->startSection('content'); ?>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">
                <?php echo e(isset($laporan) ? 'Edit' : 'Tambah'); ?> Laporan Harian
            </h2>
            <p class="text-slate-500 dark:text-slate-400 mt-2 font-medium">
                Isi seluruh data laporan pekerjaan proyek pelaporan harian.
            </p>
        </div>
    </div>

    <?php if($errors->any()): ?>
        <div
            class="mb-6 flex w-full border-l-6 border-red-500 bg-red-500 bg-opacity-[15%] px-7 py-4 shadow-md dark:bg-[#1B1B24] dark:bg-opacity-30">
            <div class="mr-5 flex h-9 w-full max-w-[36px] items-center justify-center rounded-lg bg-red-500">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10.8248 11.6669C10.7415 11.6669 10.6582 11.6335 10.5915 11.5835L7.9915 9.46685L5.3915 11.5835C5.25817 11.6835 5.07484 11.6835 4.9415 11.5668C4.80817 11.4502 4.7915 11.2669 4.8915 11.1335L7.6915 8.01685C7.82484 7.86685 8.15817 7.86685 8.2915 8.01685L11.0915 11.1335C11.1915 11.2669 11.1748 11.4502 11.0415 11.5668C10.9748 11.6335 10.8915 11.6669 10.8248 11.6669Z"
                        fill="white"></path>
                    <path
                        d="M8 15.3333C3.96667 15.3333 0.666667 12.0333 0.666667 8C0.666667 3.96667 3.96667 0.666667 8 0.666667C12.0333 0.666667 15.3333 3.96667 15.3333 8C15.3333 12.0333 12.0333 15.3333 8 15.3333ZM8 2C4.68333 2 2 4.68333 2 8C2 11.3167 4.68333 14 8 14C11.3167 14 14 11.3167 14 8C14 4.68333 11.3167 2 8 2Z"
                        fill="white"></path>
                    <path
                        d="M7.99984 10.3335C7.63317 10.3335 7.33317 10.0335 7.33317 9.66683V5.00016C7.33317 4.6335 7.63317 4.3335 7.99984 4.3335C8.3665 4.3335 8.6665 4.6335 8.6665 5.00016V9.66683C8.6665 10.0335 8.3665 10.3335 7.99984 10.3335Z"
                        fill="white"></path>
                </svg>
            </div>
            <div class="w-full">
                <h5 class="mb-2 text-md font-bold text-[#B45454]">Terdapat Kesalahan Input</h5>
                <ul class="list-disc pl-4 text-sm font-medium text-[#CD5D5D]">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($e); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <div
        class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-transparent dark:border-slate-700/50 overflow-hidden">
        <div class="border-b border-gray-100 py-6 px-8 dark:border-slate-700/50">
            <h3 class="font-bold text-xl text-slate-800 dark:text-white">
                Formulir Data Laporan
            </h3>
        </div>
        <?php $l = $laporan ?? null; ?>
        <form action="<?php echo e($l ? route('laporan.update', $l) : route('laporan.store')); ?>" method="POST"
            data-testid="form-laporan">
            <?php echo csrf_field(); ?>
            <?php if($l): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

            <div class="p-8">
                <div class="mb-6 flex flex-col gap-6 sm:flex-row">
                    <div class="w-full sm:w-1/2">
                        <label class="font-semibold text-slate-700 dark:text-slate-300 block mb-2">Karyawan (PIC Bot) <span
                                class="text-red-500">*</span></label>
                        <select name="karyawan_id" required
                            class="w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white py-3 px-5 outline-none transition focus:ring-blue-500 dark:focus:ring-blue-500/50">
                            <option value="" disabled selected class="text-gray-500">-- Pilih Karyawan --</option>
                            <?php $__currentLoopData = $karyawans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($k->id); ?>" <?php if(old('karyawan_id', $l->karyawan_id ?? null) == $k->id): echo 'selected'; endif; ?>>
                                    <?php echo e($k->nama); ?> (<?php echo e($k->jabatan); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="w-full sm:w-1/2">
                        <label class="font-semibold text-slate-700 dark:text-slate-300 block mb-2">Tanggal <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" required
                            value="<?php echo e(old('tanggal', optional($l?->tanggal)->format('Y-m-d'))); ?>"
                            class="w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white py-3 px-5 outline-none transition focus:ring-blue-500 dark:focus:ring-blue-500/50">
                    </div>
                </div>

                <?php
                    $fields = [
                        ['nama_proyek', 'Nama Proyek', true],
                        ['kegiatan', 'Kegiatan', true],
                        ['sub_kegiatan', 'Sub Kegiatan', false],
                        ['pekerjaan', 'Pekerjaan', true],
                        ['lokasi', 'Lokasi', true],
                        ['kontraktor', 'Kontraktor', false],
                        ['konsultan', 'Konsultan', false],
                        ['pic', 'PIC', false],
                        ['minggu_ke', 'Minggu Ke', false],
                    ];
                    // Chunk ke dalam baris dengan 2 kolom
                    $chunks = array_chunk($fields, 2);
                ?>

                <?php $__currentLoopData = $chunks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="mb-6 flex flex-col gap-6 sm:flex-row">
                        <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$name, $label, $req]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="w-full sm:w-1/2">
                                <label class="font-semibold text-slate-700 dark:text-slate-300 block mb-2"><?php echo e($label); ?>

                                    <?php if($req): ?><span class="text-red-500">*</span><?php endif; ?></label>
                                <input type="text" name="<?php echo e($name); ?>" value="<?php echo e(old($name, $l->$name ?? '')); ?>" <?php if($req): ?> required
                                <?php endif; ?>
                                    class="w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white py-3 px-5 outline-none transition focus:ring-blue-500 dark:focus:ring-blue-500/50">
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div class="mb-6">
                    <label class="font-semibold text-slate-700 dark:text-slate-300 block mb-2">Status</label>
                    <select name="status"
                        class="w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white py-3 px-5 outline-none transition focus:ring-blue-500 dark:focus:ring-blue-500/50">
                        <?php $__currentLoopData = ['Menunggu', 'Disetujui', 'Ditolak']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s); ?>" <?php if(old('status', $l->status ?? 'Menunggu') === $s): echo 'selected'; endif; ?>><?php echo e($s); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="mb-8">
                    <label class="font-semibold text-slate-700 dark:text-slate-300 block mb-2">Catatan</label>
                    <textarea name="catatan" rows="4" placeholder="Ketik catatan jika diperlukan"
                        class="w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white py-3 px-5 outline-none transition focus:ring-blue-500 dark:focus:ring-blue-500/50"><?php echo e(old('catatan', $l->catatan ?? '')); ?></textarea>
                </div>

                <div class="flex items-center gap-4 justify-end pt-2">
                    <a href="<?php echo e(route('laporan.index')); ?>"
                        class="flex justify-center rounded-xl bg-slate-200 dark:bg-slate-700 px-8 py-3 font-semibold text-slate-800 dark:text-slate-100 hover:bg-slate-300 dark:hover:bg-slate-600 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex justify-center rounded-xl bg-blue-600 px-8 py-3 font-semibold text-white hover:bg-blue-700 shadow-md shadow-blue-500/20 transition">
                        <?php echo e($l ? 'Update' : 'Simpan'); ?> Laporan
                    </button>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Downloads\MAGANG VENA\monitoring-laporanpkn1\resources\views/laporan/create.blade.php ENDPATH**/ ?>