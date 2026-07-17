<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id',
        'nama_proyek',
        'kegiatan',
        'sub_kegiatan',
        'pekerjaan',
        'lokasi',
        'kontraktor',
        'konsultan',
        'pic',
        'minggu_ke',
        'tanggal',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public const STATUS_MENUNGGU  = 'Menunggu';
    public const STATUS_DISETUJUI = 'Disetujui';
    public const STATUS_DITOLAK   = 'Ditolak';

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function pekerjaans(): HasMany
    {
        return $this->hasMany(LaporanPekerjaan::class);
    }

    public function tenagas(): HasMany
    {
        return $this->hasMany(LaporanTenaga::class);
    }

    public function alats(): HasMany
    {
        return $this->hasMany(LaporanAlat::class);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(LaporanMaterial::class);
    }

    public function fotos(): HasMany
    {
        return $this->hasMany(LaporanFoto::class);
    }

    public function verifikasi(): HasOne
    {
        return $this->hasOne(Verifikasi::class);
    }

    public function scopeMenunggu($q)   { return $q->where('status', self::STATUS_MENUNGGU); }
    public function scopeDisetujui($q)  { return $q->where('status', self::STATUS_DISETUJUI); }
    public function scopeDitolak($q)    { return $q->where('status', self::STATUS_DITOLAK); }
}
