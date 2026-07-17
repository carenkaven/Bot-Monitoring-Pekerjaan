<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">

<style>

@page{
    margin:15px;
}

body{
    font-family:Arial,Helvetica,sans-serif;
    font-size:11px;
}

table{
    width:100%;
    border-collapse:collapse;
}

.border{
    border:1px solid #000;
}

.center{
    text-align:center;
}

.middle{
    vertical-align:middle;
}

.top{
    vertical-align:top;
}

.logo{
    width:70px;
}

.judul{
    font-size:18px;
    font-weight:bold;
}

.subjudul{
    font-size:14px;
    font-weight:bold;
}

.header td{
    border:1px solid #000;
    padding:5px;
}

.foto{
    width:100%;
    height:260px;
    object-fit:cover;
}

.foto-box{
    padding:5px;
    height:270px;
}

.info td{
    padding:3px;
}

</style>

</head>

<body>

<table>

<tr>

<td width="12%" class="center">

@if(file_exists(public_path('images/logo-ras.png')))
<img src="{{ public_path('images/logo-ras.png') }}" class="logo">
@endif

</td>

<td width="88%" class="center">

<div class="judul">

PT RENO ABIRAMA SAKTI

</div>

<div class="subjudul">

DOKUMENTASI PEKERJAAN HARIAN

</div>

</td>

</tr>

</table>

<br>

<table class="header">

<tr>

<td width="75%">

<table class="info">

<tr>
<td width="25%">Nama Proyek</td>
<td width="3%">:</td>
<td>{{ $laporan->nama_proyek }}</td>
</tr>

<tr>
<td>Kegiatan</td>
<td>:</td>
<td>{{ $laporan->kegiatan }}</td>
</tr>

<tr>
<td>Sub Kegiatan</td>
<td>:</td>
<td>{{ $laporan->sub_kegiatan }}</td>
</tr>

<tr>
<td>Pekerjaan</td>
<td>:</td>
<td>{{ $laporan->pekerjaan }}</td>
</tr>

<tr>
<td>Lokasi</td>
<td>:</td>
<td>{{ $laporan->lokasi }}</td>
</tr>

<tr>
<td>Kontraktor</td>
<td>:</td>
<td>{{ $laporan->kontraktor }}</td>
</tr>

<tr>
<td>Konsultan</td>
<td>:</td>
<td>{{ $laporan->konsultan }}</td>
</tr>

<tr>
<td>Minggu Ke</td>
<td>:</td>
<td>{{ $laporan->minggu_ke }}</td>
</tr>

</table>

</td>

<td width="25%" class="center middle">

<b>KONTRAKTOR PELAKSANA</b>

<br><br>

{{ $laporan->kontraktor }}

</td>

</tr>

</table>

<br>

<table>

<tr>

<th class="border" width="6%">
No
</th>

<th class="border" width="69%">
Foto Dokumentasi
</th>

<th class="border" width="25%">
Keterangan
</th>

</tr>
@if($laporan->fotos->count() > 0)

@foreach($laporan->fotos as $index => $foto)

<tr>

<td class="border center top">

{{ $index + 1 }}

</td>

<td class="border foto-box center middle">

@php

$path = public_path('storage/'.$foto->foto);

@endphp

@if(file_exists($path))

<img src="{{ $path }}" class="foto">

@else

<div style="margin-top:120px">

FOTO TIDAK DITEMUKAN

</div>

@endif

</td>

<td class="border top">

<table style="width:100%;border-collapse:collapse;">

<tr>

<td class="border">

<b>Minggu Ke</b>

<br><br>

{{ $laporan->minggu_ke }}

</td>

</tr>

<tr>

<td class="border" style="height:180px;">

<b>KETERANGAN</b>

<br><br>

{{ $foto->keterangan ?? '-' }}

</td>

</tr>

</table>

</td>

</tr>

@endforeach

@else

<tr>

<td class="border center">

1

</td>

<td class="border center" style="height:270px;">

Belum ada foto dokumentasi

</td>

<td class="border top">

<b>Minggu Ke</b>

<br><br>

{{ $laporan->minggu_ke }}

<br><br><br>

<b>KETERANGAN</b>

<br><br>

Belum ada dokumentasi pekerjaan.

</td>

</tr>

@endif

</table>

<br><br>