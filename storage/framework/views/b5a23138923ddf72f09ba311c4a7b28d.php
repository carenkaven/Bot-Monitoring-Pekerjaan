<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Karyawan | Monitoring Laporan</title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css','resources/js/app.js']); ?>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700">

<div class="min-h-screen flex items-center justify-center p-6">

    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden w-full max-w-6xl grid lg:grid-cols-2">

        
        <div class="bg-blue-700 text-white p-12 flex flex-col justify-center">

            <img src="<?php echo e(asset('images/logo-ras.png')); ?>"
                 class="w-32 bg-white rounded-2xl p-3 mb-8">

            <h1 class="text-4xl font-bold leading-tight">

                Monitoring Laporan Proyek

            </h1>

            <p class="mt-3 text-xl text-blue-100">

                PT Reno Abirama Sakti

            </p>

            <p class="mt-8 leading-8 text-blue-100">

                Selamat datang di Sistem Monitoring Laporan Proyek.

                Silakan melakukan registrasi terlebih dahulu agar akun
                Anda dapat diverifikasi oleh Administrator dan digunakan
                untuk mengirim laporan melalui WhatsApp Bot.

            </p>

            <div class="mt-10 space-y-4">

                <div class="flex items-center gap-3">

                    <span class="text-2xl">✅</span>

                    <span>
                        Akun diverifikasi oleh Admin
                    </span>

                </div>

                <div class="flex items-center gap-3">

                    <span class="text-2xl">🤖</span>

                    <span>
                        Terhubung dengan WhatsApp Bot
                    </span>

                </div>

                <div class="flex items-center gap-3">

                    <span class="text-2xl">📊</span>

                    <span>
                        Laporan masuk otomatis ke Dashboard
                    </span>

                </div>

            </div>

        </div>

        
        <div class="p-12">

            <h2 class="text-3xl font-bold text-gray-800">

                Daftar Karyawan

            </h2>

            <p class="text-gray-500 mt-2 mb-8">

                Lengkapi data berikut untuk membuat akun.

            </p>

            
            <?php if($errors->any()): ?>

                <div class="mb-6 bg-red-100 border border-red-300 text-red-700 rounded-xl p-4">

                    <ul class="list-disc ml-5">

                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <li><?php echo e($error); ?></li>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </ul>

                </div>

            <?php endif; ?>

            
            <?php if(session('success')): ?>

                <div class="mb-6 bg-green-100 border border-green-300 text-green-700 rounded-xl p-4">

                    <?php echo e(session('success')); ?>


                </div>

            <?php endif; ?>

            <form action="<?php echo e(route('register.karyawan.store')); ?>" method="POST">

                <?php echo csrf_field(); ?>

                
                <div class="mb-5">

                    <label class="font-semibold">

                        Nama Lengkap

                    </label>

                    <input
                        type="text"
                        name="nama"
                        value="<?php echo e(old('nama')); ?>"
                        required
                        class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                </div>

                
                <div class="mb-5">

                    <label class="font-semibold">

                        Jabatan

                    </label>

                    <select
                        name="jabatan"
                        required
                        class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                        <option value="">-- Pilih Jabatan --</option>

                        <option value="Mandor" <?php echo e(old('jabatan')=='Mandor' ? 'selected' : ''); ?>>Mandor</option>

                        <option value="Supervisor" <?php echo e(old('jabatan')=='Supervisor' ? 'selected' : ''); ?>>Supervisor</option>

                        <option value="Site Engineer" <?php echo e(old('jabatan')=='Site Engineer' ? 'selected' : ''); ?>>Site Engineer</option>

                        <option value="Quality Control" <?php echo e(old('jabatan')=='Quality Control' ? 'selected' : ''); ?>>Quality Control</option>

                        <option value="Safety Officer" <?php echo e(old('jabatan')=='Safety Officer' ? 'selected' : ''); ?>>Safety Officer</option>

                        <option value="Staff" <?php echo e(old('jabatan')=='Staff' ? 'selected' : ''); ?>>Staff</option>

                    </select>

                </div>

                
                <div class="mb-5">

                    <label class="font-semibold">

                        Nomor WhatsApp

                    </label>

                    <input
                        type="text"
                        name="no_hp"
                        value="<?php echo e(old('no_hp')); ?>"
                        placeholder="08xxxxxxxxxx"
                        required
                        class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                </div>

                
                <div class="mb-5">

                    <label class="font-semibold">

                        Email

                    </label>

                    <input
                        type="email"
                        name="email"
                        value="<?php echo e(old('email')); ?>"
                        required
                        class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                </div>

                
                <div class="mb-5">

                    <label class="font-semibold">

                        Password

                    </label>

                    <input
                        type="password"
                        name="password"
                        required
                        class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                </div>

                
                <div class="mb-8">

                    <label class="font-semibold">

                        Konfirmasi Password

                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        required
                        class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                </div>

                
                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 transition text-white py-4 rounded-xl font-semibold shadow-lg">

                    DAFTAR SEKARANG

                </button>

                <div class="text-center mt-8 text-gray-600">

                    Sudah mempunyai akun?

                    <a href="<?php echo e(route('login')); ?>"
                       class="text-blue-600 font-bold hover:underline">

                        Login

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

</body>

</html><?php /**PATH C:\Users\usera\Downloads\monitoring-laporanpkn-refactor\monitoring-laporanpkn1\resources\views/auth/register-karyawan.blade.php ENDPATH**/ ?>