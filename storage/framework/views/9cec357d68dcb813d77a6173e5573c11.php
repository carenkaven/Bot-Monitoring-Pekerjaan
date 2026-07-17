

<?php $__env->startSection('content'); ?>

    <div class="max-w-5xl mx-auto">

        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-transparent dark:border-slate-700/50">

            <div class="border-b border-gray-100 dark:border-slate-700/50 px-8 py-6">

                <h1 class="text-3xl font-bold text-slate-800 dark:text-white">

                    Tambah Karyawan

                </h1>

                <p class="text-slate-500 dark:text-slate-400 mt-2">

                    Tambahkan karyawan baru agar dapat menggunakan WhatsApp Bot.

                </p>

            </div>

            
            <?php if($errors->any()): ?>
                <div
                    class="mx-8 mt-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700/50 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl">
                    <p class="font-semibold mb-1">Terjadi kesalahan:</p>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('karyawan.store')); ?>" method="POST">

                <?php echo csrf_field(); ?>

                <div class="p-8 grid grid-cols-1 lg:grid-cols-2 gap-6">

                    
                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">

                            Nama Lengkap

                        </label>

                        <input type="text" name="nama" value="<?php echo e(old('nama')); ?>" required class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50
                                <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 dark:border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

                        <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>

                    
                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">

                            Jabatan

                        </label>

                        <select name="jabatan" required class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50
                                <?php $__errorArgs = ['jabatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 dark:border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

                            <option value="" class="text-slate-400">-- Pilih Jabatan --</option>

                            <option <?php echo e(old('jabatan') == 'Supervisor' ? 'selected' : ''); ?>>Supervisor</option>
                            <option <?php echo e(old('jabatan') == 'Mandor' ? 'selected' : ''); ?>>Mandor</option>
                            <option <?php echo e(old('jabatan') == 'Site Engineer' ? 'selected' : ''); ?>>Site Engineer</option>
                            <option <?php echo e(old('jabatan') == 'Quality Control' ? 'selected' : ''); ?>>Quality Control</option>
                            <option <?php echo e(old('jabatan') == 'Safety Officer' ? 'selected' : ''); ?>>Safety Officer</option>
                            <option <?php echo e(old('jabatan') == 'Staff' ? 'selected' : ''); ?>>Staff</option>

                        </select>

                        <?php $__errorArgs = ['jabatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>

                    
                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">

                            Nomor WhatsApp

                        </label>

                        <input type="text" name="no_hp" value="<?php echo e(old('no_hp')); ?>" placeholder="628xxxxxxxxxx" required
                            class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50
                                <?php $__errorArgs = ['no_hp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 dark:border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

                        <?php $__errorArgs = ['no_hp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>

                    
                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">

                            Email

                        </label>

                        <input type="email" name="email" value="<?php echo e(old('email')); ?>" required class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 dark:border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>

                    
                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">

                            Password

                        </label>

                        <input type="password" name="password" required class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 dark:border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">

                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    </div>

                    
                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">

                            Konfirmasi Password

                        </label>

                        <input type="password" name="password_confirmation" required
                            class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50">

                    </div>

                    
                    <div>

                        <label class="font-semibold text-slate-700 dark:text-slate-300">

                            Status

                        </label>

                        <select name="status"
                            class="mt-2 w-full rounded-xl border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-blue-500 dark:focus:ring-blue-500/50">

                            <option value="aktif" <?php echo e(old('status') == 'aktif' ? 'selected' : ''); ?>>Aktif</option>

                            <option value="nonaktif" <?php echo e(old('status') == 'nonaktif' ? 'selected' : ''); ?>>Nonaktif</option>

                        </select>

                    </div>

                </div>

                <div class="border-t border-gray-100 dark:border-slate-700/50 px-8 py-6 flex justify-end gap-3">

                    <a href="<?php echo e(route('karyawan.index')); ?>"
                        class="bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-800 dark:text-slate-100 px-6 py-2.5 rounded-xl transition font-medium">

                        Batal

                    </a>

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl shadow-md shadow-blue-500/20 transition font-medium">

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Downloads\MAGANG VENA\monitoring-laporanpkn1\resources\views/master/karyawan/create.blade.php ENDPATH**/ ?>