

<?php $__env->startSection('content'); ?>

<div class="space-y-6">

    
<div class="flex justify-between items-center">

    <div>

        <h1 class="text-3xl font-bold text-slate-800">
            Data Karyawan
        </h1>

        <p class="text-slate-500 dark:text-slate-400 mt-1">
            Kelola seluruh data karyawan PT Reno Abirama Sakti.
        </p>

    </div>

    <a href="<?php echo e(route('karyawan.create')); ?>"
       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl shadow">

        + Tambah Karyawan

    </a>

</div>

    
    <?php if(session('success')): ?>

        <div class="bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-xl">

            <?php echo e(session('success')); ?>


        </div>

    <?php endif; ?>

    
    <div class="bg-white rounded-3xl shadow-lg">

        
        <div class="p-6 border-b flex justify-between items-center">

            <div>

                <h2 class="text-xl font-semibold">
                    Daftar Karyawan
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Total :
                    <b><?php echo e($karyawans->total()); ?></b>
                    Karyawan
                </p>

            </div>

            <input
                type="text"
                id="searchInput"
                placeholder="Cari nama karyawan..."
                class="w-80 rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">

        </div>

        
        <div class="overflow-x-auto">

            <table class="w-full" id="tableKaryawan">

                <thead class="bg-slate-100">

                    <tr>

                        <th class="px-6 py-4 text-left">No</th>

                        <th class="px-6 py-4 text-left">
                            Nama
                        </th>

                        <th class="px-6 py-4 text-left">
                            Jabatan
                        </th>

                        <th class="px-6 py-4 text-left">
                            Email
                        </th>

                        <th class="px-6 py-4 text-left">
                            WhatsApp
                        </th>

                        <th class="px-6 py-4 text-center">
                            Status
                        </th>

                        <th class="px-6 py-4 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $karyawans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

<tr class="border-b hover:bg-slate-50">

    <td class="px-6 py-4">
        <?php echo e($loop->iteration); ?>

    </td>

    <td class="px-6 py-4 font-semibold">
        <?php echo e($item->nama); ?>

    </td>

    <td class="px-6 py-4">
        <?php echo e($item->jabatan); ?>

    </td>

    <td class="px-6 py-4">
        <?php echo e($item->email); ?>

    </td>

    <td class="px-6 py-4">
        <?php echo e($item->no_hp); ?>

    </td>

    <td class="px-6 py-4 text-center">

<?php if($item->status=='aktif'): ?>

<span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">

Aktif

</span>

<?php elseif($item->status=='pending'): ?>

<span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm">

Pending

</span>

<?php elseif($item->status=='ditolak'): ?>

<span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">

Ditolak

</span>

<?php else: ?>

<span class="px-3 py-1 rounded-full bg-slate-200 text-slate-700 text-sm">

Nonaktif

</span>

<?php endif; ?>

</td>

    <td class="px-6 py-4">

        <div class="flex justify-center gap-2">

            <?php if($item->status=='pending'): ?>

                <form action="<?php echo e(route('karyawan.approve',$item->id)); ?>" method="POST">

                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>

                    <button
                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-sm">

                        Verifikasi

                    </button>

                </form>

                <form action="<?php echo e(route('karyawan.reject',$item->id)); ?>" method="POST"
                      onsubmit="return confirm('Tolak pendaftaran karyawan ini?')">

                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>

                    <button
                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm">

                        Tolak

                    </button>

                </form>

            <?php endif; ?>

            <?php if($item->status=='aktif'): ?>

                <form action="<?php echo e(route('karyawan.nonaktif',$item->id)); ?>" method="POST">

                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>

                    <button
                        class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-2 rounded-lg text-sm">

                        Nonaktif

                    </button>

                </form>

            <?php endif; ?>

            <a href="<?php echo e(route('karyawan.edit',$item->id)); ?>"
               class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm">

                Edit

            </a>

            <form action="<?php echo e(route('karyawan.destroy',$item->id)); ?>"
                  method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>

                <button
                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-sm">

                    Hapus

                </button>

            </form>

        </div>

    </td>

</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

<tr>

    <td colspan="7" class="text-center py-10 text-gray-400">

        Belum ada data karyawan.

    </td>

</tr>

<?php endif; ?>
            </table>

        </div>

        <div class="p-6">

            <?php echo e($karyawans->links()); ?>


        </div>

    </div>

</div>

<script>

document.getElementById('searchInput').addEventListener('keyup', function(){

    let filter = this.value.toLowerCase();

    let rows = document.querySelectorAll('#tableKaryawan tbody tr');

    rows.forEach(function(row){

        let text = row.innerText.toLowerCase();

        row.style.display = text.includes(filter) ? '' : 'none';

    });

});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\usera\Downloads\monitoring-laporanpkn-refactor\monitoring-laporanpkn1\resources\views/master/karyawan/index.blade.php ENDPATH**/ ?>