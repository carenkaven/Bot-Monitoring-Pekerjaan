<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <style>
        @page { size: A4 portrait; margin: 25px; }
        body { font-family: Arial, sans-serif; font-size: 6px; color: #000; }
        table { width: 100%; border-collapse: collapse; }
        .border td, .border th, .grid td, .grid th { border: 1px solid #000; }
        .grid td, .grid th { padding: 1px 2px; height: 8px; line-height: 8px; }
        .header { background: #d9d9d9; text-align: center; font-weight: bold; }
        .center { text-align: center; vertical-align: middle; }
        .top { vertical-align: top; }
        .photo { width: 95%; max-height: 140px; object-fit: cover; margin: 0 auto; }
        .sign td { text-align: center; vertical-align: bottom; height: 38px; }
        .no-border td { border: none !important; padding: 0 2px; }
        .waktu-table { width: 100%; border-collapse: collapse; }
        .waktu-table th, .waktu-table td { border: 1px solid #000; padding: 1px 2px; height: 8px; line-height: 8px; }
        .waktu-table .no-b { border: none !important; }
    </style>
</head>
<body>
    <table class="border">
        <tr><td class="header" style="height: 14px; font-size: 10px;">LAPORAN HARIAN</td></tr>
        <tr><td style="padding: 3px; height: 43px;">
            <table class="no-border" style="width: 100%;">
                <tr><td style="width: 80px;"><b>Pekerjaan</b></td><td style="width: 10px;">:</td><td>{{ $laporan->pekerjaan }}</td></tr>
                <tr><td><b>Lokasi</b></td><td>:</td><td>{{ $laporan->lokasi }}</td></tr>
                <tr><td><b>Tahun Anggaran</b></td><td>:</td><td>{{ optional($laporan->tanggal)->format('Y') }}</td></tr>
                <tr><td><b>Minggu Ke</b></td><td>:</td><td>{{ $laporan->minggu_ke }}</td></tr>
                <tr><td><b>Periode</b></td><td>:</td><td>{{ optional($laporan->tanggal)->format('d F Y') }}</td></tr>
                <tr><td><b>Tanggal</b></td><td>:</td><td>{{ optional($laporan->tanggal)->format('d F Y') }}</td></tr>
            </table>
        </td></tr>
    </table>
    <div style="height: 6px;"></div>

    <table class="grid">
        <tr><th class="header" colspan="2">PEKERJAAN YANG DILAKUKAN</th></tr>
        @php
            $pekerjaanItems = $laporan->pekerjaans->pluck('nama_pekerjaan')->prepend($laporan->pekerjaan)->filter()->unique()->values();
            $totalBarisTenagaAlat = max(10, $laporan->tenagas->count(), $laporan->alats->count());
        @endphp
        @for($i = 0; $i < $totalBarisTenagaAlat; $i++)
            <tr><td class="center" style="width: 5%;">{{ $i + 1 }}</td><td>{{ $pekerjaanItems[$i] ?? '' }}</td></tr>
        @endfor
    </table>
    <div style="height: 6px;"></div>

    <table class="grid">
        <tr><th class="header" colspan="7">BAHAN / MATERIAL</th></tr>
        <tr><th>NO.</th><th>NAMA BAHAN</th><th>VOL.</th><th>SAT.</th><th colspan="2">STATUS</th><th>KETERANGAN</th></tr>
        @for($i = 0; $i < 11; $i++)
            @php
                $material = $laporan->materials->values()->get($i);
            @endphp
            <tr><td class="center">{{ $i + 1 }}</td><td>{{ $material->nama_material ?? '' }}</td><td class="center">{{ $material->volume ?? '' }}</td><td class="center">{{ $material->satuan ?? '' }}</td><td></td><td></td><td></td></tr>
        @endfor
    </table>
    <div style="height: 6px;"></div>

    <table class="grid">
        <tr><th class="header" colspan="4">TENAGA KERJA</th><th class="header" colspan="4">ALAT</th></tr>
        <tr><th>NO.</th><th>MACAM TENAGA KERJA</th><th>JUMLAH</th><th>SAT.</th><th>NO.</th><th>NAMA ALAT</th><th>JUMLAH</th><th>SATUAN</th></tr>
        @php
            $tenagaList = [];
            foreach ($laporan->tenagas as $t) {
                if ($t->jenis_tenaga) {
                    $tenagaList[] = ['jenis' => $t->jenis_tenaga, 'jumlah' => $t->jumlah, 'satuan' => $t->satuan ?? 'org'];
                } else {
                    if ($t->pekerja !== null) $tenagaList[] = ['jenis' => 'Pekerja', 'jumlah' => $t->pekerja, 'satuan' => 'org'];
                    if ($t->tukang !== null) $tenagaList[] = ['jenis' => 'Tukang', 'jumlah' => $t->tukang, 'satuan' => 'org'];
                    if ($t->mandor !== null) $tenagaList[] = ['jenis' => 'Mandor', 'jumlah' => $t->mandor, 'satuan' => 'org'];
                    if ($t->pelaksana !== null) $tenagaList[] = ['jenis' => 'Pelaksana lapangan', 'jumlah' => $t->pelaksana, 'satuan' => 'org'];
                }
            }
            $totalBarisTenagaAlat = max(10, count($tenagaList), $laporan->alats->count());
        @endphp
        @for($i = 0; $i < $totalBarisTenagaAlat; $i++)
            @php
                $tenaga = $tenagaList[$i] ?? null;
                $alat = $laporan->alats[$i] ?? null;
            @endphp
            <tr><td class="center">{{ $i + 1 }}</td><td>{{ $tenaga['jenis'] ?? '' }}</td><td class="center">{{ $tenaga['jumlah'] ?? '' }}</td><td class="center">{{ isset($tenaga) ? $tenaga['satuan'] : '' }}</td><td class="center">{{ $i + 1 }}</td><td>{{ $alat->nama_alat ?? '' }}</td><td class="center">{{ $alat->jumlah ?? '' }}</td><td class="center">{{ $alat ? 'unit' : '' }}</td></tr>
        @endfor
    </table>
    <br>

    <table class="waktu-table">
        <tr>
            <th class="header" colspan="3" style="width: 25%;">WAKTU</th>
            <th class="header" colspan="2" style="width: 15%;">JAM KERJA</th>
            <th class="header" colspan="2" style="width: 15%;">CUACA</th>
            <td class="no-b" style="width: 2%;"></td>
            <td class="no-b" colspan="2" style="width: 21%; font-weight:bold; padding-bottom:5px; text-align: left;">Notasi Jam Kerja :</td>
            <td class="no-b" colspan="2" style="width: 22%; font-weight:bold; padding-bottom:5px; text-align: left;">Notasi Cuaca :</td>
        </tr>
        @php
            $patKerja = 'file:///' . str_replace('\\', '/', public_path('images/pat_kerja.png'));
            $patIstirahat = 'file:///' . str_replace('\\', '/', public_path('images/pat_istirahat.png'));
            $patHujan = 'file:///' . str_replace('\\', '/', public_path('images/pat_hujan.png'));
            
            $startHour = $laporan->jam_mulai ? (int) substr($laporan->jam_mulai, 0, 2) : null;
            $endHour = $laporan->jam_selesai ? (int) substr($laporan->jam_selesai, 0, 2) : null;
            $cuacaStr = strtolower($laporan->cuaca ?? '');
            
            $cuacaStyle = 'background-color: #ffffff;';
            if (str_contains($cuacaStr, 'gerimis')) {
                $cuacaStyle = "background-color: #808080; background-image: url('$patKerja'); background-repeat: repeat;";
            } elseif (str_contains($cuacaStr, 'hujan deras') || str_contains($cuacaStr, 'hujan lebat')) {
                $cuacaStyle = "background-color: #d9d9d9; background-image: url('$patHujan'); background-repeat: repeat;";
            } elseif (str_contains($cuacaStr, 'berawan') || str_contains($cuacaStr, 'mendung')) {
                $cuacaStyle = "background-color: #ffffff;";
            }
        @endphp
        @for($h = 0; $h < 24; $h++)
            @php
                $jamStyle = 'background-color: #ffffff;';
                if ($startHour !== null && $endHour !== null) {
                    if ($h >= $startHour && $h < $endHour) {
                        $jamStyle = ($h == 12) ? "background-color: #d9d9d9; background-image: url('$patIstirahat'); background-repeat: repeat;" : "background-color: #808080; background-image: url('$patKerja'); background-repeat: repeat;";
                    }
                }
                $cellCuacaStyle = ($jamStyle !== 'background-color: #ffffff;') ? $cuacaStyle : 'background-color: #ffffff;';
            @endphp
            <tr>
                <td colspan="3" class="center">{{ sprintf('%02d.00 - %02d.00', $h, ($h + 1) % 24) }}</td>
                <td colspan="2" style="{{ $jamStyle }}"></td>
                <td colspan="2" style="{{ $cellCuacaStyle }}"></td>
                
                <td class="no-b"></td>
                
                @if($h == 0)
                    <td style="height: 10px; width: 25px; background-color: #808080; background-image: url('{{ $patKerja }}'); background-repeat: repeat;"></td>
                    <td class="no-b" style="padding-left: 5px; vertical-align:middle;">Kerja</td>
                    <td style="height: 10px; width: 25px; background-color: #808080; background-image: url('{{ $patKerja }}'); background-repeat: repeat;"></td>
                    <td class="no-b" style="padding-left: 5px; vertical-align:middle;">Gerimis</td>
                @elseif($h == 1)
                    <td style="height: 10px; width: 25px; background-color: #d9d9d9; background-image: url('{{ $patIstirahat }}'); background-repeat: repeat;"></td>
                    <td class="no-b" style="padding-left: 5px; vertical-align:middle;">Istirahat</td>
                    <td style="height: 10px; width: 25px; background-color: #d9d9d9; background-image: url('{{ $patHujan }}'); background-repeat: repeat;"></td>
                    <td class="no-b" style="padding-left: 5px; vertical-align:middle;">Hujan Deras</td>
                @elseif($h == 2)
                    <td style="height: 10px; width: 25px; background-color: #ffffff;"></td>
                    <td class="no-b" style="padding-left: 5px; vertical-align:middle;">Tidak bekerja</td>
                    <td style="height: 10px; width: 25px; background-color: #ffffff;"></td>
                    <td class="no-b" style="padding-left: 5px; vertical-align:middle;">Cerah</td>
                @elseif($h == 3)
                    <td class="no-b" colspan="2"></td>
                    <td style="height: 10px; width: 25px; background-color: #ffffff;"></td>
                    <td class="no-b" style="padding-left: 5px; vertical-align:middle;">Berawan/Mendung</td>
                @elseif($h == 4)
                    <td class="no-b" colspan="4"></td>
                @elseif($h == 5)
                    <td class="header" colspan="4">FOTO DOKUMENTASI</td>
                @elseif($h == 6)
                    <td class="center" colspan="4" rowspan="18" style="padding: 4px; vertical-align: middle;">
                        @if(count($fotoDokumentasi) > 0)
                            <table style="width:100%; border-collapse:collapse; border: none;">
                                <tr>
                                    @foreach($fotoDokumentasi as $src)
                                        <td style="width:33.33%; border:none; padding:2px; text-align:center; vertical-align:middle;">
                                            <img class="photo" src="{{ $src }}" alt="Foto dokumentasi">
                                        </td>
                                    @endforeach
                                </tr>
                            </table>
                        @else
                            Belum ada foto dokumentasi
                        @endif
                    </td>
                @endif
            </tr>
        @endfor
    </table>
    <div style="height: 2px;"></div>

    <table class="sign" style="margin-top: 15px; width: 100%;"><tr>
        <td style="width: 50%;">Diperiksa oleh:<br><b>Konsultan Pengawas</b><br><br><br><br><br><u>___________________________</u><br>PT. RENO ABIRAMA SAKTI</td>
        <td style="width: 50%;">{{ optional($laporan->tanggal)->format('d F Y') }}<br>Dibuat oleh:<br><b>Kontraktor Pelaksana</b><br><br><br><br><br><u>___________________________</u><br>{{ $laporan->kontraktor }}</td>
    </tr></table>
</body>
</html>
