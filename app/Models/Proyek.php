<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;

    protected $fillable = [

        'kode_proyek',

        'nama_proyek',

        'kegiatan',

        'sub_kegiatan',

        'pekerjaan',

        'lokasi',

        'kontraktor',

        'konsultan',

        'pic',

        'tanggal_mulai',

        'tanggal_selesai',

        'status'

    ];

    public function laporans()
    {
        return $this->hasMany(Laporan::class);
    }
}