<aside class="w-72 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 text-slate-800 dark:text-white flex flex-col shadow-xl transition-colors duration-300">

    <div class="h-20 flex items-center px-6 border-b border-slate-200 dark:border-slate-800">

        <div class="w-14 h-14 rounded-xl bg-slate-100 dark:bg-white p-1 flex items-center justify-center overflow-hidden">

            <?php if(file_exists(public_path('images/logo-ras.png'))): ?>

                <img src="<?php echo e(asset('images/logo-ras.png')); ?>"
                     class="object-contain w-full h-full">

            <?php else: ?>

                <span class="text-blue-700 font-bold text-lg">
                    RAS
                </span>

            <?php endif; ?>

        </div>

        <div class="ml-4">

            <h1 class="font-bold text-lg text-slate-900 dark:text-white">
                Monitoring
            </h1>

            <p class="text-xs text-slate-500 dark:text-slate-400">
                PT Reno Abirama Sakti
            </p>

        </div>

    </div>

    <div class="flex-1 overflow-y-auto py-6">

        
        <div class="px-6 mb-3 text-xs uppercase tracking-widest text-slate-500 dark:text-slate-400">

            Dashboard

        </div>

        <?php if(Auth::user()->isAdmin()): ?>

        <a href="<?php echo e(route('dashboard')); ?>"
           class="mx-4 flex items-center rounded-xl px-4 py-3 mb-2 transition
           <?php echo e(request()->routeIs('dashboard')
                ? 'bg-blue-600 text-white shadow'
                : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800'); ?>">

            <svg class="w-5 h-5"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M3 12l2-2 7-7 7 7 2 2M5 10v10h14V10"/>

            </svg>

            <span class="ml-3">
                Dashboard
            </span>

        </a>

        
        <div class="px-6 mt-8 mb-3 text-xs uppercase tracking-widest text-slate-500 dark:text-slate-400">

            Master

        </div>

        <a href="<?php echo e(route('karyawan.index')); ?>"
           class="mx-4 flex items-center rounded-xl px-4 py-3 mb-2 transition
           <?php echo e(request()->routeIs('karyawan.*')
                ? 'bg-blue-600 text-white shadow'
                : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800'); ?>">

            <svg class="w-5 h-5"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-3.13a4 4 0 100-8 4 4 0 000 8zm6 0a3 3 0 100-6 3 3 0 000 6zM3 8a3 3 0 106 0 3 3 0 00-6 0z"/>

            </svg>

            <span class="ml-3">
                Data Karyawan
            </span>

        </a>

        
        <div class="px-6 mt-8 mb-3 text-xs uppercase tracking-widest text-slate-500 dark:text-slate-400">

            Monitoring

        </div>
                <a href="<?php echo e(route('laporan.index')); ?>"
           class="mx-4 flex items-center rounded-xl px-4 py-3 mb-2 transition
           <?php echo e(request()->routeIs('laporan.*')
                ? 'bg-blue-600 text-white shadow'
                : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800'); ?>">

            <svg class="w-5 h-5"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>

            </svg>

            <span class="ml-3">
                Laporan Harian
            </span>

        </a>

        <a href="<?php echo e(route('weekly.index')); ?>"
           class="mx-4 flex items-center rounded-xl px-4 py-3 mb-2 transition
           <?php echo e(request()->routeIs('weekly.*')
                ? 'bg-blue-600 text-white shadow'
                : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800'); ?>">

            <svg class="w-5 h-5"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"/>

            </svg>

            <span class="ml-3">
                Laporan Mingguan
            </span>

        </a>

        <a href="<?php echo e(route('verifikasi.index')); ?>"
           class="mx-4 flex items-center rounded-xl px-4 py-3 mb-2 transition
           <?php echo e(request()->routeIs('verifikasi.index') || request()->routeIs('verifikasi.show')
                ? 'bg-blue-600 text-white shadow'
                : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800'); ?>">

            <svg class="w-5 h-5"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 12l2 2 4-4M12 22a10 10 0 100-20 10 10 0 000 20z"/>

            </svg>

            <span class="ml-3">
                Verifikasi
            </span>

        </a>

        <a href="<?php echo e(route('verifikasi.riwayat')); ?>"
           class="mx-4 flex items-center rounded-xl px-4 py-3 mb-2 transition
           <?php echo e(request()->routeIs('verifikasi.riwayat')
                ? 'bg-blue-600 text-white shadow'
                : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800'); ?>">

            <svg class="w-5 h-5"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>

            </svg>

            <span class="ml-3">
                Riwayat Verifikasi
            </span>

        </a>

        <?php else: ?>

        <a href="<?php echo e(route('dashboard.karyawan')); ?>"
           class="mx-4 flex items-center rounded-xl px-4 py-3 mb-2 transition
           <?php echo e(request()->routeIs('dashboard.karyawan')
                ? 'bg-blue-600 text-white shadow'
                : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800'); ?>">

            <svg class="w-5 h-5"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M3 12l2-2 7-7 7 7 2 2M5 10v10h14V10"/>

            </svg>

            <span class="ml-3">
                Dashboard
            </span>

        </a>

        <div class="px-6 mt-8 mb-3 text-xs uppercase tracking-widest text-slate-500 dark:text-slate-400">

            Monitoring

        </div>

        <a href="<?php echo e(route('laporan-saya.index')); ?>"
           class="mx-4 flex items-center rounded-xl px-4 py-3 mb-2 transition
           <?php echo e(request()->routeIs('laporan-saya.*')
                ? 'bg-blue-600 text-white shadow'
                : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800'); ?>">

            <svg class="w-5 h-5"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>

            </svg>

            <span class="ml-3">
                Laporan Saya
            </span>

        </a>

        <?php endif; ?>
                
        <div class="px-6 mt-8 mb-3 text-xs uppercase tracking-widest text-slate-500 dark:text-slate-400">

            Akun

        </div>

        <a href="<?php echo e(route('profile.edit')); ?>"
           class="mx-4 flex items-center rounded-xl px-4 py-3 mb-2 transition
           <?php echo e(request()->routeIs('profile.*')
                ? 'bg-blue-600 text-white shadow'
                : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800'); ?>">

            <svg class="w-5 h-5"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M5.121 17.804A9 9 0 1118.88 6.196 9 9 0 015.12 17.804zM12 11a3 3 0 100-6 3 3 0 000 6z"/>

            </svg>

            <span class="ml-3">

                Profil

            </span>

        </a>

    </div>

    
    <div class="border-t border-slate-200 dark:border-slate-800 p-5 transition-colors duration-300">

        <div class="flex items-center">

            <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-lg font-bold text-white">

                <?php echo e(strtoupper(substr(Auth::user()->name,0,1))); ?>


            </div>

            <div class="ml-3">

                <div class="font-semibold text-slate-900 dark:text-white">

                    <?php echo e(Auth::user()->name); ?>


                </div>

                <div class="text-xs text-slate-500 dark:text-slate-400">

                    <?php echo e(Auth::user()->isAdmin() ? 'Administrator' : 'Karyawan'); ?>


                </div>

            </div>

        </div>

        <form action="<?php echo e(route('logout')); ?>"
              method="POST"
              class="mt-5">

            <?php echo csrf_field(); ?>

            <button
                type="submit"
                class="w-full rounded-xl py-3 font-semibold text-white bg-red-500 hover:bg-red-600 transition shadow">

                Logout

            </button>

        </form>

    </div>

</aside><?php /**PATH C:\Users\usera\Downloads\monitoring-laporanpkn-refactor\monitoring-laporanpkn1\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>