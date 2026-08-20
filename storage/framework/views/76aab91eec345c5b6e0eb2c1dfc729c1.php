<!DOCTYPE html>
<html lang="id" x-data x-bind:class="{ 'dark': $store.theme.isDark }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/logo-ras.webp')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('images/logo-ras.webp')); ?>">
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
    <style>
        /* SweetAlert2 Dark Mode Override */
        html.dark .swal2-popup {
            background-color: #24303f !important;
            color: #ffffff !important;
        }
        html.dark .swal2-title {
            color: #ffffff !important;
        }
        html.dark .swal2-html-container {
            color: #94a3b8 !important;
        }
        html.dark .swal2-input,
        html.dark .swal2-file,
        html.dark .swal2-textarea,
        html.dark .swal2-select,
        html.dark .swal2-radio,
        html.dark .swal2-checkbox {
            background-color: #1d2a39 !important;
            color: #ffffff !important;
            border-color: #3d4d60 !important;
        }
        html.dark .swal2-input:focus,
        html.dark .swal2-file:focus,
        html.dark .swal2-textarea:focus,
        html.dark .swal2-select:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 1px #3b82f6 !important;
        }
    </style>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmFormSubmit(event, message, formElement) {
            event.preventDefault();
            Swal.fire({
                title: 'Konfirmasi',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    formElement.submit();
                }
            });
        }

        function pilihFormatLaporan(judul, pdfUrl, excelUrl) {
            Swal.fire({
                title: `<span class="text-lg font-semibold text-gray-900">${judul}</span>`,
                html: `
                    <div class="flex flex-col gap-3 mt-4">
                        <button onclick="Swal.clickConfirm()" class="flex items-center gap-4 w-full p-4 border border-gray-200 hover:border-red-500 hover:bg-red-50 rounded-xl transition-all text-left bg-white group">
                            <div class="text-gray-400 group-hover:text-red-500 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 text-sm group-hover:text-red-600 transition-colors">Unduh PDF</div>
                            </div>
                        </button>
                        <button onclick="Swal.clickDeny()" class="flex items-center gap-4 w-full p-4 border border-gray-200 hover:border-green-500 hover:bg-green-50 rounded-xl transition-all text-left bg-white group">
                            <div class="text-gray-400 group-hover:text-green-500 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 text-sm group-hover:text-green-600 transition-colors">Unduh Excel</div>
                            </div>
                        </button>
                    </div>
                `,
                showConfirmButton: false,
                showDenyButton: false,
                showCancelButton: true,
                cancelButtonText: 'Batal',
                customClass: {
                    cancelButton: 'px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors border-none mt-2 font-medium text-sm',
                    popup: 'rounded-2xl pb-6',
                }
            }).then((result) => {
                if (result.isConfirmed) window.open(pdfUrl, '_blank');
                if (result.isDenied && excelUrl) window.location.href = excelUrl;
                if (result.isDenied && !excelUrl) Swal.fire({ icon: 'info', title: 'Excel belum tersedia', text: 'Format Excel untuk laporan mingguan lama belum dibuat.' });
            });
        }

        function pilihJenisLaporanMingguan(urlLamaPdf, urlLamaExcel, urlBaruPdf, urlBaruExcel) {
            Swal.fire({
                title: '<span class="text-lg font-semibold text-gray-900">Pilih Template Mingguan</span>',
                html: `
                    <div class="flex flex-col gap-3 mt-4">
                        <button onclick="Swal.clickConfirm()" class="flex items-center gap-4 w-full p-4 border border-gray-200 hover:border-gray-900 hover:bg-gray-50 rounded-xl transition-all text-left bg-white group">
                            <div class="text-gray-400 group-hover:text-gray-900 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 text-sm transition-colors">Template Lama</div>
                            </div>
                        </button>
                        <button onclick="Swal.clickDeny()" class="flex items-center gap-4 w-full p-4 border border-gray-200 hover:border-gray-900 hover:bg-gray-50 rounded-xl transition-all text-left bg-white group">
                            <div class="text-gray-400 group-hover:text-gray-900 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path></svg>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 text-sm transition-colors">Template Baru</div>
                            </div>
                        </button>
                    </div>
                `,
                showConfirmButton: false,
                showDenyButton: false,
                showCancelButton: true,
                cancelButtonText: 'Batal',
                customClass: {
                    cancelButton: 'px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors border-none mt-2 font-medium text-sm',
                    popup: 'rounded-2xl pb-6',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    pilihFormatLaporan('Laporan Mingguan Lama', urlLamaPdf, urlLamaExcel);
                } else if (result.isDenied) {
                    pilihFormatLaporan('Laporan Mingguan Baru', urlBaruPdf, urlBaruExcel);
                }
            });
        }

        function pilihJenisLaporanHarian(urlLamaPdf, urlLamaExcel, urlBaruPdf, urlBaruExcel) {
            Swal.fire({
                title: '<span class="text-lg font-semibold text-gray-900">Pilih Template Harian</span>',
                html: `
                    <div class="flex flex-col gap-3 mt-4">
                        <button onclick="Swal.clickConfirm()" class="flex items-center gap-4 w-full p-4 border border-gray-200 hover:border-gray-900 hover:bg-gray-50 rounded-xl transition-all text-left bg-white group">
                            <div class="text-gray-400 group-hover:text-gray-900 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 text-sm transition-colors">Template Lama</div>
                            </div>
                        </button>
                        <button onclick="Swal.clickDeny()" class="flex items-center gap-4 w-full p-4 border border-gray-200 hover:border-gray-900 hover:bg-gray-50 rounded-xl transition-all text-left bg-white group">
                            <div class="text-gray-400 group-hover:text-gray-900 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900 text-sm transition-colors">Template Baru</div>
                            </div>
                        </button>
                    </div>
                `,
                showConfirmButton: false,
                showDenyButton: false,
                showCancelButton: true,
                cancelButtonText: 'Batal',
                customClass: {
                    cancelButton: 'px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors border-none mt-2 font-medium text-sm',
                    popup: 'rounded-2xl pb-6',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    pilihFormatLaporan('Laporan Harian Lama', urlLamaPdf, urlLamaExcel);
                } else if (result.isDenied) {
                    pilihFormatLaporan('Laporan Harian Baru', urlBaruPdf, urlBaruExcel);
                }
            });
        }
    </script>
    <?php if(session('success')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: "<?php echo e(session('success')); ?>",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            });
        </script>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: "<?php echo e(session('error')); ?>",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            });
        </script>
    <?php endif; ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\PROJECT FANY\Bot-Monitoring-Pekerjaan\resources\views/layouts/app.blade.php ENDPATH**/ ?>