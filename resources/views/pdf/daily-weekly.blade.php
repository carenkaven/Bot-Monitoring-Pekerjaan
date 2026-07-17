<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<style>

/* FIX: kertas F4 (215mm x 330mm) + margin diperkecil supaya semua tabel
   (termasuk 24 baris jam kerja) muat dalam 1 halaman, tidak meluber ke
   halaman kedua. */
@page{
    size:215mm 330mm;
    margin:6mm 8mm;
}

body{
    font-family:"Times New Roman",serif;
    font-size:9px;
    margin:0;
    padding:0;
}

table{
    width:100%;
    border-collapse:collapse;
    table-layout:fixed;
}

/* menyambungkan border antar section supaya jadi satu kotak besar */
table.stack{
    margin-top:-1px;
}

th,td{
    border:1px solid #000;
    padding:1px 3px;
    vertical-align:top;
    word-wrap:break-word;
}

.center{
    text-align:center;
}

.right{
    text-align:right;
}

.bold{
    font-weight:bold;
}

.italic{
    font-style:italic;
}

.small{
    font-size:7px;
}

.nowrap{
    white-space:nowrap;
}

.title{
    font-size:13px;
    font-weight:bold;
}

.no-border{
    border:none !important;
}

.h20{
    height:14px;
}

.h30{
    height:18px;
}

.gray{
    background:#e8e8e8;
}

/* gelap = "Kerja" jam kerja / "Hujan Deras" cuaca */
.shade-dark{
    background:#8c8c8c;
}

/* terang = "Istirahat" jam kerja / "Gerimis" cuaca */
.shade-light{
    background:#cfcfcf;
}

.legend-box{
    width:100%;
    table-layout:auto;
    margin-bottom:3px;
}

.legend-box td{
    border:1px solid #000;
    padding:0px 3px;
}

.legend-swatch{
    width:18px;
}

</style>

</head>

<body>

<!-- ================= JUDUL ================= -->
<!-- FIX: judul di PDF punya background abu-abu (class gray), sebelumnya polos -->

<table>

<tr>

<th class="center title gray">

LAPORAN HARIAN

</th>

</tr>

</table>

<!-- ================= INFO HEADER ================= -->

<table class="stack">

<colgroup>
<col style="width:18%">
<col style="width:3%">
<col style="width:79%">
</colgroup>

<tr>
<td class="no-border bold">Pekerjaan</td>
<td class="no-border">:</td>
<td class="no-border">{{ strtoupper($laporan->pekerjaan) }}</td>
</tr>

<tr>
<td class="no-border bold">Lokasi</td>
<td class="no-border">:</td>
<td class="no-border">{{ strtoupper($laporan->lokasi) }}</td>
</tr>

<tr>
<td class="no-border bold">Tahun Anggaran</td>
<td class="no-border">:</td>
<td class="no-border">{{ date('Y',strtotime($laporan->tanggal)) }}</td>
</tr>

<tr>
<td class="no-border bold">Minggu Ke</td>
<td class="no-border">:</td>
<td class="no-border">{{ $summary['minggu_ke'] }}</td>
</tr>

<tr>
<td class="no-border bold">Periode</td>
<td class="no-border">:</td>
<td class="no-border">
{{ \Carbon\Carbon::parse($summary['tanggal_mulai'])->format('d F Y') }}
s/d
{{ \Carbon\Carbon::parse($summary['tanggal_selesai'])->format('d F Y') }}
</td>
</tr>

<tr>
<td class="no-border bold">Tanggal</td>
<td class="no-border">:</td>
<td class="no-border">{{ $laporan->tanggal->translatedFormat('d F Y') }}</td>
</tr>

</table>

<!-- ================= PEKERJAAN YANG DILAKUKAN ================= -->

<table class="stack">

<colgroup>
<col style="width:6%">
<col style="width:94%">
</colgroup>

<thead>
<tr>
<th colspan="2" class="gray center">PEKERJAAN YANG DILAKUKAN</th>
</tr>
</thead>

