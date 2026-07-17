

<?php $__env->startSection('content'); ?>

<div class="flex justify-between items-center mb-6">

    <div>

        <h1 class="text-3xl font-bold text-slate-800">
            Detail Verifikasi Laporan
        </h1>

        <p class="text-slate-500">
            Detail laporan pekerjaan harian.
        </p>

    </div>

    <a href="<?php echo e(route('verifikasi.index')); ?>"
        class="bg-slate-600 hover:bg-slate-700 text-white px-5 py-3 rounded-xl">

        Kembali

    </a>

</div>

<div class="grid grid-cols-2 gap-6">

    <div class="bg-white rounded-2xl shadow p-6">

        <h2 class="font-bold text-xl mb-5">
            Data Laporan
        </h2>

        <table class="w-full">

            <tr>
                <td class="py-2 font-semibold">Tanggal</td>
                <td><?php echo e($laporan->tanggal); ?></td>
            </tr>

            <tr>
                <td class="py-2 font-semibold">Status</td>
                <td><?php echo e($laporan->status); ?></td>
            </tr>

            <tr>
                <td class="py-2 font-semibold">Catatan</td>
                <td><?php echo e($laporan->catatan); ?></td>
            </tr>

        </table>

    </div>

    <div class="bg-white rounded-2xl shadow p-6">

        <h2 class="font-bold text-xl mb-5">
            Data Karyawan
        </h2>

        <table class="w-full">

            <tr>
                <td class="py-2 font-semibold">Nama</td>
                <td><?php echo e($laporan->karyawan->nama); ?></td>
            </tr>

            <tr>
                <td class="py-2 font-semibold">Jabatan</td>
                <td><?php echo e($laporan->karyawan->jabatan); ?></td>
            </tr>

            <tr>
                <td class="py-2 font-semibold">WhatsApp</td>
                <td><?php echo e($laporan->karyawan->no_hp); ?></td>
            </tr>

        </table>

    </div>

</div>

<div class="bg-white rounded-2xl shadow p-6 mt-6">

    <h2 class="font-bold text-xl mb-5">
        Informasi Proyek
    </h2>

    <table class="w-full">

        <tr>
            <td class="py-2 font-semibold w-60">Nama Proyek</td>
            <td><?php echo e($laporan->nama_proyek); ?></td>
        </tr>

        <tr>
            <td class="py-2 font-semibold">Kegiatan</td>
            <td><?php echo e($laporan->kegiatan); ?></td>
        </tr>

        <tr>
            <td class="py-2 font-semibold">Sub Kegiatan</td>
            <td><?php echo e($laporan->sub_kegiatan); ?></td>
        </tr>

        <tr>
            <td class="py-2 font-semibold">Pekerjaan</td>
            <td><?php echo e($laporan->pekerjaan); ?></td>
        </tr>

        <tr>
            <td class="py-2 font-semibold">Lokasi</td>
            <td><?php echo e($laporan->lokasi); ?></td>
        </tr>

        <tr>
            <td class="py-2 font-semibold">Kontraktor</td>
            <td><?php echo e($laporan->kontraktor); ?></td>
        </tr>

        <tr>
            <td class="py-2 font-semibold">Konsultan</td>
            <td><?php echo e($laporan->konsultan); ?></td>
        </tr>

        <tr>
            <td class="py-2 font-semibold">PIC</td>
            <td><?php echo e($laporan->pic); ?></td>
        </tr>

        <tr>
            <td class="py-2 font-semibold">Minggu Ke</td>
            <td><?php echo e($laporan->minggu_ke); ?></td>
        </tr>

    </table>

</div>

<div class="bg-white rounded-2xl shadow p-6 mt-6">

    <h2 class="font-bold text-xl mb-5">

        Pekerjaan

    </h2>

    <ul class="list-disc ml-8">

        <?php $__empty_1 = true; $__currentLoopData = $laporan->pekerjaans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

            <li><?php echo e($item->nama_pekerjaan); ?></li>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

            <li>Tidak ada data pekerjaan.</li>

        <?php endif; ?>

    </ul>

