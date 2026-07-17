<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterKaryawanController extends Controller
{
    /**
     * Tampilkan halaman register karyawan
     */
    public function create()
    {
        return view('auth.register-karyawan');
    }

    /**
     * Simpan registrasi karyawan
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:100',
            'jabatan'   => 'required|string|max:100',
            'no_hp'     => 'required|string|max:20|unique:karyawans,no_hp',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|confirmed|min:6',
        ]);

        DB::beginTransaction();

        try {

            // Buat akun user
            $user = User::create([
                'name'      => $request->nama,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'role'      => 'karyawan',
            ]);

            // Simpan data karyawan
            Karyawan::create([
                'user_id'     => $user->id,
                'nama'        => $request->nama,
                'jabatan'     => $request->jabatan,
                'no_hp'       => $request->no_hp,
                'email'       => $request->email,

                'status'      => Karyawan::STATUS_PENDING,
                'is_verified' => false,
            ]);

            DB::commit();

            return redirect()
                ->route('login')
                ->with('success', 'Registrasi berhasil. Menunggu persetujuan Administrator.');

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors([
                    'error' => $e->getMessage()
                ]);
        }
    }
}