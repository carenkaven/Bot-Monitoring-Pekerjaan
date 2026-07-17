<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Login</title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css','resources/js/app.js']); ?>

</head>

<body class="bg-gradient-to-br from-blue-700 via-blue-600 to-indigo-700">

<div class="min-h-screen flex items-center justify-center p-8">

    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden w-full max-w-5xl grid md:grid-cols-2">

        <!-- KIRI -->
        <div class="bg-blue-700 text-white p-12 flex flex-col justify-center">

            <img src="<?php echo e(asset('images/logo-ras.png')); ?>"
                 class="w-32 bg-white rounded-2xl p-3 mb-8">

            <h1 class="text-4xl font-bold">

                Monitoring Laporan Proyek

            </h1>

            <p class="mt-4 text-blue-100">

                PT Reno Abirama Sakti

            </p>

            <p class="mt-10 leading-8">

                Sistem monitoring laporan proyek berbasis Website
                dan WhatsApp Bot untuk mempermudah pelaporan
                pekerjaan harian secara real-time.

            </p>

        </div>

        <!-- KANAN -->
        <div class="p-12">

            <h2 class="text-3xl font-bold mb-2">

                Login Administrator

            </h2>

            <p class="text-gray-500 mb-8">

                Silakan login untuk melanjutkan.

            </p>

            <?php if(session('status')): ?>

                <div class="mb-5 bg-green-100 text-green-700 p-4 rounded-xl">

                    <?php echo e(session('status')); ?>


                </div>

            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>">

                <?php echo csrf_field(); ?>

                <div class="mb-5">

                    <label class="font-semibold">

                        Email

                    </label>

                    <input
                        type="email"
                        name="email"
                        value="<?php echo e(old('email')); ?>"
                        required
                        class="mt-2 w-full rounded-xl border-gray-300">

<div class="relative mt-1">
    <input
        id="password"
        name="password"
        type="password"
        required
        autocomplete="current-password"
        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 pr-12"
    >

    <button
        type="button"
        onclick="togglePassword()"
        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700"
    >
        <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0s-3-6-9-6-9 6-9 6 3 6 9 6 9-6 9-6z"/>

        </svg>

        <svg id="eyeClose"
            xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 hidden"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M13.875 18.825A10.05 10.05 0 0112 19c-5 0-9-7-9-7a18.09 18.09 0 013.64-4.95M6.7 6.7A9.96 9.96 0 0112 5c5 0 9 7 9 7a18.12 18.12 0 01-2.19 3.19M15 12a3 3 0 00-4.24-2.76M3 3l18 18"/>

        </svg>
    </button>
</div>

                <div class="flex justify-between items-center mb-8">

                    <label class="flex items-center">

                        <input type="checkbox"
                               name="remember"
                               class="mr-2">

                        Ingat Saya

                    </label>

                    <a href="<?php echo e(route('password.request')); ?>"
                       class="text-blue-600">

                        Lupa Password?

                    </a>

                </div>

                <button
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl font-semibold">

                    LOGIN

                </button>

            </form>

            <div class="text-center mt-8">

                Belum punya akun?

                <a href="<?php echo e(route('register.karyawan')); ?>"
                   class="text-blue-600 font-bold">

                    Daftar Karyawan

                </a>

            </div>

        </div>

    </div>

</div>
<script>
function togglePassword() {

    const password = document.getElementById('password');

    const eyeOpen = document.getElementById('eyeOpen');

    const eyeClose = document.getElementById('eyeClose');

    if (password.type === 'password') {

        password.type = 'text';

        eyeOpen.classList.add('hidden');

        eyeClose.classList.remove('hidden');

    } else {

        password.type = 'password';

        eyeOpen.classList.remove('hidden');

        eyeClose.classList.add('hidden');

    }
}
</script>

</body>

</html><?php /**PATH C:\Users\usera\Downloads\monitoring-laporanpkn-refactor\monitoring-laporanpkn1\resources\views/auth/login.blade.php ENDPATH**/ ?>