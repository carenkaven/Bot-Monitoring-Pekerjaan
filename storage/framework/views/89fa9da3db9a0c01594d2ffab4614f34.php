<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Monitoring Laporan Harian</title>
    <!-- Alpine -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js" defer></script>
    <script>
        (function () {
            try {
                const stored = localStorage.getItem('theme');
                const isDark = stored ? stored === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.classList.toggle('dark', isDark);
            } catch (e) { }
        })();
    </script>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        .glass-auth {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .dark .glass-auth {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>

<body
    class="bg-slate-50 dark:bg-slate-950 text-slate-800 font-satoshi antialiased transition-colors duration-500 overflow-x-hidden relative min-h-screen">

    <!-- Ornamen Background Premium (Blobs) -->
    <div
        class="fixed top-[-10%] left-[-10%] w-96 h-96 bg-blue-300 dark:bg-blue-900 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-[100px] opacity-50 dark:opacity-30 animate-pulse transition-all duration-1000 z-0">
    </div>
    <div class="fixed bottom-[-10%] right-[-10%] w-96 h-96 bg-indigo-300 dark:bg-indigo-900 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-[100px] opacity-50 dark:opacity-30 transition-all duration-1000 z-0"
        style="animation-delay: 2s;"></div>

    <div class="relative z-10 flex flex-col justify-center w-full min-h-screen lg:flex-row">

        <!-- Bagian Kiri (Form Login) -->
        <div class="relative z-10 block w-full lg:w-1/2 h-screen overflow-y-auto custom-scrollbar">
            <div class="flex flex-col items-center justify-center min-h-full p-6 lg:pr-12">

                <!-- Form Container -->
                <div
                    class="glass-auth w-full max-w-md p-8 sm:p-10 rounded-[2rem] shadow-xl relative overflow-hidden transition-all duration-300">

                    <!-- Header Controls -->
                    <div
                        class="flex items-center justify-between mb-8 border-b border-slate-200/50 dark:border-slate-700/50 pb-6">
                        <!-- Tombol Kembali -->
                        <a href="<?php echo e(route('landing')); ?>"
                            class="inline-flex items-center justify-center rounded-xl bg-white/60 dark:bg-slate-800/60 backdrop-blur-md px-3.5 py-2 text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-white dark:hover:bg-slate-700 shadow-sm transition border border-slate-200 dark:border-slate-700 gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Kembali
                        </a>

                        <!-- Toggle Tema -->
                        <button type="button" onclick="themeToggle()" id="themeBtn"
                            class="inline-flex items-center justify-center rounded-xl bg-white/60 dark:bg-slate-800/60 backdrop-blur-md px-3.5 py-2 text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-white dark:hover:bg-slate-700 shadow-sm transition border border-slate-200 dark:border-slate-700 gap-1.5">
                            <svg id="iconSun" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 hidden fill-current"
                                viewBox="0 0 20 20">
                                <path d="M10 14a4 4 0 100-8 4 4 0 000 8z" />
                            </svg>
                            <svg id="iconMoon" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 hidden fill-current"
                                viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8 8 0 1010.586 10.586z" />
                            </svg>
                            <span id="themeLabel">Dark</span>
                        </button>
                    </div>

                    <div class="mb-8 items-center lg:text-left text-center">
                        <h1 class="mb-2 text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                            Sign In Dashboard
                        </h1>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                            Silakan masukkan akses administrator Anda.
                        </p>
                    </div>

                    <?php if(session('status')): ?>
                        <div
                            class="mb-5 bg-green-500/10 text-green-600 p-4 rounded-xl border border-green-500/20 font-medium text-sm">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-6 lg:text-left text-left">
                        <?php echo csrf_field(); ?>
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">Email
                                Address</label>
                            <input type="email" name="email" value="<?php echo e(old('email')); ?>" required
                                placeholder="admin@domain.com"
                                class="w-full rounded-xl border border-slate-200 bg-white/50 backdrop-blur-sm py-3 px-5 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-blue-400 transition-all" />
                        </div>

                        <div x-data="{ show: false }">
                            <label
                                class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">Password</label>
                            <div class="relative">
                                <input :type="show ? 'text' : 'password'" id="password" name="password" required
                                    placeholder="••••••••" autocomplete="current-password"
                                    class="w-full rounded-xl border border-slate-200 bg-white/50 backdrop-blur-sm py-3 px-5 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-blue-400 transition-all" />

                                <button type="button" @click="show = !show"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition">
                                    <!-- SVG Eye icons follow Alpine stat var 'show' -->
                                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0s-3-6-9-6-9 6-9 6 3 6 9 6 9-6 9-6z" />
                                    </svg>
                                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-5 0-9-7-9-7a18.09 18.09 0 013.64-4.95M6.7 6.7A9.96 9.96 0 0112 5c5 0 9 7 9 7a18.12 18.12 0 01-2.19 3.19M15 12a3 3 0 00-4.24-2.76M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <label
                                class="flex items-center gap-2 cursor-pointer text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition">
                                <input type="checkbox" name="remember"
                                    class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:ring-offset-slate-800" />
                                Ingat Saya
                            </label>
                        </div>

                        <div class="pt-2">
                            <button type="submit"
                                class="w-full rounded-xl bg-blue-600 py-3.5 px-4 text-center text-sm font-semibold text-white shadow-lg shadow-blue-600/30 hover:bg-blue-700 hover:shadow-blue-600/50 transition-all hover:scale-[1.02]">
                                Sign In Now ->
                            </button>
                        </div>
                    </form>

                </div>

                <!-- Footer link out of glass -->
                <div class="mt-8 text-center text-sm text-slate-500 dark:text-slate-400">
                    <p>Belum punya akun? <a href="<?php echo e(route('register.karyawan')); ?>"
                            class="font-semibold text-blue-600 dark:text-blue-400 hover:underline transition">Daftar
                            Karyawan</a></p>
                </div>
            </div>
        </div>

        <!-- Bagian Kanan (Info Brand Premium) -->
        <div
            class="relative hidden w-full h-full min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-slate-900 dark:to-slate-800 lg:flex lg:w-1/2 flex-col items-center justify-center text-center p-12 border-l border-slate-200 dark:border-slate-800/50 overflow-hidden">

            <!-- Animated Background Ornaments for Right Panel -->
            <div
                class="absolute inset-0 bg-[url('https://laravel.com/assets/img/welcome/background.svg')] bg-center [mask-image:linear-gradient(to_bottom,white,transparent)] opacity-40 dark:opacity-10">
            </div>
            <div
                class="absolute w-full h-full border-t border-r border-white/40 dark:border-white/5 rounded-[4rem] top-12 left-12">
            </div>

            <div class="max-w-md relative z-10 flex flex-col items-center text-center">

                <div
                    class="relative w-32 h-32 rounded-[2rem] bg-white shadow-xl shadow-blue-500/10 dark:shadow-black/40 border border-slate-100 dark:border-slate-700 p-5 mb-10 group overflow-hidden">
                    <div
                        class="absolute inset-0 bg-blue-50 dark:bg-slate-800 transform translate-y-[100%] group-hover:translate-y-0 transition-transform duration-500 ease-in-out">
                    </div>
                    <img src="<?php echo e(asset('images/logo-ras.png')); ?>" alt="Logo PT Reno Abirama Sakti"
                        class="w-full h-full object-contain relative z-10 transition-transform duration-500 group-hover:scale-110">
                </div>

                <h2 class="text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight mb-4">
                    Sistem Monitoring Laporan Proyek
                </h2>

                <p class="text-lg font-medium text-blue-600 dark:text-blue-400 mb-6 uppercase tracking-wider text-sm">
                    PT Reno Abirama Sakti
                </p>

                <p class="text-slate-600 dark:text-slate-400 leading-relaxed text-lg font-medium">
                    Sempurnakan operasional lapangan dengan ekosistem pelaporan terintegrasi. Dukungan integrasi <strong
                        class="text-slate-800 dark:text-slate-200">WhatsApp Bot</strong> dengan manajemen real-time.
                </p>

            </div>
        </div>

    </div>

    <script>
        function syncUI() {
            const isDark = document.documentElement.classList.contains('dark');
            const iconSun = document.getElementById('iconSun');
            const iconMoon = document.getElementById('iconMoon');
            const themeLabel = document.getElementById('themeLabel');
            if (isDark) {
                iconSun.classList.remove('hidden');
                iconMoon.classList.add('hidden');
                themeLabel.textContent = 'Light Mode';
            } else {
                iconMoon.classList.remove('hidden');
                iconSun.classList.add('hidden');
                themeLabel.textContent = 'Dark Mode';
            }
        }
        function themeToggle() {
            const isDark = document.documentElement.classList.contains('dark');
            document.documentElement.classList.toggle('dark', !isDark);
            try { localStorage.setItem('theme', !isDark ? 'dark' : 'light'); } catch (e) { }
            syncUI();
        }
        document.addEventListener('DOMContentLoaded', syncUI);
    </script>
</body>

</html><?php /**PATH C:\Users\USER\Downloads\MAGANG VENA\monitoring-laporanpkn1\resources\views/auth/login.blade.php ENDPATH**/ ?>