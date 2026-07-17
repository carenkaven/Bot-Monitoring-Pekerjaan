<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use App\Models\Laporan;
use App\Models\LaporanAlat;
use App\Models\LaporanMaterial;
use App\Models\LaporanPekerjaan;
use App\Models\LaporanTenaga;
use App\Models\Verifikasi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class LaporanSeeder extends Seeder
{
    public function run(): void
    {
        $karyawans = Karyawan::aktif()->get();
        if ($karyawans->isEmpty()) {
            return;
        }

        $admin = User::where('role', 'admin')->first();

        $proyek = [
    [
        'nama_proyek' => 'Pembangunan Jalan Lingkar Barat Kota Malang',
        'kegiatan'    => 'Pembangunan Infrastruktur Jalan',
        'sub_kegiatan'=> 'Rigid Pavement',
        'lokasi'      => 'Jl. Raya Tlogomas, Lowokwaru, Kota Malang, Jawa Timur',
        'kontraktor'  => 'PT Reno Abirama Sakti',
        'konsultan'   => 'PT Konsultan Karya Nusantara',
        'pic'         => 'Ir. Andi Saputra, ST',
    ],
    [
        'nama_proyek' => 'Rehabilitasi Jembatan Sungai Brantas',
        'kegiatan'    => 'Rehabilitasi Jembatan',
        'sub_kegiatan'=> 'Perkuatan Struktur Beton',
        'lokasi'      => 'Jl. Raya Gadang, Sukun, Kota Malang, Jawa Timur',
        'kontraktor'  => 'PT Reno Abirama Sakti',
        'konsultan'   => 'CV Bina Karya Konsultan',
        'pic'         => 'Ir. Budi Hartono',
    ],
    [
        'nama_proyek' => 'Pembangunan Gedung Kantor Pemerintah Kota Malang',
        'kegiatan'    => 'Pembangunan Gedung',
        'sub_kegiatan'=> 'Struktur Lantai 3',
        'lokasi'      => 'Jl. Tugu No.1, Klojen, Kota Malang, Jawa Timur',
        'kontraktor'  => 'PT Reno Abirama Sakti',
        'konsultan'   => 'PT Cipta Karya Persada',
        'pic'         => 'Ir. Rina Kurniawati',
    ],
    [
        'nama_proyek' => 'Pembangunan Drainase Kawasan Soekarno Hatta',
        'kegiatan'    => 'Pembangunan Drainase',
        'sub_kegiatan'=> 'Pemasangan U-Ditch',
        'lokasi'      => 'Jl. Soekarno Hatta, Lowokwaru, Kota Malang, Jawa Timur',
        'kontraktor'  => 'PT Reno Abirama Sakti',
        'konsultan'   => 'PT Mitra Konsultan Indonesia',
        'pic'         => 'Ir. Agus Prasetyo',
    ],
    [
        'nama_proyek' => 'Pembangunan Gedung RSUD Kota Malang',
        'kegiatan'    => 'Pembangunan Gedung',
        'sub_kegiatan'=> 'Pekerjaan Struktur',
        'lokasi'      => 'Jl. Rajasa, Kedungkandang, Kota Malang, Jawa Timur',
        'kontraktor'  => 'PT Reno Abirama Sakti',
        'konsultan'   => 'PT Arsitek Nusantara',
        'pic'         => 'Ir. Dwi Cahyo',
    ],
    [
        'nama_proyek' => 'Pelebaran Jalan Raya Karanglo',
        'kegiatan'    => 'Pelebaran Jalan',
        'sub_kegiatan'=> 'Pekerjaan Aspal',
        'lokasi'      => 'Jl. Raya Karanglo, Singosari, Kabupaten Malang, Jawa Timur',
        'kontraktor'  => 'PT Reno Abirama Sakti',
        'konsultan'   => 'PT Karya Teknik Indonesia',
        'pic'         => 'Ir. Rudi Kurniawan',
    ],
    [
        'nama_proyek' => 'Pembangunan Jembatan Pakis',
        'kegiatan'    => 'Pembangunan Jembatan',
        'sub_kegiatan'=> 'Pengecoran Pilar',
        'lokasi'      => 'Pakis, Kabupaten Malang, Jawa Timur',
        'kontraktor'  => 'PT Reno Abirama Sakti',
        'konsultan'   => 'CV Pilar Konsultan',
        'pic'         => 'Ir. Bambang Setiawan',
    ],
    [
        'nama_proyek' => 'Pembangunan Jalan Tol Pandaan - Malang Seksi Pendukung',
        'kegiatan'    => 'Pembangunan Jalan',
        'sub_kegiatan'=> 'Pekerjaan Bahu Jalan',
        'lokasi'      => 'Lawang, Kabupaten Malang, Jawa Timur',
        'kontraktor'  => 'PT Reno Abirama Sakti',
        'konsultan'   => 'PT Infrastruktur Nusantara',
        'pic'         => 'Ir. Hendra Wijaya',
    ],
];

        $pekerjaanList = ['Pengecoran', 'Pembesian', 'Bekisting', 'Galian', 'Timbunan', 'Pemasangan Batu', 'Pengaspalan'];
        $materialList  = [
            ['Semen Portland', 'sak', 50],
            ['Besi Beton 12mm', 'batang', 24],
            ['Pasir Beton', 'm³', 8],
            ['Kerikil 2/3', 'm³', 6],
            ['Ready Mix K-350', 'm³', 15],
        ];
        $alatList = [
            ['Concrete Mixer', 2],
            ['Excavator PC-200', 1],
            ['Vibrator', 3],
            ['Dump Truck', 4],
            ['Bar Bender', 2],
        ];

        for ($i = 0; $i < 18; $i++) {
            $p        = $proyek[$i % count($proyek)];
            $karyawan = $karyawans->random();
            $tanggal  = Carbon::today()->subDays(random_int(0, 45));

            $status = match (true) {
                $i < 6                => Laporan::STATUS_MENUNGGU,
                $i < 14               => Laporan::STATUS_DISETUJUI,
                default               => Laporan::STATUS_DITOLAK,
            };

            $laporan = Laporan::create([
                'karyawan_id'  => $karyawan->id,
                'nama_proyek'  => $p['nama_proyek'],
                'kegiatan'     => $p['kegiatan'],
                'sub_kegiatan' => $p['sub_kegiatan'],
                'pekerjaan'    => $pekerjaanList[array_rand($pekerjaanList)].' Section '.random_int(1, 8),
                'lokasi'       => $p['lokasi'],
                'kontraktor'   => $p['kontraktor'],
                'konsultan'    => $p['konsultan'],
                'pic'          => $p['pic'],
                'minggu_ke'    => (string) random_int(1, 12),
                'tanggal'      => $tanggal,
                'status'       => $status,
                'catatan'      => $status === Laporan::STATUS_DITOLAK ? 'Foto dokumentasi kurang jelas, mohon dikirim ulang.' : null,
            ]);

            /* Detail Pekerjaan */
            foreach (array_rand($pekerjaanList, 2) as $idx) {
                LaporanPekerjaan::create([
                    'laporan_id'     => $laporan->id,
                    'nama_pekerjaan' => $pekerjaanList[$idx],
                ]);
            }

            /* Tenaga */
            LaporanTenaga::create([
                'laporan_id' => $laporan->id,
                'pekerja'    => random_int(4, 15),
                'tukang'     => random_int(2, 8),
                'mandor'     => random_int(1, 2),
                'pelaksana'  => 1,
            ]);

            /* Material */
            foreach (array_rand($materialList, 3) as $idx) {
                $m = $materialList[$idx];
                LaporanMaterial::create([
                    'laporan_id'    => $laporan->id,
                    'nama_material' => $m[0],
                    'volume'        => $m[2] + random_int(0, 10),
                    'satuan'        => $m[1],
                ]);
            }

            /* Alat */
            foreach (array_rand($alatList, 2) as $idx) {
                LaporanAlat::create([
                    'laporan_id' => $laporan->id,
                    'nama_alat'  => $alatList[$idx][0],
                    'jumlah'     => $alatList[$idx][1],
                ]);
            }

            /* Verifikasi */
            if ($status !== Laporan::STATUS_MENUNGGU && $admin) {
                Verifikasi::create([
                    'laporan_id'         => $laporan->id,
                    'user_id'            => $admin->id,
                    'status'             => $status,
                    'catatan'            => $status === Laporan::STATUS_DISETUJUI
                        ? 'Laporan sesuai standar.'
                        : 'Foto dokumentasi kurang jelas.',
                    'tanggal_verifikasi' => $tanggal->copy()->addHours(random_int(2, 20)),
                ]);
            }
        }
    }
}
