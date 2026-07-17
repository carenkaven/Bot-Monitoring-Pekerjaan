<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Verifikasi;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index(Request $request)
    {
        $laporans = Laporan::with('karyawan')
            ->menunggu()
            ->when($request->filled('q'), function ($q) use ($request) {
                $s = '%'.$request->string('q').'%';
                $q->where(fn ($w) => $w->where('nama_proyek', 'like', $s)
                    ->orWhere('lokasi', 'like', $s)
                    ->orWhere('pic', 'like', $s));
            })
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('verifikasi.index', compact('laporans'));
    }

    public function show(Laporan $laporan)
    {
        $laporan->load([
            'karyawan',
            'pekerjaans',
            'tenagas',
            'alats',
            'materials',
            'fotos',
            'verifikasi.user',
        ]);

        return view('verifikasi.show', compact('laporan'));
    }

    public function setujui(Laporan $laporan)
    {
        abort_unless($laporan->status === Laporan::STATUS_MENUNGGU, 422, 'Laporan sudah diverifikasi.');

        $laporan->update(['status' => Laporan::STATUS_DISETUJUI]);

        Verifikasi::updateOrCreate(
            ['laporan_id' => $laporan->id],
            [
                'user_id'            => auth()->id(),
                'status'             => Laporan::STATUS_DISETUJUI,
                'catatan'            => 'Laporan disetujui',
                'tanggal_verifikasi' => now(),
            ],
        );

        return redirect()->route('verifikasi.index')->with('success', 'Laporan berhasil disetujui.');
    }

    public function tolak(Request $request, Laporan $laporan)
    {
        abort_unless($laporan->status === Laporan::STATUS_MENUNGGU, 422, 'Laporan sudah diverifikasi.');

        $request->validate([
            'catatan' => 'required|string|max:500',
        ]);

        $laporan->update([
            'status'  => Laporan::STATUS_DITOLAK,
            'catatan' => $request->string('catatan'),
        ]);

        Verifikasi::updateOrCreate(
            ['laporan_id' => $laporan->id],
            [
                'user_id'            => auth()->id(),
                'status'             => Laporan::STATUS_DITOLAK,
                'catatan'            => $request->string('catatan'),
                'tanggal_verifikasi' => now(),
            ],
        );

        return redirect()->route('verifikasi.index')->with('success', 'Laporan berhasil ditolak.');
    }

    public function riwayat(Request $request)
    {
        $laporans = Laporan::with(['karyawan', 'verifikasi.user'])
            ->whereIn('status', [Laporan::STATUS_DISETUJUI, Laporan::STATUS_DITOLAK])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('verifikasi.riwayat', compact('laporans'));
    }
}
