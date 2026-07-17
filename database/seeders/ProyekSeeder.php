<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proyek;

class ProyekSeeder extends Seeder
{
    public function run(): void
    {
        Proyek::create([
            'nama_proyek' => 'Pembangunan Jalan Nasional',
            'kegiatan' => 'Pembangunan Infrastruktur',
            'sub_kegiatan' => 'Pembangunan Jalan',
            'pekerjaan' => 'Pengecoran Jalan',
            'lokasi' => 'Yogyakarta',
            'kontraktor' => 'PT Reno Abirama Sakti',
            'konsultan' => 'PT Konsultan Indonesia',
            'pic' => 'Ir. Andi Saputra',
            'status' => 'Aktif'
        ]);
    }
}