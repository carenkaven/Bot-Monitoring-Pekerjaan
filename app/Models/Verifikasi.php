<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Verifikasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_id',
        'user_id',
        'status',
        'catatan',
        'tanggal_verifikasi',
    ];

    protected $casts = [
        'tanggal_verifikasi' => 'datetime',
    ];

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
