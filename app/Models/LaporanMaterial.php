<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanMaterial extends Model
{
    protected $fillable = [

        'laporan_id',

        'nama_material',

        'volume',

        'satuan'

    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}