<tbody>

@php
$pekerjaan = $laporan->pekerjaans->values();
@endphp

@for($i=0;$i<11;$i++)
<tr>
<td class="center h20">{{ $i+1 }}</td>
<td class="h20">{{ $pekerjaan[$i]->nama_pekerjaan ?? '' }}</td>
</tr>
@endfor

</tbody>

</table>

<!-- ================= BAHAN / MATERIAL ================= -->
<!-- FIX: di PDF, "STATUS" adalah header colspan 2 yang menaungi 2 kolom terpisah
     (DITERIMA & DITOLAK), bukan satu kolom dengan teks "DITERIMA   DITOLAK".
     Makanya sekarang jadi 7 kolom, dan tanda centang/silang ditaruh di kolom
     yang sesuai. -->

<table class="stack">

<colgroup>
<col style="width:6%">
<col style="width:30%">
<col style="width:8%">
<col style="width:7%">
<col style="width:12%">
<col style="width:12%">
<col style="width:25%">
</colgroup>

<thead>

<tr>
<th colspan="7" class="gray center">BAHAN / MATERIAL</th>
</tr>

<tr class="gray">
<th rowspan="2">NO.</th>
<th rowspan="2">NAMA BAHAN</th>
<th rowspan="2">VOL.</th>
<th rowspan="2">SAT.</th>
<th colspan="2">STATUS</th>
<th rowspan="2">KETERANGAN</th>
</tr>

<tr class="gray">
<th>DITERIMA</th>
<th>DITOLAK</th>
</tr>

</thead>

<tbody>

@php
$materials = $laporan->materials->values();
@endphp

@for($i=0;$i<11;$i++)
<tr>
<td class="center h20">{{ $i+1 }}</td>
<td>{{ $materials[$i]->nama_material ?? '' }}</td>
<td class="center">
@if(isset($materials[$i]))
{{ rtrim(rtrim(number_format($materials[$i]->volume,2,'.',''),'0'),'.') }}
@endif
</td>
<td class="center">{{ $materials[$i]->satuan ?? '' }}</td>
<td class="center">
@if(($materials[$i]->status ?? '')=='Diterima')
✔
@endif
</td>
<td class="center">
@if(($materials[$i]->status ?? '')=='Ditolak')
✖
@endif
</td>
<td>{{ $materials[$i]->keterangan ?? '' }}</td>
</tr>
@endfor

</tbody>

</table>

<!-- ================= TENAGA KERJA / ALAT ================= -->

<table class="stack">

<colgroup>
<col style="width:6%">
<col style="width:20%">
<col style="width:8%">
<col style="width:6%">
<col style="width:6%">
<col style="width:24%">
<col style="width:8%">
<col style="width:10%">
<col style="width:12%">
</colgroup>

<thead>

<tr>
<th colspan="4" class="gray center">TENAGA KERJA</th>
<th colspan="5" class="gray center">ALAT</th>
</tr>

<tr class="gray">
<th>NO.</th>
<th>MACAM TENAGA KERJA</th>
<th>JUMLAH</th>
<th>SAT.</th>
<th>NO.</th>
<th>NAMA ALAT</th>
<th>JUMLAH</th>
<th>SATUAN</th>
<th>KETERANGAN</th>
</tr>

</thead>

<tbody>

@php

$totalPekerja = 0;
$totalTukang = 0;
$totalMandor = 0;
$totalPelaksana = 0;

foreach($laporan->tenagas as $tenaga){

    $totalPekerja   += $tenaga->pekerja;
    $totalTukang    += $tenaga->tukang;
    $totalMandor    += $tenaga->mandor;
    $totalPelaksana += $tenaga->pelaksana;

}

$alat = $laporan->alats->values();

@endphp

