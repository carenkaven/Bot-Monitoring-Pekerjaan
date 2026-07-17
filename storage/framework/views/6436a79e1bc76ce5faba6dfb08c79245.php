

<?php $__env->startSection('content'); ?>

<h1 class="text-3xl font-bold mb-6">

Riwayat Verifikasi

</h1>

<div class="bg-white rounded-2xl shadow overflow-hidden">

<table class="w-full">

<thead class="bg-slate-100">

<tr>

<th class="p-4">Tanggal</th>

<th>Karyawan</th>

<th>Proyek</th>

<th>Status</th>

<th>Aksi</th>

</tr>

</thead>

<tbody>

<?php $__empty_1 = true; $__currentLoopData = $laporans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $laporan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

<tr class="border-b">

<td class="p-4">

<?php echo e($laporan->tanggal); ?>


</td>

<td>

<?php echo e($laporan->karyawan->nama); ?>


</td>

<td>

<?php echo e($laporan->nama_proyek); ?>


</td>

<td>

<?php if($laporan->status=="Disetujui"): ?>

<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

Disetujui

</span>

<?php else: ?>

<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">

Ditolak

</span>

<?php endif; ?>

</td>

<td>

<a href="<?php echo e(route('verifikasi.show',$laporan->id)); ?>"
class="bg-blue-600 text-white px-4 py-2 rounded-lg">

Detail

</a>

</td>

</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

<tr>

<td colspan="5" class="text-center py-8">

Belum ada riwayat.

</td>

</tr>

<?php endif; ?>

</tbody>

</table>

</div>

<div class="mt-5">

<?php echo e($laporans->links()); ?>


</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\usera\Downloads\monitoring-laporanpkn-refactor\monitoring-laporanpkn1\resources\views/verifikasi/riwayat.blade.php ENDPATH**/ ?>