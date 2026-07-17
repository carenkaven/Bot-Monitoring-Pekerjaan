<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $laporans = Laporan::with('karyawan')
            ->when($request->filled('q'), function ($q) use ($request) {
                $s = '%'.$request->string('q').'%';
                $q->where(function ($w) use ($s) {
                    $w->where('nama_proyek', 'like', $s)
                      ->orWhere('lokasi', 'like', $s)
                      ->orWhere('pic', 'like', $s)
                      ->orWhere('kegiatan', 'like', $s);
                });
            })
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->latest('tanggal')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('laporan.index', compact('laporans'));
    }

    public function create()
    {
        return view('laporan.create', [
            'karyawans' => Karyawan::aktif()->orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        Laporan::create($data);

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil disimpan.');
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

        return view('laporan.show', compact('laporan'));
    }

    public function edit(Laporan $laporan)
    {
        return view('laporan.edit', [
            'laporan'   => $laporan,
            'karyawans' => Karyawan::aktif()->orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, Laporan $laporan)
    {
        $laporan->update($this->validated($request));

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(Laporan $laporan)
    {
        $laporan->delete();

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'karyawan_id'   => 'required|exists:karyawans,id',
            'nama_proyek'   => 'required|string|max:150',
            'kegiatan'      => 'required|string|max:150',
            'sub_kegiatan'  => 'nullable|string|max:150',
            'pekerjaan'     => 'required|string|max:255',
            'lokasi'        => 'required|string|max:150',
            'kontraktor'    => 'nullable|string|max:150',
            'konsultan'     => 'nullable|string|max:150',
            'pic'           => 'nullable|string|max:100',
            'minggu_ke'     => 'nullable|string|max:20',
            'tanggal'       => 'required|date',
            'status'        => 'required|in:Menunggu,Disetujui,Ditolak',
            'catatan'       => 'nullable|string|max:1000',
        ]);
    }
}
