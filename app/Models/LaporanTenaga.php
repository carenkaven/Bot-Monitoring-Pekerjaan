<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanTenaga extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_id',
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