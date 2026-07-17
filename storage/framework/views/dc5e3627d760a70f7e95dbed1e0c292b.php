<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Monitoring Laporan</title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css','resources/js/app.js']); ?>

</head>

<body class="bg-gradient-to-br from-blue-700 to-indigo-800">

<div class="min-h-screen flex items-center justify-center">

    <div class="bg-white rounded-3xl shadow-2xl p-16 text-center w-full max-w-4xl">

        <img src="<?php echo e(asset('images/logo-ras.png')); ?>"
             class="mx-auto w-32 mb-8">

        <h1 class="text-5xl font-bold text-gray-800">

            Monitoring Laporan Proyek

        </h1>

        <p class="mt-4 text-xl text-gray-500">

            PT Reno Abirama Sakti

        </p>

        <p class="mt-8 text-gray-600 leading-8">

            Sistem Monitoring Laporan Proyek
            berbasis Website dan WhatsApp Bot.

        </p>

        <div class="mt-12 flex justify-center gap-6">

            <a href="<?php echo e(route('login')); ?>"
               class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-xl">

                Login

            </a>

            <a href="<?php echo e(route('register.karyawan')); ?>"
               class="bg-green-600 hover:bg-green-700 text-white px-10 py-4 rounded-xl">

                Daftar Karyawan

            </a>

        </div>

    </div>

</div>

</body>

</html><?php /**PATH C:\Users\usera\Downloads\monitoring-laporanpkn-refactor\monitoring-laporanpkn1\resources\views/pages/landing.blade.php ENDPATH**/ ?>