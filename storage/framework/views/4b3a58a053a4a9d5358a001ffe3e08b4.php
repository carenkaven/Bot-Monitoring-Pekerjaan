<header class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 shadow-sm transition-colors duration-300">

    <div class="h-20 px-8 flex items-center justify-end">

        <div class="flex items-center gap-6">

            
            <button
                @click="dark = !dark"
                class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition"
                title="Dark Mode">

                
                <svg
                    x-show="dark"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6 text-yellow-400"
                    fill="currentColor"
                    viewBox="0 0 24 24">

                    <path d="M12 18a6 6 0 100-12 6 6 0 000 12zm0-16a1 1 0 011 1v2a1 1 0 11-2 0V3a1 1 0 011-1zm0 18a1 1 0 011 1v2a1 1 0 11-2 0v-2a1 1 0 011-1zm9-9a1 1 0 010 2h-2a1 1 0 110-2h2zM5 12a1 1 0 010 2H3a1 1 0 110-2h2zm11.95-6.364a1 1 0 011.414 1.414l-1.414 1.414a1 1 0 11-1.414-1.414l1.414-1.414zM7.05 16.95a1 1 0 011.414 1.414L7.05 19.778a1 1 0 11-1.414-1.414l1.414-1.414zm11.314 2.828a1 1 0 01-1.414 0l-1.414-1.414a1 1 0 011.414-1.414l1.414 1.414a1 1 0 010 1.414zM8.464 7.05A1 1 0 017.05 8.464L5.636 7.05A1 1 0 117.05 5.636L8.464 7.05z"/>
                </svg>

                
                <svg
                    x-show="!dark"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6 text-slate-600 dark:text-slate-300"
                    fill="currentColor"
                    viewBox="0 0 24 24">

                    <path d="M21 12.79A9 9 0 1111.21 3c0 .34.02.68.05 1.02A7 7 0 0020 13c.34-.03.68-.05 1-.21z"/>
                </svg>

            </button>

            
            <button class="relative p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-6 h-6 text-slate-600 dark:text-slate-300"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15 17h5l-1.4-1.4A2 2 0 0118 14.17V11a6 6 0 10-12 0v3.17a2 2 0 01-.6 1.43L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>

                </svg>

                <span class="absolute top-1 right-1 w-3 h-3 rounded-full bg-red-500"></span>

            </button>

            
            <div class="flex items-center gap-3">

                <div class="w-11 h-11 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">

                    <?php echo e(strtoupper(substr(Auth::user()->name,0,1))); ?>


                </div>

                <div>

                    <h3 class="font-semibold text-slate-800 dark:text-white">

                        <?php echo e(Auth::user()->name); ?>


                    </h3>

                    <small class="text-slate-500 dark:text-slate-400">

                        <?php echo e(Auth::user()->isAdmin() ? 'Administrator' : 'Karyawan'); ?>


                    </small>

                </div>

            </div>

        </div>

    </div>

</header><?php /**PATH C:\Users\usera\Downloads\monitoring-laporanpkn-refactor\monitoring-laporanpkn1\resources\views/layouts/navbar.blade.php ENDPATH**/ ?>