<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$svc = new \App\Services\WeeklyPhysicalReportService();
try {
    $data = $svc->build('2', 'Proyek Uji Coba Laporan Mingguan');
    echo 'Success without year/month!';
} catch (\Exception $e) {
    echo 'Error without year/month: ' . $e->getMessage() . PHP_EOL;
}
