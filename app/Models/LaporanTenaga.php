<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanTenaga extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_id',
        'jenis_tenaga',
        'jumlah',
        'satuan',
        'pekerja',
        'tukang',
        'mandor',
        'pelaksana'
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}
