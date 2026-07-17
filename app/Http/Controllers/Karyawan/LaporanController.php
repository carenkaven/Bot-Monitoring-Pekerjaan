<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    /**
     * Laporan Saya: hanya laporan milik karyawan yang sedang login.
     */
    public function index(Request $request)
    {
        $karyawan = Auth::user()->karyawan;

        if (!$karyawan) {
            abort(403, 'Data karyawan tidak ditemukan.');
        }

        $laporans = Laporan::where('karyawan_id', $karyawan->id)
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->latest('tanggal')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('karyawan.laporan.index', compact('laporans'));
    }

    /**
     * Detail laporan - hanya boleh diakses jika laporan tersebut miliknya sendiri.
     */
    public function show(Laporan $laporan)
    {
        $karyawan = Auth::user()->karyawan;

        if (!$karyawan || $laporan->karyawan_id !== $karyawan->id) {
            abort(403, 'Anda tidak memiliki akses ke laporan ini.');
        }

        $laporan->load([
            'karyawan',
            'pekerjaans',
            'tenagas',
            'alats',
            'materials',
            'fotos',
            'verifikasi.user',
        ]);

        return view('karyawan.laporan.show', compact('laporan'));
    }
}
