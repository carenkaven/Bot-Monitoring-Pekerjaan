<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    /**
     * Daftar Karyawan
     */
    public function index()
    {
        $karyawans = Karyawan::latest()->paginate(10);

        return view('master.karyawan.index', compact('karyawans'));
    }

    /**
     * Form Tambah
     */
    public function create()
    {
        return view('master.karyawan.create');
    }

    /**
     * Simpan Karyawan (dibuat langsung oleh admin -> langsung aktif & terverifikasi)
     */
    public function store(Request $request)
    {
        $request->validate([

            'nama' => 'required|max:100',
            'jabatan' => 'required|max:100',
            'no_hp' => 'required|unique:karyawans,no_hp',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'status' => 'required|in:aktif,nonaktif',

        ]);

        DB::beginTransaction();

        try {

            $user = User::create([

                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'karyawan',

            ]);

            Karyawan::create([

                'user_id' => $user->id,
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'no_hp' => $request->no_hp,
                'email' => $request->email,
                'status' => $request->status,

                // Dibuat langsung oleh admin, jadi otomatis dianggap terverifikasi.
                'is_verified' => $request->status === Karyawan::STATUS_AKTIF,
                'verified_by' => $request->status === Karyawan::STATUS_AKTIF ? Auth::id() : null,
                'verified_at' => $request->status === Karyawan::STATUS_AKTIF ? now() : null,

            ]);

            DB::commit();

            return redirect()
                ->route('karyawan.index')
                ->with('success', 'Karyawan berhasil ditambahkan.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors($e->getMessage());

        }
    }

    /**
     * Detail
     */
    public function show(Karyawan $karyawan)
    {
        return view('master.karyawan.show', compact('karyawan'));
    }

    /**
     * Form Edit
     */
    public function edit(Karyawan $karyawan)
    {
        return view('master.karyawan.edit', compact('karyawan'));
    }

    /**
     * Update
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([

            'nama' => 'required|max:100',
            'jabatan' => 'required|max:100',
            'no_hp' => 'required|unique:karyawans,no_hp,' . $karyawan->id,
            'email' => 'required|email|unique:karyawans,email,' . $karyawan->id,
            'status' => 'required|in:aktif,nonaktif',

        ]);

        $karyawan->update([

            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'status' => $request->status,

        ]);

        if ($karyawan->user) {

            $karyawan->user->update([

                'name' => $request->nama,
                'email' => $request->email,

            ]);

        }

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Data berhasil diperbarui.');

    }

    /**
     * Verifikasi akun karyawan (pending -> aktif + is_verified)
     */
    public function approve(Karyawan $karyawan)
    {
        $karyawan->update([

            'status' => Karyawan::STATUS_AKTIF,
            'is_verified' => true,
            'verified_by' => Auth::id(),
            'verified_at' => now(),

        ]);

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Karyawan berhasil diverifikasi & diaktifkan.');

    }

    /**
     * Tolak pendaftaran akun karyawan
     */
    public function reject(Karyawan $karyawan)
    {
        $karyawan->update([

            'status' => Karyawan::STATUS_DITOLAK,
            'is_verified' => false,
            'verified_by' => Auth::id(),
            'verified_at' => now(),

        ]);

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Pendaftaran karyawan berhasil ditolak.');

    }

    /**
     * Nonaktifkan
     */
    public function nonaktif(Karyawan $karyawan)
    {

        $karyawan->update([

            'status' => Karyawan::STATUS_NONAKTIF,

        ]);

        return redirect()
            ->route('karyawan.index')
            ->with('success', 'Karyawan berhasil dinonaktifkan.');

    }

    /**
     * Hapus
     */
    public function destroy(Karyawan $karyawan)
    {
        if (Auth::id() === $karyawan->user_id) {
            return back()->withErrors('Anda tidak dapat menghapus akun Karyawan yang sedang Anda gunakan untuk login!');
        }

        DB::beginTransaction();

        try {
            // Hanya hapus user jika ada dan bukan admin
            if ($karyawan->user && $karyawan->user->role !== 'admin') {
                $karyawan->user->delete();
            }

            $karyawan->delete();

            DB::commit();

            return redirect()
                ->route('karyawan.index')
                ->with('success', 'Data berhasil dihapus.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withErrors($e->getMessage());

        }

    }

}
