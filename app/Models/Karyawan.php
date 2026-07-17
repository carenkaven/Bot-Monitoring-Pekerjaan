<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Karyawan extends Model
{
    use HasFactory;

    public const STATUS_PENDING  = 'pending';
    public const STATUS_AKTIF    = 'aktif';
    public const STATUS_NONAKTIF = 'nonaktif';
    public const STATUS_DITOLAK  = 'ditolak';

    protected $fillable = [
        'user_id',
        'nama',
        'jabatan',
        'no_hp',
        'email',
        'status',
        'is_verified',
        'verified_by',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
            'verified_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function laporans(): HasMany
    {
        return $this->hasMany(Laporan::class);
    }

    /**
     * Admin yang memverifikasi akun karyawan ini.
     */
    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Akun karyawan boleh digunakan untuk login / diproses Bot WhatsApp
     * hanya jika sudah diverifikasi admin dan berstatus aktif.
     */
    public function isUsable(): bool
    {
        return $this->is_verified && $this->status === self::STATUS_AKTIF;
    }

    public function scopePending($q)
    {
        return $q->where('status', self::STATUS_PENDING);
    }

    public function scopeAktif($q)
    {
        return $q->where('status', self::STATUS_AKTIF);
    }

    public function scopeNonaktif($q)
    {
        return $q->where('status', self::STATUS_NONAKTIF);
    }

    public function scopeDitolak($q)
    {
        return $q->where('status', self::STATUS_DITOLAK);
    }
}
