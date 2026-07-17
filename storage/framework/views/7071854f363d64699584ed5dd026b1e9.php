

<?php $__env->startSection('content'); ?>

<div class="max-w-5xl mx-auto">

    <div class="bg-white rounded-3xl shadow-lg">

        <div class="border-b px-8 py-6">

            <h1 class="text-3xl font-bold text-slate-800">
                Edit Karyawan
            </h1>

            <p class="text-slate-500 mt-2">
                Perbarui data karyawan.
            </p>

        </div>

        <?php if($errors->any()): ?>

        <div class="mx-8 mt-6 bg-red-100 border border-red-300 text-red-700 rounded-xl p-4">

            <ul class="list-disc ml-5">

                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <li><?php echo e($error); ?></li>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </ul>

        </div>

        <?php endif; ?>

        <form action="<?php echo e(route('karyawan.update',$karyawan->id)); ?>" method="POST">

            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="p-8 grid grid-cols-2 gap-6">

                <div>

                    <label class="font-semibold">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="nama"
                        value="<?php echo e(old('nama',$karyawan->nama)); ?>"
                        class="mt-2 w-full rounded-xl border-gray-300"
                        required>

                </div>

                <div>

                    <label class="font-semibold">
                        Jabatan
                    </label>

                    <select
                        name="jabatan"
                        class="mt-2 w-full rounded-xl border-gray-300">

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

                        <option
                            value="<?php echo e($j); ?>"
                            <?php echo e($karyawan->jabatan==$j ? 'selected':''); ?>>

                            <?php echo e($j); ?>


                        </option>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </select>

                </div>

                <div>

                    <label class="font-semibold">
                        Nomor WhatsApp
                    </label>

                    <input
                        type="text"
                        name="no_hp"
                        value="<?php echo e(old('no_hp',$karyawan->no_hp)); ?>"
                        class="mt-2 w-full rounded-xl border-gray-300"
                        required>

                </div>

                <div>

                    <label class="font-semibold">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="<?php echo e(old('email',$karyawan->email)); ?>"
                        class="mt-2 w-full rounded-xl border-gray-300"
                        required>

                </div>

                <div>

                    <label class="font-semibold">
                        Status
                    </label>

                    <select
                        name="status"
                        class="mt-2 w-full rounded-xl border-gray-300">

                        <option
                            value="aktif"
                            <?php echo e($karyawan->status=='aktif' ? 'selected':''); ?>>

                            Aktif

                        </option>

                        <option
                            value="nonaktif"
                            <?php echo e($karyawan->status=='nonaktif' ? 'selected':''); ?>>

                            Nonaktif

                        </option>

                    </select>

                </div>

            </div>

            <div class="border-t px-8 py-6 flex justify-end gap-3">

                <a href="<?php echo e(route('karyawan.index')); ?>"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl">

                    Kembali

                </a>

                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl">

                    Update

                </button>

            </div>

        </form>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\usera\Downloads\monitoring-laporanpkn-refactor\monitoring-laporanpkn1\resources\views/master/karyawan/edit.blade.php ENDPATH**/ ?>