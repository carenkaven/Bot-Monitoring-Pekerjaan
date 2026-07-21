<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Monitoring Laporan | PT Reno Abirama Sakti</title>
    <!-- Alpine Plugins & Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        // Set tema
        (function () {
            try {
                const stored = localStorage.getItem('theme');
                const isDark = stored ? stored === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.classList.toggle('dark', isDark);
            } catch (e) {}
        })();
    </script>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css','resources/js/app.js']); ?>
    
    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .dark .glass-panel {
            background: rgba(30, 41, 59, 0.7); /* slate-800 */
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-slate-900 text-slate-800 dark:text-slate-200 font-satoshi antialiased transition-colors duration-500 overflow-x-hidden relative min-h-screen flex items-center justify-center">

    <!-- Ornamen Background Premium (Blobs) -->
    <div class="fixed top-[-10%] left-[-10%] w-96 h-96 bg-blue-400 dark:bg-blue-900 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-[100px] opacity-40 dark:opacity-20 animate-pulse transition-all duration-1000 z-0"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-96 h-96 bg-indigo-400 dark:bg-indigo-900 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-[100px] opacity-40 dark:opacity-20 transition-all duration-1000 z-0" style="animation-delay: 2s;"></div>

    <!-- Toggle Tema (Absolute Position) -->
    <button type="button" onclick="themeToggle()" id="themeBtn" class="absolute top-6 right-6 inline-flex items-center justify-center rounded-xl bg-white/80 dark:bg-slate-800/80 backdrop-blur-md px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-white dark:hover:bg-slate-700 shadow-sm transition z-50 border border-slate-200 dark:border-slate-700">
        <svg id="iconSun" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden fill-current" viewBox="0 0 20 20">
            <path d="M10 14a4 4 0 100-8 4 4 0 000 8z"/>
            <path fill-rule="evenodd" d="M10 1a1 1 0 011 1v1a1 1 0 11-2 0V2a1 1 0 011-1zm0 15a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM3.22 3.22a1 1 0 011.42 0l.7.7a1 1 0 11-1.42 1.42l-.7-.7a1 1 0 010-1.42zm11.46 11.46a1 1 0 011.42 0l.7.7a1 1 0 11-1.42 1.42l-.7-.7a1 1 0 010-1.42zM1 10a1 1 0 011-1h1a1 1 0 110 2H2a1 1 0 01-1-1zm15 0a1 1 0 011-1h1a1 1 0 110 2h-1a1 1 0 01-1-1zM3.22 16.78a1 1 0 010-1.42l.7-.7a1 1 0 111.42 1.42l-.7.7a1 1 0 01-1.42 0zM14.98 5.34a1 1 0 010-1.42l.7-.7a1 1 0 111.42 1.42l-.7.7a1 1 0 01-1.42 0z" clip-rule="evenodd"/>
        </svg>
        <svg id="iconMoon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden fill-current" viewBox="0 0 20 20">
            <path d="M17.293 13.293A8 8 0 016.707 2.707a8 8 0 1010.586 10.586z"/>
        </svg>
        <span id="themeLabel" class="ml-2">Dark</span>
    </button>

    <div class="relative z-10 w-full max-w-4xl p-6 sm:p-10">
        
        <div class="glass-panel rounded-3xl p-10 sm:p-16 text-center shadow-2xl transition-all duration-500 transform hover:scale-[1.01]">
            
            <div class="inline-flex justify-center items-center w-32 h-32 rounded-3xl bg-white shadow-lg border border-slate-100 p-4 mb-8 dark:border-slate-700">
                <img src="<?php echo e(asset('images/logo-ras.png')); ?>" alt="Logo PT Reno Abirama Sakti" class="w-full h-auto object-contain">
            </div>

            <h1 class="text-4xl lg:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-700 to-indigo-600 dark:from-blue-400 dark:to-indigo-300 tracking-tight mb-4">
                Monitoring Laporan Proyek
            </h1>

            <p class="text-xl font-semibold text-slate-600 dark:text-slate-300 mb-8 uppercase tracking-widest text-sm">
                PT Reno Abirama Sakti
            </p>

            <p class="text-base text-slate-500 dark:text-slate-400 max-w-lg mx-auto mb-12 leading-relaxed">
                Sistem Monitoring Laporan Proyek berbasis Website dan WhatsApp Bot. Solusi efisien untuk melacak perkembangan proyek secara langsung dari lapangan.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-5 w-full sm:w-auto">
                <a href="<?php echo e(route('login')); ?>"
                   class="group relative inline-flex justify-center items-center rounded-xl bg-blue-600 overflow-hidden py-3 px-10 font-semibold text-white shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition-all duration-300 hover:scale-105">
                    <span class="relative z-10">Sign In Sistem</span>
                    <div class="absolute inset-0 h-full w-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-all translate-x-[-100%] group-hover:translate-x-[100%] duration-1000"></div>
                </a>

                <a href="<?php echo e(route('register.karyawan')); ?>"
                   class="inline-flex justify-center items-center rounded-xl border-2 border-blue-600 text-blue-600 dark:border-blue-400 dark:text-blue-400 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-400 dark:hover:text-slate-900 py-3 px-10 text-center font-semibold transition-all duration-300 hover:scale-105 shadow-md">
                    Daftar Karyawan
                </a>
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
    try {
        localStorage.setItem('theme', !isDark ? 'dark' : 'light');
    } catch (e) {}
    syncUI();
}

document.addEventListener('DOMContentLoaded', syncUI);
</script>

</body>
</html><?php /**PATH C:\Users\akuna\OneDrive\Dokumen\KULIAH ITN MALANG\SEMESTER 7\PKN 2318105\Bot-Monitoring-Pekerjaan\resources\views/pages/landing.blade.php ENDPATH**/ ?>