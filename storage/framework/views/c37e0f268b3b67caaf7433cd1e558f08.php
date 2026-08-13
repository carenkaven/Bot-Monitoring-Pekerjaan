<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <style>
        @page { size: A4 portrait; margin: 9px; }
        body { font-family: Arial, sans-serif; font-size: 6px; color: #000; }
        table { width: 100%; border-collapse: collapse; }
        .border td, .border th, .grid td, .grid th { border: 1px solid #000; }
        .grid td, .grid th { padding: 1px 2px; height: 8px; line-height: 8px; }
        .header { background: #d9d9d9; text-align: center; font-weight: bold; }
        .center { text-align: center; vertical-align: middle; }
        .top { vertical-align: top; }
        .photo { width: 31%; height: 48px; object-fit: contain; margin: 1%; }
        .sign td { text-align: center; vertical-align: bottom; height: 38px; }
    </style>
</head>
<body>
    <table class="border">
        <tr><td class="header" style="height: 14px; font-size: 10px;">LAPORAN HARIAN</td></tr>
        <tr><td style="padding: 3px; height: 43px;">
            <b>Pekerjaan</b> : <?php echo e($laporan->pekerjaan); ?><br>
            <b>Lokasi</b> : <?php echo e($laporan->lokasi); ?><br>
            <b>Tahun Anggaran</b> : <?php echo e(optional($laporan->tanggal)->format('Y')); ?><br>
            <b>Minggu Ke</b> : <?php echo e($laporan->minggu_ke); ?><br>
            <b>Periode</b> : <?php echo e(optional($laporan->tanggal)->format('d F Y')); ?><br>
            <b>Tanggal</b> : <?php echo e(optional($laporan->tanggal)->format('d F Y')); ?>

        </td></tr>
    </table>
    <div style="height: 3px;"></div>

    <table class="grid">
        <tr><th class="header" colspan="2">PEKERJAAN YANG DILAKUKAN</th></tr>
        <?php ($pekerjaanItems = $laporan->pekerjaans->pluck('nama_pekerjaan')->prepend($laporan->pekerjaan)->filter()->unique()->values()); ?>
        <?php for($i = 0; $i < 10; $i++): ?>
            <tr><td class="center" style="width: 5%;"><?php echo e($i + 1); ?></td><td><?php echo e($pekerjaanItems[$i] ?? ''); ?></td></tr>
        <?php endfor; ?>
    </table>
    <div style="height: 3px;"></div>

    <table class="grid">
        <tr><th class="header" colspan="7">BAHAN / MATERIAL</th></tr>
        <tr><th>NO.</th><th>NAMA BAHAN</th><th>VOL.</th><th>SAT.</th><th colspan="2">STATUS</th><th>KETERANGAN</th></tr>
        <?php for($i = 0; $i < 11; $i++): ?>
            <?php ($material = $laporan->materials[$i] ?? null); ?>
            <tr><td class="center"><?php echo e($i + 1); ?></td><td><?php echo e($material->nama_material ?? ''); ?></td><td class="center"><?php echo e($material->volume ?? ''); ?></td><td class="center"><?php echo e($material->satuan ?? ''); ?></td><td></td><td></td><td></td></tr>
        <?php endfor; ?>
    </table>
    <div style="height: 3px;"></div>

    <table class="grid">
        <tr><th class="header" colspan="4">TENAGA KERJA</th><th class="header" colspan="4">ALAT</th></tr>
        <tr><th>NO.</th><th>MACAM TENAGA KERJA</th><th>JUMLAH</th><th>SAT.</th><th>NO.</th><th>NAMA ALAT</th><th>JUMLAH</th><th>SATUAN</th></tr>
        <?php for($i = 0; $i < 10; $i++): ?>
            <?php ($tenaga = $laporan->tenagas[$i] ?? null); ?>
            <?php ($alat = $laporan->alats[$i] ?? null); ?>
            <tr><td class="center"><?php echo e($i + 1); ?></td><td><?php echo e($tenaga ? 'Pekerja' : ''); ?></td><td class="center"><?php echo e($tenaga->pekerja ?? ''); ?></td><td class="center"><?php echo e($tenaga ? 'org' : ''); ?></td><td class="center"><?php echo e($i + 1); ?></td><td><?php echo e($alat->nama_alat ?? ''); ?></td><td class="center"><?php echo e($alat->jumlah ?? ''); ?></td><td class="center"><?php echo e($alat ? 'unit' : ''); ?></td></tr>
        <?php endfor; ?>
    </table>
    <br>

    <table>
        <tr>
            <td class="top" style="width: 55%; padding-right: 8px;">
                <table class="grid">
                    <tr><th colspan="3">WAKTU</th><th colspan="2">JAM KERJA</th><th colspan="2">CUACA</th></tr>
                    <?php for($h = 0; $h < 24; $h++): ?>
                        <tr><td colspan="3" class="center"><?php echo e(sprintf('%02d.00 - %02d.00', $h, ($h + 1) % 24)); ?></td><td colspan="2" class="center"><?php echo e($h === 0 ? (($laporan->jam_mulai ?? '-') . ' - ' . ($laporan->jam_selesai ?? '-')) : ''); ?></td><td colspan="2" class="center"><?php echo e($h === 0 ? ($laporan->cuaca ?? '-') : ''); ?></td></tr>
                    <?php endfor; ?>
                </table>
            </td>
            <td class="top" style="width: 45%; padding-left: 8px;">
                <table class="grid">
                    <tr><th colspan="2">Notasi Jam Kerja</th></tr>
                    <tr><td style="height: 8px;"></td><td>Kerja</td></tr>
                    <tr><td style="height: 8px;"></td><td>Istirahat</td></tr>
                    <tr><td style="height: 8px;"></td><td>Tidak bekerja</td></tr>
                </table>
                <br>
                <table class="grid">
                    <tr><th colspan="2">Notasi Cuaca</th></tr>
                    <tr><td style="height: 8px;"></td><td>Gerimis</td></tr>
                    <tr><td style="height: 8px;"></td><td>Hujan Deras</td></tr>
                    <tr><td style="height: 8px;"></td><td>Cerah</td></tr>
                    <tr><td style="height: 8px;"></td><td>Berawan/Mendung</td></tr>
                </table>
                <br>
                <table class="border"><tr><td class="header">FOTO DOKUMENTASI</td></tr><tr><td class="center" style="height: 155px;">
                    <?php if(count($fotoBase64) > 0): ?>
                        <?php $__currentLoopData = $fotoBase64; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $src): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <img class="photo" src="<?php echo e($src); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        Belum ada foto dokumentasi
                    <?php endif; ?>
                </td></tr></table>
            </td>
        </tr>
    </table>
    <div style="height: 2px;"></div>

    <table class="sign"><tr>
        <td>Diperiksa oleh:<br><b>Konsultan Pengawas</b><br><br><u>__________________</u><br>PT. RENO ABIRAMA SAKTI</td>
        <td><?php echo e(optional($laporan->tanggal)->format('d F Y')); ?><br>Dibuat oleh:<br><b>Kontraktor Pelaksana</b><br><br><u>__________________</u><br><?php echo e($laporan->kontraktor); ?></td>
    </tr></table>
</body>
</html>
<?php /**PATH C:\Users\akuna\OneDrive\Dokumen\PKN 2026\Bot-Monitoring-Pekerjaan\resources\views/pdf/harian-baru.blade.php ENDPATH**/ ?>