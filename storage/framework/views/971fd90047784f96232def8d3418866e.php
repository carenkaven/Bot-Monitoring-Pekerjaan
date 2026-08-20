

<?php $__env->startSection('content'); ?>
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Monitoring Laporan Harian
            </h2>
            <p class="text-sm mt-1 text-slate-500 dark:text-slate-400">Seluruh laporan harian yang dikirim melalui WhatsApp
                Bot.</p>
        </div>

        <a href="<?php echo e(route('laporan.create')); ?>"
            class="inline-flex items-center justify-center gap-2.5 rounded-md bg-blue-600 py-3 px-6 text-center font-medium text-white hover:bg-opacity-90">
            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M10 2.5C10.4142 2.5 10.75 2.83579 10.75 3.25V9.25H16.75C17.1642 9.25 17.5 9.58579 17.5 10C17.5 10.4142 17.1642 10.75 16.75 10.75H10.75V16.75C10.75 17.1642 10.4142 17.5 10 17.5C9.58579 17.5 9.25 17.1642 9.25 16.75V10.75H3.25C2.83579 10.75 2.5 10.4142 2.5 10C2.5 9.58579 2.83579 9.25 3.25 9.25H9.25V3.25C9.25 2.83579 9.58579 2.5 10 2.5Z" />
            </svg>
            Tambah Laporan
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-6 flex w-full border-l-6 border-green-500 bg-green-100 px-7 py-4 shadow-md dark:bg-green-900/30">
            <div class="mr-5 flex h-9 w-full max-w-[36px] items-center justify-center rounded-lg bg-green-500">
                <svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M15.2984 0.826822C15.6881 1.20015 15.6881 1.80554 15.2984 2.17887L5.89736 11.1893C5.50766 11.5626 4.87574 11.5626 4.48604 11.1893L0.865954 7.72004C0.476251 7.3467 0.47625 6.74132 0.865954 6.36798C1.25566 5.99465 1.88758 5.99465 2.27727 6.36798L5.1917 9.16147L13.8871 0.826822C14.2768 0.453488 14.9087 0.453488 15.2984 0.826822Z"
                        fill="white"></path>
                </svg>
            </div>
            <div class="w-full">
                <h5 class="mb-1 text-lg font-bold text-black dark:text-green-400">Sukses!</h5>
                <p class="text-base leading-relaxed text-black dark:text-white"><?php echo e(session('success')); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <div
        class="rounded-xl border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5">
        <div class="max-w-full overflow-x-auto pb-4">
            <table class="w-full table-auto">
                <thead class="bg-gray-50 dark:bg-meta-4 border-b border-stroke dark:border-strokedark">
                    <tr class="text-left text-sm font-semibold text-black dark:text-white">
                        <th class="py-3 px-2 font-medium">Tanggal</th>
                        <th class="py-3 px-2 font-medium">Karyawan</th>
                        <th class="py-3 px-2 font-medium">Proyek</th>
                        <th class="py-3 px-2 font-medium">Lokasi</th>
                        <th class="py-3 px-2 font-medium text-center">Status</th>
                        <th class="py-3 px-2 font-medium text-center">Laporan</th>
                        <th class="py-3 px-2 font-medium text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stroke dark:divide-strokedark">
                    <?php $__empty_1 = true; $__currentLoopData = $laporans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $laporan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-meta-4/50 transition">
                            <td class="py-3 px-2 text-sm text-black dark:text-white whitespace-nowrap">
                                <?php echo e(\Carbon\Carbon::parse($laporan->tanggal)->format('d-m-Y')); ?>

                            </td>
                            <td class="py-3 px-2 text-sm text-gray-800 dark:text-gray-200 whitespace-nowrap">
                                <?php echo e($laporan->karyawan->nama); ?>

                            </td>
                            <td class="py-3 px-2 text-sm text-gray-800 dark:text-gray-200">
                                <?php echo e($laporan->nama_proyek); ?>

                            </td>
                            <td class="py-3 px-2 text-sm text-gray-500 dark:text-gray-400">
                                <?php echo e($laporan->lokasi); ?>

                            </td>
                            <td class="py-3 px-2 text-center text-sm whitespace-nowrap">
                                <?php if($laporan->status == "Menunggu"): ?>
                                    <span
                                        class="inline-flex rounded-full bg-yellow-100 py-1 px-3 text-xs font-semibold text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-500">Menunggu</span>
                                <?php elseif($laporan->status == "Disetujui"): ?>
                                    <span
                                        class="inline-flex rounded-full bg-green-100 py-1 px-3 text-xs font-semibold text-green-800 dark:bg-green-900/30 dark:text-green-400">Disetujui</span>
                                <?php else: ?>
                                    <span
                                        class="inline-flex rounded-full bg-red-100 py-1 px-3 text-xs font-semibold text-red-800 dark:bg-red-900/30 dark:text-red-400">Ditolak</span>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-2 text-center">
                                <div class="flex flex-wrap items-center justify-center gap-1">
                                    <a href="<?php echo e(route('laporan.show', $laporan->id)); ?>"
                                        class="inline-flex items-center justify-center rounded-lg bg-blue-500/10 px-2 py-1.5 text-xs font-semibold text-blue-600 hover:bg-blue-500 hover:text-white transition whitespace-nowrap">Detail</a>
                                    
                                    <button type="button" onclick="pilihJenisLaporanHarian('<?php echo e(route('pdf.harian', $laporan->id)); ?>', '<?php echo e(route('excel.harian', $laporan->id)); ?>', '<?php echo e(route('pdf.harian.baru', $laporan->id)); ?>', '<?php echo e(route('excel.harian.baru', $laporan->id)); ?>')"
                                        class="inline-flex items-center justify-center rounded-lg bg-orange-500/10 px-2 py-1.5 text-xs font-semibold text-orange-600 hover:bg-orange-500 hover:text-white transition whitespace-nowrap">Cetak</button>
                                </div>
                            </td>
                            <td class="py-3 px-1 text-center">
                                <div class="flex flex-col items-center justify-center gap-1">
                                    <form action="<?php echo e(route('laporan.destroy', $laporan->id)); ?>" method="POST" class="m-0 inline"
                                        onsubmit="confirmFormSubmit(event, 'Apakah Anda yakin ingin menghapus laporan ini secara permanen?', this)">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" title="Hapus laporan" aria-label="Hapus laporan"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-gray-500/10 text-gray-600 hover:bg-gray-500 hover:text-white transition">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M10 11v6M14 11v6M6 7l1 13h10l1-13M9 7V4h6v3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </button>
                                    </form>

                                    <!-- Verifikasi -->
                                    <?php if($laporan->status == "Menunggu"): ?>
                                        <div class="flex items-center justify-center gap-1">
                                            <form action="<?php echo e(route('verifikasi.setujui', $laporan->id)); ?>" method="POST" class="m-0 inline"
                                                onsubmit="confirmFormSubmit(event, 'Apakah Anda yakin ingin menyetujui laporan ini?', this)">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <button type="submit" title="Setujui laporan" aria-label="Setujui laporan" class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-green-500/10 text-green-600 hover:bg-green-500 hover:text-white transition">
                                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m5 12 4 4L19 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                </button>
                                            </form>
                                            <form action="<?php echo e(route('verifikasi.tolak', $laporan->id)); ?>" method="POST" class="m-0 inline" onsubmit="submitTolak(event, this)">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <input type="hidden" name="catatan" class="catatan-input">
                                                <button type="submit" title="Tolak laporan" aria-label="Tolak laporan" class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-yellow-500/10 text-yellow-600 hover:bg-yellow-500 hover:text-white transition">
                                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 6l12 12M18 6 6 18" stroke-linecap="round"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center py-10 text-gray-500 dark:text-gray-400">Belum ada laporan yang
                                masuk.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($laporans->hasPages()): ?>
            <div class="mt-4 p-4 border-t border-gray-100 dark:border-gray-800">
                <?php echo e($laporans->links('pagination::tailwind')); ?>

            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        function submitTolak(event, form) {
            event.preventDefault();
            Swal.fire({
                title: 'Tolak Laporan',
                input: 'textarea',
                inputLabel: 'Masukkan alasan penolakan:',
                inputPlaceholder: 'Ketik alasan di sini...',
                showCancelButton: true,
                confirmButtonText: 'Tolak Laporan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                preConfirm: (alasan) => {
                    if (!alasan || alasan.trim() === '') {
                        Swal.showValidationMessage('Alasan penolakan wajib diisi!');
                        return false;
                    }
                    return alasan;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.querySelector('.catatan-input').value = result.value;
                    form.submit();
                }
            });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\PROJECT FANY\Bot-Monitoring-Pekerjaan\resources\views/laporan/index.blade.php ENDPATH**/ ?>