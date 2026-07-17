<!DOCTYPE html>
<html
    lang="id"
    x-data="{
        dark: localStorage.getItem('theme')
            ? localStorage.getItem('theme') === 'dark'
            : window.matchMedia('(prefers-color-scheme: dark)').matches
    }"
    x-init="
        document.documentElement.classList.toggle('dark', dark);

        $watch('dark', value => {
            document.documentElement.classList.toggle('dark', value);
            localStorage.setItem('theme', value ? 'dark' : 'light');
        });
    "
>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Monitoring Laporan</title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css','resources/js/app.js']); ?>
</head>

<body class="bg-slate-100 dark:bg-slate-900 text-slate-900 dark:text-white transition-colors duration-300">

<div class="flex h-screen overflow-hidden">

    
    <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <div class="flex flex-col flex-1 overflow-hidden">

        
        <?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        
        <main class="flex-1 overflow-y-auto p-8 bg-slate-100 dark:bg-slate-900 transition-colors duration-300">

            <?php echo $__env->yieldContent('content'); ?>

        </main>

        
        <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php echo $__env->yieldPushContent('scripts'); ?>

</body>

</html><?php /**PATH C:\Users\usera\Downloads\monitoring-laporanpkn-refactor\monitoring-laporanpkn1\resources\views/layouts/app.blade.php ENDPATH**/ ?>