<tr>
<td class="center">1</td>
<td>Pekerja</td>
<td class="center">{{ $totalPekerja }}</td>
<td class="center italic">org</td>
<td class="center">1</td>
<td>{{ $alat[0]->nama_alat ?? '' }}</td>
<td class="center">{{ $alat[0]->jumlah ?? '' }}</td>
<td class="center">{{ $alat[0]->satuan ?? '' }}</td>
<td>{{ $alat[0]->keterangan ?? '' }}</td>
</tr>

<tr>
<td class="center">2</td>
<td>Tukang</td>
<td class="center">{{ $totalTukang }}</td>
<td class="center italic">org</td>
<td class="center">2</td>
<td>{{ $alat[1]->nama_alat ?? '' }}</td>
<td class="center">{{ $alat[1]->jumlah ?? '' }}</td>
<td class="center">{{ $alat[1]->satuan ?? '' }}</td>
<td>{{ $alat[1]->keterangan ?? '' }}</td>
</tr>

<tr>
<td class="center">3</td>
<td>Mandor</td>
<td class="center">{{ $totalMandor }}</td>
<td class="center italic">org</td>
<td class="center">3</td>
<td>{{ $alat[2]->nama_alat ?? '' }}</td>
<td class="center">{{ $alat[2]->jumlah ?? '' }}</td>
<td class="center">{{ $alat[2]->satuan ?? '' }}</td>
<td>{{ $alat[2]->keterangan ?? '' }}</td>
</tr>

<tr>
<td class="center">4</td>
<td>Pelaksana Lapangan</td>
<td class="center">{{ $totalPelaksana }}</td>
<td class="center italic">org</td>
<td class="center">4</td>
<td>{{ $alat[3]->nama_alat ?? '' }}</td>
<td class="center">{{ $alat[3]->jumlah ?? '' }}</td>
<td class="center">{{ $alat[3]->satuan ?? '' }}</td>
<td>{{ $alat[3]->keterangan ?? '' }}</td>
</tr>

@for($i=4;$i<10;$i++)
<tr>
<td>&nbsp;</td>
<td></td>
<td></td>
<td></td>
<td class="center">{{ $i+1 }}</td>
<td>{{ $alat[$i]->nama_alat ?? '' }}</td>
<td class="center">{{ $alat[$i]->jumlah ?? '' }}</td>
<td class="center">{{ $alat[$i]->satuan ?? '' }}</td>
<td>{{ $alat[$i]->keterangan ?? '' }}</td>
</tr>
@endfor

</tbody>

</table>

<!-- ================= WAKTU / JAM KERJA / CUACA ================= -->
<!-- FIX: di PDF ada 1 kolom kosong tipis (tanpa label) sebagai pemisah antara
     blok JAM KERJA dan blok CUACA. Lebar kolom disesuaikan mengikuti
     proporsi asli di PDF (WAKTU lebih lebar, lalu JAM KERJA, spacer tipis,
     CUACA, baru keterangan/legenda). -->

<table class="stack">

<colgroup>
<col style="width:24%">
<col style="width:15%">
<col style="width:4%">
<col style="width:15%">
<col style="width:42%">
</colgroup>

<thead>

<tr>
<th colspan="5" class="gray center">WAKTU / JAM KERJA / CUACA</th>
</tr>

<tr class="gray">
<th>WAKTU</th>
<th>JAM KERJA</th>
<th></th>
<th>CUACA</th>
<th class="no-border"></th>
</tr>

</thead>

<tbody>

@php
// Asumsi: $laporan->jamKerjas adalah relasi berisi baris per jam,
// masing-masing punya kolom jam_ke (0-23), status_kerja
// ('kerja' | 'istirahat' | 'tidak_bekerja'), dan cuaca
// ('gerimis' | 'hujan_deras' | 'cerah' | 'berawan').
// Sesuaikan nama relasi/kolom ini dengan struktur data Anda.

$jamKerjas = collect($laporan->jamKerjas ?? []);

$kelasKerja = [
    'kerja'         => 'shade-dark',
    'istirahat'     => 'shade-light',
    'tidak_bekerja' => '',
];

