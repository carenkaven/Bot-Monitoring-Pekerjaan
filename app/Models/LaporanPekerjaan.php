<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPekerjaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_id',
        'nama_pekerjaan'
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}