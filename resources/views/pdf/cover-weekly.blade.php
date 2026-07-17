<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Cover Laporan Mingguan</title>
<style>
@page{margin:12mm;}
body{font-family:"Times New Roman",serif;font-size:12px;color:#000;margin:0}
.page{
    border:2px solid #000;
    padding:20px 50px;
    box-sizing:border-box;
}
.center{text-align:center}
.logo{width:110px;margin:12px auto;display:block}
h1,h2,h3,p{margin:0}
.title{font-size:24px;font-weight:bold;margin-top:20px}
.subtitle{font-size:20px;font-weight:bold}
.label{font-weight:bold;text-transform:uppercase;margin-top:18px}
.value{font-size:15px;margin-top:6px}
.boxwrap{margin-top:70px;width:100%}
.box{width:46%;display:inline-block;vertical-align:top;border:2px solid #000;min-height:190px}
.box h3{padding:8px;border-bottom:2px solid #000;text-align:center;font-size:13px}
.box .company{padding-top:35px;text-align:center;font-weight:bold;font-size:14px}
.box .addr{padding:15px;text-align:center;font-size:11px;line-height:18px}
.footer{margin-top:35px;font-size:10px}
</style>
</head>
<body>
<div class="page">
<div class="center">
@if(file_exists(public_path('images/logo-kabupaten.png')))
<img src="{{ public_path('images/logo-kabupaten.png') }}" class="logo">
@endif
<h2>PEMERINTAH KABUPATEN MALANG</h2>
<h3>DINAS PEKERJAAN UMUM DAN PENATAAN RUANG</h3>
<p>Jl. Panji No.158 Kepanjen Kabupaten Malang</p>

<div class="title">SURAT PERINTAH KERJA</div>
<div>{{ $summary['nomor_spk'] ?? '-' }}</div>
<div>{{ $summary['tanggal_spk'] ?? \Carbon\Carbon::parse($summary['tanggal_mulai'])->format('d-m-Y') }}</div>

<div class="title" style="margin-top:40px">LAPORAN MINGGUAN</div>
<div class="subtitle">MINGGU KE {{ $summary['minggu_ke'] }}</div>

<div class="label">PERIODE</div>
<div class="value">
{{ \Carbon\Carbon::parse($summary['tanggal_mulai'])->translatedFormat('d F Y') }}
s/d
{{ \Carbon\Carbon::parse($summary['tanggal_selesai'])->translatedFormat('d F Y') }}
</div>

<div class="label">KEGIATAN</div>
<div class="value">{{ strtoupper($summary['kegiatan']) }}</div>

<div class="label">SUB KEGIATAN</div>
<div class="value">{{ strtoupper($summary['sub_kegiatan']) }}</div>

<div class="label">PEKERJAAN</div>
<div class="value">{{ strtoupper($laporans->first()->pekerjaan) }}</div>

<div class="label">LOKASI</div>
<div class="value">{{ strtoupper($summary['lokasi']) }}</div>

<div class="label">TAHUN ANGGARAN</div>
<div class="value">{{ date('Y',strtotime($summary['tanggal_mulai'])) }}</div>
</div>

<div class="boxwrap">
<div class="box">
<h3>KONTRAKTOR PELAKSANA</h3>
<div class="company">{{ strtoupper($summary['kontraktor']) }}</div>
<div class="addr">{{ $summary['alamat_kontraktor'] ?? '-' }}</div>
</div>

<div class="box" style="float:right">
<h3>KONSULTAN PENGAWAS</h3>
<div class="company">{{ strtoupper($summary['konsultan']) }}</div>
<div class="addr">{{ $summary['alamat_konsultan'] ?? 'Jl. Terusan Kayan No. A-22 RT.006 RW.XVIII Kel. Bunulrejo Kec. Blimbing Kota Malang' }}</div>
</div>
<div style="clear:both"></div>
</div>
</div>
</body>
</html>
