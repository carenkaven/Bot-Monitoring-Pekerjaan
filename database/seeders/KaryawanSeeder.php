<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['Budi Santoso', 'budi@monitoring.com', 'Mandor',    '081234567001'],
            ['Andi Wijaya',  'andi@monitoring.com', 'Pelaksana', '081234567002'],
            ['Sri Wahyuni',  'sri@monitoring.com',  'Pengawas',  '081234567003'],
            ['Rudi Hartono', 'rudi@monitoring.com', 'Mandor',    '081234567004'],
        ];

        foreach ($rows as [$nama, $email, $jabatan, $hp]) {
            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name'     => $nama,
                    'password' => Hash::make('password123'),
                    'role'     => 'karyawan',
                ],
            );

            Karyawan::updateOrCreate(
                ['no_hp' => $hp],
                [
                    'user_id'     => $user->id,
                    'nama'        => $nama,
                    'jabatan'     => $jabatan,
                    'email'       => $email,
                    'status'      => Karyawan::STATUS_AKTIF,
                    'is_verified' => true,
                    'verified_at' => now(),
                ],
            );
        }
    }
}
