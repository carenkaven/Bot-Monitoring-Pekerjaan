<!DOCTYPE html>
<html lang="id" x-data x-bind:class="{ 'dark': $store.theme.isDark }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <script>
        // Apply dark class to html immediately before render to prevent flicker
        (function () {
            try {
                const stored = localStorage.getItem('theme');
                const isDark = stored ? stored === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (isDark) document.documentElement.classList.add('dark');
            } catch (e) { }
        })();
    </script>

    <title>Monitoring Laporan</title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/tailadmin.css')); ?>">
</head>

<body x-data="{ page: 'ecommerce', 'loaded': true, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="
        Alpine.store('theme', {
            isDark: localStorage.getItem('theme') ? localStorage.getItem('theme') === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches,
            toggle() {
                this.isDark = !this.isDark;
                localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
                document.documentElement.classList.toggle('dark', this.isDark);
            }
        });
    " class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 antialiased h-screen overflow-hidden">
    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
        <!-- ===== Sidebar Start ===== -->
        <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- ===== Sidebar End ===== -->

        <!-- ===== Content Area Start ===== -->
        <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">

            <!-- ===== Header Start ===== -->
            <?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <!-- ===== Header End ===== -->

            <!-- ===== Main Content Start ===== -->
            <main>
                <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

                    <?php if(isset($header)): ?>
                        <div class="mb-6">
                            <?php echo e($header); ?>

                        </div>
                    <?php endif; ?>

                    <?php echo e($slot ?? ''); ?>


                    <?php echo $__env->yieldContent('content'); ?>

                </div>
            </main>
            <!-- ===== Main Content End ===== -->

            <!-- Footer -->
            <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH C:\Users\USER\Downloads\MAGANG VENA\monitoring-laporanpkn1\resources\views/layouts/app.blade.php ENDPATH**/ ?>