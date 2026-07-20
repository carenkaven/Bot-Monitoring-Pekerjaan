

<?php $__env->startSection('content'); ?>

    <div class="max-w-5xl mx-auto">

        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-transparent dark:border-slate-700/50">

            <div class="border-b border-gray-100 dark:border-slate-700/50 px-8 py-6">

                <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
                    Edit Karyawan
                </h1>

                <p class="text-slate-500 dark:text-slate-400 mt-2">
                    Perbarui data karyawan.
                </p>

            </div>

            <?php if($errors->any()): ?>

                <div
                    class="mx-8 mt-6 bg-red-100 dark:bg-red-500/10 border border-red-300 dark:border-red-500/20 text-red-700 dark:text-red-400 rounded-xl p-4">

                    <ul class="list-disc ml-5 font-medium">

                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <li><?php echo e($error); ?></li>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </ul>

                </div>

            <?php endif; ?>

            <form action="<?php echo e(route('karyawan.update', $karyawan->id)); ?>" method="POST">

                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="p-8 grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">
                            Nama Lengkap
                        </label>

                        <input type="text" name="nama" value="<?php echo e(old('nama', $karyawan->nama)); ?>"
                            class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50"
                            required>

                    </div>

                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">
                            Jabatan
                        </label>

                        <select name="jabatan"
                            class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50">

                            <?php

                                $jabatan = [
                                    'Supervisor',
                                    'Mandor',
                                    'Site Engineer',
                                    'Quality Control',
                                    'Safety Officer',
                                    'Staff'
                                ];

                            ?>

                            <?php $__currentLoopData = $jabatan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option value="<?php echo e($j); ?>" <?php echo e($karyawan->jabatan == $j ? 'selected' : ''); ?>>

                                    <?php echo e($j); ?>


                                </option>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>

                    </div>

                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">
                            Nomor WhatsApp
                        </label>

                        <input type="text" name="no_hp" value="<?php echo e(old('no_hp', $karyawan->no_hp)); ?>"
                            class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50"
                            required>

                    </div>

                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">
                            Email
                        </label>

                        <input type="email" name="email" value="<?php echo e(old('email', $karyawan->email)); ?>"
                            class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50"
                            required>

                    </div>

                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">
                            Status
                        </label>

                        <select name="status"
                            class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50">

                            <option value="aktif" <?php echo e($karyawan->status == 'aktif' ? 'selected' : ''); ?>>

                                Aktif

                            </option>

                            <option value="nonaktif" <?php echo e($karyawan->status == 'nonaktif' ? 'selected' : ''); ?>>

                                Nonaktif

                            </option>

                        </select>

                    </div>

                </div>

                <div class="border-t border-gray-100 dark:border-slate-700/50 px-8 py-6 flex justify-end gap-3">

                    <a href="<?php echo e(route('karyawan.index')); ?>"
                        class="bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-800 dark:text-slate-100 px-6 py-2.5 rounded-xl transition font-medium">

                        Kembali

                    </a>

                    <button
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl shadow-md shadow-blue-500/20 transition font-medium">

                        Update

                    </button>

                </div>

            </form>

        </div>

    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Downloads\MAGANG VENA\monitoring-laporanpkn1\resources\views/master/karyawan/edit.blade.php ENDPATH**/ ?>