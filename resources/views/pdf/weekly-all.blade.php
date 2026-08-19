<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Mingguan</title>
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

@foreach($projects as $projectData)
    @include('pdf.weekly-content', [
        'summary'     => $projectData['summary'],
        'laporans'    => $projectData['laporans'],
        'materials'   => $projectData['materials'],
        'alats'       => $projectData['alats'],
        'tenagas'     => $projectData['tenagas'],
        'pekerjaans'  => $projectData['pekerjaans'],
        'fotos'       => $projectData['fotos'],
    ])
    
    @if(!$loop->last)
        <div class="page-break"></div>
    @endif
@endforeach

</body>
</html>
