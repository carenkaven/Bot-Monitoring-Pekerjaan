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

{{-- ===================================================== --}}
{{-- COVER --}}
{{-- ===================================================== --}}

@include('pdf.cover-weekly')

{{-- ===================================================== --}}
{{-- SELURUH LAPORAN HARIAN --}}
{{-- ===================================================== --}}

@foreach($laporans as $laporan)

<div class="page-break"></div>

@include('pdf.daily-weekly')

@endforeach

</body>

</html>