$kelasCuaca = [
    'hujan_deras' => 'shade-dark',
    'gerimis'     => 'shade-light',
    'cerah'       => '',
    'berawan'     => '',
];
@endphp

@for($j=0;$j<24;$j++)

@php
$jamMulai   = str_pad($j,2,'0',STR_PAD_LEFT).'.00';
$jamSelesai = str_pad(($j+1)%24,2,'0',STR_PAD_LEFT).'.00';

$dataJam = $jamKerjas->firstWhere('jam_ke', $j);

$statusKerja = $dataJam->status_kerja ?? null;
$cuaca       = $dataJam->cuaca ?? null;

$classKerja = $kelasKerja[$statusKerja] ?? '';
$classCuaca = $kelasCuaca[$cuaca] ?? '';
@endphp

<tr>

<td class="center h20">{{ $jamMulai }} - {{ $jamSelesai }}</td>

<td class="h20 {{ $classKerja }}"></td>

<td class="h20"></td>

<td class="h20 {{ $classCuaca }}"></td>

@if($j==0)

<td rowspan="24" class="no-border" style="vertical-align:top; padding:3px;">

<div class="bold small">Notasi Jam Kerja :</div>

<table class="legend-box">
<tr><td class="legend-swatch shade-dark">&nbsp;</td><td>Kerja</td></tr>
<tr><td class="legend-swatch shade-light">&nbsp;</td><td>Istirahat</td></tr>
<tr><td class="legend-swatch">&nbsp;</td><td>Tidak bekerja</td></tr>
</table>

<div class="bold small">Notasi Cuaca:</div>

<table class="legend-box">
<tr><td class="legend-swatch shade-light">&nbsp;</td><td>Gerimis</td></tr>
<tr><td class="legend-swatch shade-dark">&nbsp;</td><td>Hujan Deras</td></tr>
<tr><td class="legend-swatch">&nbsp;</td><td>Cerah</td></tr>
<tr><td class="legend-swatch">&nbsp;</td><td>Berawan/Mendung</td></tr>
</table>

</td>

@endif

</tr>

@endfor

</tbody>

</table>

<!-- ================= TANDA TANGAN ================= -->
<!-- FIX: di PDF, baris "Malang, tanggal" dan "Dibuat oleh :" sejajar di atas
     kolom Kontraktor Pelaksana saja (center), bukan rata-kanan yang melebar
     ke seluruh lebar tabel. -->

<table class="stack">

<colgroup>
<col style="width:45%">
<col style="width:10%">
<col style="width:45%">
</colgroup>

<tr>
<td colspan="3" class="no-border h30"></td>
</tr>

<tr>
<td class="no-border"></td>
<td class="no-border"></td>
<td class="no-border center">
{{ $laporan->lokasi_ttd ?? 'Malang' }}, {{ $laporan->tanggal->translatedFormat('d F Y') }}
</td>
</tr>

<tr>
<td class="no-border center">Diperiksa oleh :<br>Konsultan Pengawas</td>
<td class="no-border"></td>
<td class="no-border center">Dibuat oleh :<br>Kontraktor Pelaksana</td>
</tr>

<tr>
<td class="no-border center bold">{{ $laporan->nama_konsultan ?? '' }}</td>
<td class="no-border"></td>
<td class="no-border center bold">{{ $laporan->nama_kontraktor ?? '' }}</td>
</tr>

<tr>
<td colspan="3" class="no-border h30"></td>
</tr>

<tr>
<td class="no-border center bold" style="text-decoration:underline;">{{ $laporan->nama_inspector ?? '' }}</td>
<td class="no-border"></td>
<td class="no-border center bold" style="text-decoration:underline;">{{ $laporan->nama_pelaksana ?? '' }}</td>
</tr>

<tr>
<td class="no-border center">Inspector</td>
<td class="no-border"></td>
<td class="no-border center">Pelaksana</td>
</tr>

</table>

</body>

</html>