</div>

<div class="bg-white rounded-2xl shadow p-6 mt-6">

    <h2 class="font-bold text-xl mb-5">

        Tenaga Kerja

    </h2>

    <?php $__empty_1 = true; $__currentLoopData = $laporan->tenagas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

        <table class="w-full mb-5">

            <tr>

                <td class="py-2">Pekerja</td>

                <td><?php echo e($t->pekerja); ?></td>

            </tr>

            <tr>

                <td class="py-2">Tukang</td>

                <td><?php echo e($t->tukang); ?></td>

            </tr>

            <tr>

                <td class="py-2">Mandor</td>

                <td><?php echo e($t->mandor); ?></td>

            </tr>

            <tr>

                <td class="py-2">Pelaksana</td>

                <td><?php echo e($t->pelaksana); ?></td>

            </tr>

        </table>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

        Tidak ada data tenaga.

    <?php endif; ?>

</div>

<div class="bg-white rounded-2xl shadow p-6 mt-6">

    <h2 class="font-bold text-xl mb-5">

        Material

    </h2>

    <table class="w-full">

        <thead>

            <tr>

                <th class="text-left">Material</th>

                <th>Volume</th>

                <th>Satuan</th>

            </tr>

        </thead>

        <tbody>

        <?php $__empty_1 = true; $__currentLoopData = $laporan->materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

            <tr>

                <td><?php echo e($m->nama_material); ?></td>

                <td><?php echo e($m->volume); ?></td>

                <td><?php echo e($m->satuan); ?></td>

            </tr>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

            <tr>

                <td colspan="3">

                    Tidak ada material.

                </td>

            </tr>

        <?php endif; ?>

        </tbody>

    </table>

</div>

<div class="bg-white rounded-2xl shadow p-6 mt-6">

    <h2 class="font-bold text-xl mb-5">

        Alat

    </h2>

    <table class="w-full">

        <thead>

            <tr>

                <th class="text-left">Nama Alat</th>

                <th>Jumlah</th>

            </tr>

        </thead>

        <tbody>

        <?php $__empty_1 = true; $__currentLoopData = $laporan->alats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

            <tr>

                <td><?php echo e($alat->nama_alat); ?></td>

                <td><?php echo e($alat->jumlah); ?></td>

            </tr>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

            <tr>

                <td colspan="2">

                    Tidak ada alat.

                </td>

            </tr>

        <?php endif; ?>

        </tbody>

    </table>

</div>

<div class="bg-white rounded-2xl shadow p-6 mt-6">

    <h2 class="font-bold text-xl mb-5">

        Dokumentasi

    </h2>

    <div class="grid grid-cols-4 gap-4">

        <?php $__empty_1 = true; $__currentLoopData = $laporan->fotos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

            <img src="<?php echo e(asset('storage/'.$foto->foto)); ?>"
                class="rounded-xl shadow">

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

            Tidak ada foto.

        <?php endif; ?>

    </div>

</div>

<div class="flex justify-end gap-4 mt-8">

    <form action="<?php echo e(route('verifikasi.tolak',$laporan->id)); ?>"
        method="POST">

        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>

        <input type="text"
            name="catatan"
            placeholder="Alasan penolakan"
            required
            class="border rounded-xl px-4 py-3 mr-3">

        <button
            class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl">

            Tolak

        </button>

    </form>

    <form action="<?php echo e(route('verifikasi.setujui',$laporan->id)); ?>"
        method="POST">

        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>

        <button
            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl">

            Setujui

        </button>

    </form>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\usera\Downloads\monitoring-laporanpkn-refactor\monitoring-laporanpkn1\resources\views/verifikasi/show.blade.php ENDPATH**/ ?>