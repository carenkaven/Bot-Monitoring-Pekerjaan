<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>

Laporan Mingguan

</title>

<style>

body{

    font-family:Arial, Helvetica, sans-serif;

    font-size:12px;

    color:#000;

}

.page-break{

    page-break-before:always;

}

</style>

</head>

<body>





<?php echo $__env->make('pdf.cover-weekly', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>





<?php $__currentLoopData = $laporans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $laporan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<div class="page-break"></div>

<?php echo $__env->make('pdf.daily-weekly', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</body>

</html><?php /**PATH C:\Users\USER\Downloads\MAGANG VENA\monitoring-laporanpkn1\resources\views/pdf/weekly.blade.php ENDPATH**/ ?>