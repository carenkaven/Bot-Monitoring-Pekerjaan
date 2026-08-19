<!DOCTYPE html>
<html lang="id" x-data x-bind:class="{ 'dark': $store.theme.isDark }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/logo-ras.png')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('images/logo-ras.png')); ?>">
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
                title: judul,
                text: 'Pilih format laporan yang ingin diunduh:',
                icon: 'question',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: 'PDF',
                denyButtonText: 'Excel',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc2626',
                denyButtonColor: '#16a34a'
            }).then((result) => {
                if (result.isConfirmed) window.open(pdfUrl, '_blank');
                if (result.isDenied && excelUrl) window.location.href = excelUrl;
                if (result.isDenied && !excelUrl) Swal.fire({ icon: 'info', title: 'Excel belum tersedia', text: 'Format Excel untuk laporan mingguan lama belum dibuat.' });
            });
        }

        function pilihJenisLaporanMingguan(urlLamaPdf, urlLamaExcel, urlBaruPdf, urlBaruExcel) {
            // [DISEMBUNYIKAN SEMENTARA - ATAS PERMINTAAN USER: JANGAN DIHAPUS]
            /*
            Swal.fire({
                title: 'Jenis Laporan Mingguan',
                text: 'Pilih format template yang ingin digunakan:',
                icon: 'question',
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: 'Template Lama (S-Curve)',
                denyButtonText: 'Template Baru (Fisik)',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc2626',
                denyButtonColor: '#ea580c'
            }).then((result) => {
                if (result.isConfirmed) {
                    pilihFormatLaporan('Laporan Mingguan Lama', urlLamaPdf, urlLamaExcel);
                } else if (result.isDenied) {
                    pilihFormatLaporan('Laporan Mingguan Baru', urlBaruPdf, urlBaruExcel);
                }
            });
            */
            // LANGSUNG ARAHKAN KE LAPORAN BARU
            pilihFormatLaporan('Laporan Mingguan', urlBaruPdf, urlBaruExcel);
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