<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\Karyawan;
use App\Models\Verifikasi;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi massal
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Kolom yang disembunyikan
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke data karyawan
     */
    public function karyawan()
    {
        return $this->hasOne(Karyawan::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isKaryawan(): bool
    {
        return $this->role === 'karyawan';
    }

    /**
     * Relasi verifikasi
     */
    public function verifikasis()
    {
        return $this->hasMany(Verifikasi::class);
    }
}