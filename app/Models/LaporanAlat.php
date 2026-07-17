<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanAlat extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_id',
        'nama_alat',
        'jumlah'
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}