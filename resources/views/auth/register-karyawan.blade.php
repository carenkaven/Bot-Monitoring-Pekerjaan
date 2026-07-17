<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Karyawan | Monitoring Laporan</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        (function () {
            try {
                const stored = localStorage.getItem('theme');
                const isDark = stored ? stored === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.classList.toggle('dark', isDark);
            } catch (e) { }
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

        /* Custom scrollbar for form area */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 10px;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
        }
    </style>
</head>

<body
    class="bg-slate-50 dark:bg-slate-950 text-slate-800 font-satoshi antialiased transition-colors duration-500 overflow-hidden relative min-h-screen flex">

    <!-- Ornamen Background Premium (Blobs) -->
    <div
        class="fixed top-[-10%] left-[-10%] w-96 h-96 bg-blue-300 dark:bg-blue-900 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-[100px] opacity-50 dark:opacity-30 animate-pulse transition-all duration-1000 z-0">
    </div>
    <div class="fixed bottom-[-10%] right-[-10%] w-96 h-96 bg-indigo-300 dark:bg-indigo-900 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-[100px] opacity-50 dark:opacity-30 transition-all duration-1000 z-0"
        style="animation-delay: 2s;"></div>

    <div
        class="relative z-10 hidden w-full h-screen bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-slate-900 dark:to-slate-800 lg:flex lg:w-1/2 flex-col items-center justify-center text-center p-12 border-r border-slate-200 dark:border-slate-800/50 overflow-hidden">

        <!-- Animated Background Ornaments for Left Panel -->
        <div
            class="absolute inset-0 bg-[url('https://laravel.com/assets/img/welcome/background.svg')] bg-center [mask-image:linear-gradient(to_bottom,white,transparent)] opacity-40 dark:opacity-10">
        </div>

        <div class="max-w-md relative z-10 flex flex-col items-center text-center">
            <div
                class="relative w-28 h-28 rounded-[2rem] bg-white shadow-xl shadow-blue-500/10 dark:shadow-black/40 border border-slate-100 dark:border-slate-700 p-4 mb-8 group overflow-hidden">
                <div
                    class="absolute inset-0 bg-blue-50 dark:bg-slate-800 transform translate-y-[100%] group-hover:translate-y-0 transition-transform duration-500 ease-in-out">
                </div>
                <img src="{{ asset('images/logo-ras.png') }}" alt="Logo PT Reno Abirama Sakti"
                    class="w-full h-full object-contain relative z-10 transition-transform duration-500 group-hover:scale-110">
            </div>

            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight mb-3">
                Monitoring Laporan Proyek
            </h2>

            <p class="text-sm font-semibold text-blue-600 dark:text-blue-400 mb-6 uppercase tracking-wider">
                PT Reno Abirama Sakti
            </p>

            <p class="text-slate-600 dark:text-slate-400 leading-relaxed text-base font-medium mb-10">
                Sistem monitoring laporan proyek untuk mempermudah operasional. Terintegrasi dengan WhatsApp Bot untuk
                kemudahan pelaporan di lapangan.
            </p>

            <div class="w-full space-y-4 text-left">
                <div
                    class="flex items-center gap-4 bg-white/60 dark:bg-slate-800/60 p-4 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 backdrop-blur-sm shadow-sm transition-transform hover:-translate-y-1 duration-300">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 font-bold shadow-sm">
                        1</div>
                    <span class="text-slate-700 dark:text-slate-300 text-sm font-semibold">Daftar menggunakan data
                        asli</span>
                </div>

                <div class="flex items-center gap-4 bg-white/60 dark:bg-slate-800/60 p-4 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 backdrop-blur-sm shadow-sm transition-transform hover:-translate-y-1 duration-300"
                    style="transition-delay: 100ms;">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 font-bold shadow-sm">
                        2</div>
                    <span class="text-slate-700 dark:text-slate-300 text-sm font-semibold">Tunggu Akun di-verifikasi
                        Admin</span>
                </div>

                <div class="flex items-center gap-4 bg-white/60 dark:bg-slate-800/60 p-4 rounded-2xl border border-slate-200/50 dark:border-slate-700/50 backdrop-blur-sm shadow-sm transition-transform hover:-translate-y-1 duration-300"
                    style="transition-delay: 200ms;">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 font-bold shadow-sm">
                        3</div>
                    <span class="text-slate-700 dark:text-slate-300 text-sm font-semibold">Gunakan fitur Bot &
                        Dashboard</span>
                </div>
            </div>

        </div>
    </div>

    <div class="relative z-10 block w-full lg:w-1/2 h-screen overflow-y-auto custom-scrollbar">
        <div class="flex flex-col items-center justify-center min-h-full p-6 lg:p-12">
            <!-- Form Container -->
            <div
                class="glass-auth w-full max-w-lg p-8 sm:p-10 rounded-[2rem] shadow-xl relative overflow-hidden transition-all duration-300">

                <!-- Header Controls -->
                <div
                    class="flex items-center justify-between mb-8 border-b border-slate-200/50 dark:border-slate-700/50 pb-6">
                    <!-- Tombol Kembali -->
                    <a href="{{ route('landing') }}"
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

                <div class="mb-8 text-center lg:text-left">
                    <h1 class="mb-2 text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                        Daftar Karyawan
                    </h1>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                        Buat akun pelapor baru Anda di sini.
                    </p>
                </div>

                @if($errors->any())
                    <div class="mb-6 rounded-xl border border-red-500/20 bg-red-500/10 p-4">
                        <ul class="list-disc pl-4 text-sm font-medium text-red-600 dark:text-red-400">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-6 rounded-xl border border-green-500/20 bg-green-500/10 p-4">
                        <p class="text-sm font-medium text-green-600 dark:text-green-400">{{ session('success') }}</p>
                    </div>
                @endif

                <form action="{{ route('register.karyawan.store') }}" method="POST" class="space-y-5 text-left">
                    @csrf

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">Nama
                            Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required
                            placeholder="Contoh: Budi Santoso"
                            class="w-full rounded-xl border border-slate-200 bg-white/50 backdrop-blur-sm py-3 px-5 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-blue-400 transition-all" />
                    </div>

                    <div>
                        <label
                            class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">Jabatan</label>
                        <select name="jabatan" required
                            class="w-full rounded-xl border border-slate-200 bg-white/50 backdrop-blur-sm py-3 px-5 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-blue-400 transition-all">
                            <option value="" disabled selected class="text-gray-500 min-h-8">-- Pilih Jabatan --
                            </option>
                            <option value="Mandor" {{ old('jabatan') == 'Mandor' ? 'selected' : '' }}>Mandor</option>
                            <option value="Supervisor" {{ old('jabatan') == 'Supervisor' ? 'selected' : '' }}>Supervisor
                            </option>
                            <option value="Site Engineer" {{ old('jabatan') == 'Site Engineer' ? 'selected' : '' }}>Site
                                Engineer</option>
                            <option value="Quality Control" {{ old('jabatan') == 'Quality Control' ? 'selected' : '' }}>
                                Quality Control</option>
                            <option value="Safety Officer" {{ old('jabatan') == 'Safety Officer' ? 'selected' : '' }}>
                                Safety Officer</option>
                            <option value="Staff" {{ old('jabatan') == 'Staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-5">
                        <div class="w-full sm:w-1/2">
                            <label class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">No
                                WhatsApp</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxx" required
                                class="w-full rounded-xl border border-slate-200 bg-white/50 backdrop-blur-sm py-3 px-5 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-blue-400 transition-all" />
                        </div>

                        <div class="w-full sm:w-1/2">
                            <label
                                class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                placeholder="budi@domain.com"
                                class="w-full rounded-xl border border-slate-200 bg-white/50 backdrop-blur-sm py-3 px-5 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-blue-400 transition-all" />
                        </div>
                    </div>

                    <div x-data="{ showP: false, showC: false }" class="flex flex-col sm:flex-row gap-5">
                        <div class="w-full sm:w-1/2">
                            <label
                                class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">Password</label>
                            <div class="relative">
                                <input :type="showP ? 'text' : 'password'" name="password" required
                                    placeholder="Min. 8 Karakter"
                                    class="w-full rounded-xl border border-slate-200 bg-white/50 backdrop-blur-sm py-3 pl-5 pr-10 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-blue-400 transition-all" />
                                <button type="button" @click="showP = !showP"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition">
                                    <svg x-show="!showP" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0s-3-6-9-6-9 6-9 6 3 6 9 6 9-6 9-6z" />
                                    </svg>
                                    <svg x-show="showP" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 hidden"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-5 0-9-7-9-7a18.09 18.09 0 013.64-4.95M6.7 6.7A9.96 9.96 0 0112 5c5 0 9 7 9 7a18.12 18.12 0 01-2.19 3.19M15 12a3 3 0 00-4.24-2.76M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="w-full sm:w-1/2">
                            <label
                                class="mb-2 block text-sm font-semibold text-slate-700 dark:text-slate-200">Konfirmasi</label>
                            <div class="relative">
                                <input :type="showC ? 'text' : 'password'" name="password_confirmation" required
                                    placeholder="Ulangi Password"
                                    class="w-full rounded-xl border border-slate-200 bg-white/50 backdrop-blur-sm py-3 pl-5 pr-10 text-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 dark:border-slate-700 dark:bg-slate-800/50 dark:text-white dark:focus:border-blue-400 transition-all" />
                                <button type="button" @click="showC = !showC"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition">
                                    <svg x-show="!showC" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0s-3-6-9-6-9 6-9 6 3 6 9 6 9-6 9-6z" />
                                    </svg>
                                    <svg x-show="showC" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 hidden"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-5 0-9-7-9-7a18.09 18.09 0 013.64-4.95M6.7 6.7A9.96 9.96 0 0112 5c5 0 9 7 9 7a18.12 18.12 0 01-2.19 3.19M15 12a3 3 0 00-4.24-2.76M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full rounded-xl bg-blue-600 py-3.5 px-4 text-center text-sm font-semibold text-white shadow-lg shadow-blue-600/30 hover:bg-blue-700 hover:shadow-blue-600/50 transition-all hover:scale-[1.02]">
                            Kirim Pendaftaran ->
                        </button>
                    </div>
                </form>

            </div>

            <!-- Footer link out of glass -->
            <div class="mt-8 text-center text-sm text-slate-500 dark:text-slate-400">
                <p>Sudah mempunyai akun? <a href="{{ route('login') }}"
                        class="font-semibold text-blue-600 dark:text-blue-400 hover:underline transition">Silakan
                        Login</a></p>
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

</html>