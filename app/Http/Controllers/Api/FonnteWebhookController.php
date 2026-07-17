<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\Laporan;
use App\Models\LaporanAlat;
use App\Models\LaporanFoto;
use App\Models\LaporanMaterial;
use App\Models\LaporanPekerjaan;
use App\Models\LaporanTenaga;
use App\Services\FonnteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class FonnteWebhookController extends Controller
{
    public function __construct(
        protected FonnteService $fonnte,
    ) {
    }

    /**
     * Handle incoming webhook from Fonnte.
     */
    public function handle(Request $request): JsonResponse
    {
        $sender = $request->input('sender', '');
        $message = trim($request->input('message', ''));
        $name = $request->input('name', '');

        // Abaikan pesan dari grup
        if (Str::contains($sender, '-') || Str::contains($sender, '@g.us')) {
            return response()->json(['status' => 'ignored', 'reason' => 'group']);
        }

        if ($message === '') {
            return response()->json(['status' => 'ignored', 'reason' => 'empty']);
        }

        Log::info('Fonnte webhook received', [
            'sender' => $sender,
            'name' => $name,
            'message' => Str::limit($message, 200),
        ]);

        $upperMessage = Str::upper(Str::before($message, "\n"));

        // === Konversi Input Angka (Menu Utama) ===
        if ($upperMessage === '1') {
            $upperMessage = 'LAPOR';
        } elseif ($upperMessage === '2') {
            $upperMessage = 'STATUS';
        } elseif ($upperMessage === '3') {
            $upperMessage = 'BANTUAN';
        } elseif ($upperMessage === '0' || $upperMessage === '4') {
            $upperMessage = 'BATAL';
        }

        // === Cek State Percakapan Interaktif ===
        $stateKey = "lapor_state_{$sender}";
        if (Cache::has($stateKey)) {
            if ($upperMessage === 'BATAL' || $upperMessage === 'CANCEL') {
                Cache::forget($stateKey);
                $this->fonnte->sendMessage($sender, "❌ Pengisian laporan/proses dibatalkan.\n\nKetik *BANTUAN* untuk kembali ke Menu Utama.");
                return response()->json(['status' => 'ok', 'action' => 'cancel']);
            }
            $url = $request->input('url') ?? '';
            return $this->handleLaporStep($sender, $message, $name, $stateKey, $url);
        }

        // Kalau user belum ada state, tapi ngetik BATAL / reset
        if ($upperMessage === 'BATAL' || $upperMessage === 'CANCEL') {
            Cache::forget($stateKey);
            $this->fonnte->sendMessage($sender, "Sistem telah disegarkan (Reset). Memulai ulang... 🔄\n\n" . $this->helpMessage());
            return response()->json(['status' => 'ok', 'action' => 'cancel']);
        }

        // === Perintah: BANTUAN ===
        if ($upperMessage === 'BANTUAN' || $upperMessage === 'HELP') {
            $this->fonnte->sendMessage($sender, $this->helpMessage());
            return response()->json(['status' => 'ok', 'action' => 'bantuan']);
        }

        // === Perintah: PING / TEST ===
        if (in_array($upperMessage, ['TEST', 'PING', 'HALO', 'HAI', 'P', 'HI', 'ASSALAMUALAIKUM', 'PAGI', 'SIANG', 'SORE', 'MALAM'])) {
            $this->fonnte->sendMessage($sender, "Halo! 🤖 Bot WhatsApp Monitoring PKN aktif.\n\n" . $this->helpMessage());
            return response()->json(['status' => 'ok', 'action' => 'ping']);
        }

        // === Perintah: STATUS ===
        if ($upperMessage === 'STATUS') {
            return $this->handleStatus($sender);
        }

        // === Perintah: LAPOR ===
        if (Str::startsWith($upperMessage, 'LAPOR')) {
            // Kalau cuman "LAPOR" tanpa isi, mulai interaktif
            if (trim($upperMessage) === 'LAPOR') {
                Cache::put($stateKey, [
                    'step' => 'nama_proyek',
                    'data' => []
                ], now()->addMinutes(30));

                $this->fonnte->sendMessage($sender, "📝 *Form Laporan Interaktif*\nKetik *BATAL* kapan saja untuk menghentikan pengisian.\n\nMemulai... Silakan masukkan *Nama Proyek*:");
                return response()->json(['status' => 'ok', 'action' => 'lapor_start']);
            }
            // Kalau LAPOR format panjang, pakai format lama
            return $this->handleLapor($sender, $message, $name);
        }

        // Pesan tidak dikenal
        $this->fonnte->sendMessage($sender, "Maaf, perintah tidak dikenali.\n\n" . $this->helpMessage());
        return response()->json(['status' => 'ok', 'action' => 'unknown']);
    }

    /**
     * Handle perintah LAPOR.
     */
    protected function handleLapor(string $sender, string $message, string $senderName): JsonResponse
    {
        // Cari / auto-create karyawan
        $karyawan = $this->findOrCreateKaryawan($sender, $senderName);

        // Parse isi laporan dari pesan
        $report = $this->parseReport($message);

        // Validasi minimal
        $missing = [];
        if (empty($report['nama_proyek']))
            $missing[] = 'Nama Proyek';
        if (empty($report['kegiatan']))
            $missing[] = 'Kegiatan';
        if (empty($report['pekerjaan']))
            $missing[] = 'Pekerjaan';
        if (empty($report['lokasi']))
            $missing[] = 'Lokasi';

        if (!empty($missing)) {
            $this->fonnte->sendMessage(
                $sender,
                "❌ Laporan belum lengkap. Field berikut wajib diisi:\n• " .
                implode("\n• ", $missing) .
                "\n\n" . $this->contohFormat()
            );
            return response()->json(['status' => 'error', 'reason' => 'incomplete', 'missing' => $missing], 422);
        }

        // Simpan ke database
        try {
            $laporan = $this->saveLaporan($karyawan, $report);

            $reply = "✅ *Laporan berhasil disimpan!*\n\n"
                . "📋 Proyek: {$report['nama_proyek']}\n"
                . "📅 Tanggal: " . ($report['tanggal'] ?? now()->toDateString()) . "\n"
                . "📍 Lokasi: {$report['lokasi']}\n"
                . "📌 Status: Menunggu verifikasi\n"
                . "🆔 ID: #{$laporan->id}\n\n"
                . "Terima kasih. 🙏\n\n"
                . "---\n"
                . $this->helpMessage();

            $this->fonnte->sendMessage($sender, $reply);

            return response()->json([
                'status' => 'ok',
                'action' => 'laporan_saved',
                'laporan_id' => $laporan->id,
            ], 201);

        } catch (\Exception $e) {
            Log::error('Fonnte: gagal simpan laporan', [
                'sender' => $sender,
                'error' => $e->getMessage(),
            ]);

            $this->fonnte->sendMessage($sender, "❌ Terjadi kesalahan saat menyimpan laporan.\n\nSilakan coba lagi atau hubungi admin.");
            return response()->json(['status' => 'error', 'reason' => $e->getMessage()], 500);
        }
    }

    /**
     * Handle langkah laporan interaktif.
     */
    protected function handleLaporStep(string $sender, string $message, string $senderName, string $stateKey, string $url = ''): JsonResponse
    {
        $state = Cache::get($stateKey);
        $step = $state['step'];
        $data = $state['data'];

        $val = trim($message);
        if ($val === '-')
            $val = '';

        if ($step === 'foto') {
            $data['foto_url'] = $url;
            $data['foto_keterangan'] = $val;
        } else {
            $data[$step] = $val;
        }

        $nextStep = match ($step) {
            'nama_proyek' => 'kegiatan',
            'kegiatan' => 'sub_kegiatan',
            'sub_kegiatan' => 'pekerjaan',
            'pekerjaan' => 'lokasi',
            'lokasi' => 'kontraktor',
            'kontraktor' => 'konsultan',
            'konsultan' => 'minggu_ke',
            'minggu_ke' => 'tenaga',
            'tenaga' => 'material',
            'material' => 'alat',
            'alat' => 'catatan',
            'catatan' => 'foto',
            'foto' => 'done',
            default => 'done',
        };

        if ($nextStep === 'done') {
            Cache::forget($stateKey);
            $karyawan = $this->findOrCreateKaryawan($sender, $senderName);
            $data['tanggal'] = now()->toDateString();

            try {
                $laporan = $this->saveLaporan($karyawan, $data);
                $reply = "✅ *Laporan berhasil disimpan!*\n\n"
                    . "📋 Proyek: {$data['nama_proyek']}\n"
                    . "📅 Tanggal: {$data['tanggal']}\n"
                    . "📍 Lokasi: {$data['lokasi']}\n"
                    . "📌 Status: Menunggu verifikasi\n"
                    . "🆔 ID: #{$laporan->id}\n\n"
                    . "Terima kasih atas laporan Anda. 🙏\n\n"
                    . "---\n"
                    . $this->helpMessage();

                $this->fonnte->sendMessage($sender, $reply);
                return response()->json(['status' => 'ok', 'action' => 'laporan_saved']);
            } catch (\Exception $e) {
                Log::error('Fonnte: gagal simpan laporan interaktif', ['sender' => $sender, 'error' => $e->getMessage()]);
                $this->fonnte->sendMessage($sender, "❌ Terjadi kesalahan saat menyimpan laporan.\n\nSilakan coba lagi atau hubungi admin.");
                return response()->json(['status' => 'error'], 500);
            }
        }

        $state['step'] = $nextStep;
        $state['data'] = $data;
        Cache::put($stateKey, $state, now()->addMinutes(30));

        $prompts = [
            'kegiatan' => "Sip! Sekarang masukkan *Kegiatan* yang dikerjakan:",
            'sub_kegiatan' => "Lanjut, apa *Sub Kegiatan*-nya?\nKetik *-* jika tidak ada/kosong:",
            'pekerjaan' => "Lanjut, masukkan detail *Pekerjaan*:",
            'lokasi' => "Di mana *Lokasi* pekerjaannya?",
            'kontraktor' => "Siapa *Kontraktor* pelaksana?\nKetik *-* jika tidak ada/kosong:",
            'konsultan' => "Siapa *Konsultan* pengawas?\nKetik *-* jika tidak ada/kosong:",
            'minggu_ke' => "Pekerjaan *Minggu Ke* berapa? (Contoh: 1)\nKetik *-* jika tidak ada/kosong:",
            'tenaga' => "Berapa *Tenaga Kerja* yang turun? (Contoh: pekerja=8, tukang=2)\nKetik *-* jika tidak ada/kosong:",
            'material' => "Apa saja *Material* yang dipakai? (Contoh: Semen|20|sak)\nKetik *-* jika tidak ada/kosong:",
            'alat' => "Apa *Alat* yang digunakan? (Contoh: Vibrator|2)\nKetik *-* jika tidak ada/kosong:",
            'catatan' => "Tuliskan *Catatan* (cuaca/kendala di lapangan).\nKetik *-* jika tidak ada/kosong:",
            'foto' => "Terakhir, silakan kirimkan *1 Foto Dokumentasi*.\nTuliskan keterangan foto pada pesan/caption jika perlu.\n\nKetik *-* jika belum ada foto atau untuk melewati:",
        ];

        $this->fonnte->sendMessage($sender, $prompts[$nextStep]);
        return response()->json(['status' => 'ok', 'step' => $nextStep]);
    }

    /**
     * Handle perintah STATUS.
     */
    protected function handleStatus(string $sender): JsonResponse
    {
        $karyawan = $this->findKaryawanByPhone($sender);

        if (!$karyawan) {
            $this->fonnte->sendMessage($sender, "Nomor Anda belum terdaftar sebagai karyawan.\n\nSilakan hubungi admin.\n\n---\n" . $this->helpMessage());
            return response()->json(['status' => 'ok', 'action' => 'status_not_found']);
        }

        $laporans = Laporan::where('karyawan_id', $karyawan->id)
            ->latest('tanggal')
            ->take(5)
            ->get();

        if ($laporans->isEmpty()) {
            $this->fonnte->sendMessage($sender, "Belum ada laporan yang tercatat untuk Anda.\n\n---\n" . $this->helpMessage());
            return response()->json(['status' => 'ok', 'action' => 'status_empty']);
        }

        $text = "📊 *5 Laporan Terakhir Anda:*\n\n";
        foreach ($laporans as $i => $lap) {
            $emoji = match ($lap->status) {
                Laporan::STATUS_DISETUJUI => '✅',
                Laporan::STATUS_DITOLAK => '❌',
                default => '⏳',
            };
            $text .= ($i + 1) . ". {$emoji} {$lap->nama_proyek}\n"
                . "   📅 {$lap->tanggal->format('d M Y')} — {$lap->status}\n\n";
        }

        $text .= "---\n" . $this->helpMessage();

        $this->fonnte->sendMessage($sender, $text);
        return response()->json(['status' => 'ok', 'action' => 'status']);
    }

    /**
     * Parse pesan LAPOR menjadi array report.
     */
    protected function parseReport(string $message): array
    {
        $report = [];

        foreach (preg_split('/\R+/', $message) ?: [] as $line) {
            // Skip baris pertama "LAPOR"
            if (Str::upper(trim($line)) === 'LAPOR')
                continue;

            if (!str_contains($line, ':'))
                continue;

            [$label, $value] = array_map('trim', explode(':', $line, 2));
            $field = $this->mapLabelToField($label);

            if ($field && $value !== '') {
                $report[$field] = $value;
            }
        }

        // Default tanggal = hari ini
        if (empty($report['tanggal'])) {
            $report['tanggal'] = now()->toDateString();
        }

        return $report;
    }

    /**
     * Map label teks ke field database.
     */
    protected function mapLabelToField(string $label): ?string
    {
        $key = Str::of($label)
            ->lower()
            ->replace(['_', '-'], ' ')
            ->squish()
            ->toString();

        return [
            'proyek' => 'nama_proyek',
            'nama proyek' => 'nama_proyek',
            'nama proyek pekerjaan' => 'nama_proyek',
            'kegiatan' => 'kegiatan',
            'sub kegiatan' => 'sub_kegiatan',
            'pekerjaan' => 'pekerjaan',
            'lokasi' => 'lokasi',
            'kontraktor' => 'kontraktor',
            'konsultan' => 'konsultan',
            'pic' => 'pic',
            'minggu' => 'minggu_ke',
            'minggu ke' => 'minggu_ke',
            'tanggal' => 'tanggal',
            'catatan' => 'catatan',
            'tenaga' => 'tenaga',
            'material' => 'material',
            'alat' => 'alat',
        ][$key] ?? null;
    }

    /**
     * Simpan laporan ke database.
     */
    protected function saveLaporan(Karyawan $karyawan, array $report): Laporan
    {
        return DB::transaction(function () use ($karyawan, $report) {
            $laporan = Laporan::create([
                'karyawan_id' => $karyawan->id,
                'nama_proyek' => $report['nama_proyek'],
                'kegiatan' => $report['kegiatan'],
                'sub_kegiatan' => $report['sub_kegiatan'] ?? null,
                'pekerjaan' => $report['pekerjaan'],
                'lokasi' => $report['lokasi'],
                'kontraktor' => $report['kontraktor'] ?? null,
                'konsultan' => $report['konsultan'] ?? null,
                'pic' => $report['pic'] ?? null,
                'minggu_ke' => $report['minggu_ke'] ?? null,
                'tanggal' => Carbon::parse($report['tanggal'])->toDateString(),
                'status' => Laporan::STATUS_MENUNGGU,
                'catatan' => $report['catatan'] ?? null,
            ]);

            // Pekerjaan detail
            LaporanPekerjaan::create([
                'laporan_id' => $laporan->id,
                'nama_pekerjaan' => $report['pekerjaan'],
            ]);

            // Tenaga kerja
            if (!empty($report['tenaga'])) {
                $tenaga = $this->parseTenaga($report['tenaga']);
                if (!empty($tenaga)) {
                    LaporanTenaga::create([
                        'laporan_id' => $laporan->id,
                        'pekerja' => $tenaga['pekerja'] ?? 0,
                        'tukang' => $tenaga['tukang'] ?? 0,
                        'mandor' => $tenaga['mandor'] ?? 0,
                        'pelaksana' => $tenaga['pelaksana'] ?? 0,
                    ]);
                }
            }

            // Material
            if (!empty($report['material'])) {
                foreach ($this->parseMaterials($report['material']) as $material) {
                    LaporanMaterial::create([
                        'laporan_id' => $laporan->id,
                        'nama_material' => $material['nama_material'],
                        'volume' => $material['volume'],
                        'satuan' => $material['satuan'],
                    ]);
                }
            }

            // Alat
            if (!empty($report['alat'])) {
                foreach ($this->parseAlats($report['alat']) as $alat) {
                    LaporanAlat::create([
                        'laporan_id' => $laporan->id,
                        'nama_alat' => $alat['nama_alat'],
                        'jumlah' => $alat['jumlah'],
                    ]);
                }
            }

            // Foto
            if (!empty($report['foto_url'])) {
                LaporanFoto::create([
                    'laporan_id' => $laporan->id,
                    'foto' => $report['foto_url'],
                    'keterangan' => $report['foto_keterangan'] ?: 'Tidak ada keterangan',
                ]);
            }

            return $laporan;
        });
    }

    /**
     * Parse tenaga: "pekerja=8, tukang=4, mandor=1, pelaksana=1"
     */
    protected function parseTenaga(string $value): array
    {
        preg_match_all('/(pekerja|tukang|mandor|pelaksana)\s*[:=]\s*(\d+)/i', $value, $matches, PREG_SET_ORDER);

        $tenaga = [];
        foreach ($matches as $match) {
            $tenaga[Str::lower($match[1])] = (int) $match[2];
        }

        return $tenaga;
    }

    /**
     * Parse material: "Semen Portland|20|sak; Pasir Beton|3|m3"
     */
    protected function parseMaterials(string $value): array
    {
        return collect(array_filter(array_map('trim', explode(';', $value))))
            ->map(function (string $item) {
                $parts = array_map('trim', explode('|', $item));
                if (count($parts) < 3)
                    return null;
                return [
                    'nama_material' => $parts[0],
                    'volume' => (float) str_replace(',', '.', $parts[1]),
                    'satuan' => $parts[2],
                ];
            })
            ->filter()
            ->values()
            ->all();
    }

    /**
     * Parse alat: "Concrete Mixer|1; Vibrator|2"
     */
    protected function parseAlats(string $value): array
    {
        return collect(array_filter(array_map('trim', explode(';', $value))))
            ->map(function (string $item) {
                $parts = array_map('trim', explode('|', $item));
                return [
                    'nama_alat' => $parts[0] ?? null,
                    'jumlah' => isset($parts[1]) ? (int) $parts[1] : 1,
                ];
            })
            ->filter(fn($item) => $item['nama_alat'])
            ->values()
            ->all();
    }

    /**
     * Cari karyawan berdasarkan nomor HP, atau buat baru.
     */
    protected function findOrCreateKaryawan(string $phone, string $senderName): Karyawan
    {
        $karyawan = $this->findKaryawanByPhone($phone);

        if (!$karyawan) {
            $karyawan = Karyawan::create([
                'nama' => $senderName ?: ('Pengguna WA (' . $this->normalizePhone($phone) . ')'),
                'no_hp' => $this->normalizePhone($phone),
                'jabatan' => 'Staff',
                'status' => 'aktif',
                'is_verified' => true,
            ]);
        } elseif (!$karyawan->isUsable()) {
            $karyawan->update([
                'status' => 'aktif',
                'is_verified' => true,
            ]);
        }

        return $karyawan;
    }

    protected function findKaryawanByPhone(string $phone): ?Karyawan
    {
        $normalized = $this->normalizePhone($phone);

        return Karyawan::query()
            ->whereNotNull('no_hp')
            ->get()
            ->first(fn(Karyawan $k) => $this->normalizePhone($k->no_hp) === $normalized);
    }

    protected function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?: '';

        if (str_starts_with($digits, '62')) {
            return '0' . substr($digits, 2);
        }

        if (str_starts_with($digits, '8')) {
            return '0' . $digits;
        }

        return $digits;
    }

    protected function helpMessage(): string
    {
        return "🤖 *Silakan pilih menu dengan membalas angka:*\n\n"
            . "*[1]* 📝 Isi Laporan Harian (Interaktif)\n"
            . "*[2]* ℹ️ Cek Status Laporan Terakhir\n"
            . "*[3]* 💡 Bantuan / Panduan Lengkap\n"
            . "*[0]* 🔄 Batal / Buat Ulang Percakapan";
    }

    protected function contohFormat(): string
    {
        return "📝 *Format Laporan:*\n\n"
            . "```\n"
            . "LAPOR\n"
            . "Nama Proyek: Pembangunan Jalan\n"
            . "Kegiatan: Pekerjaan Beton\n"
            . "Sub Kegiatan: Rigid Pavement\n"
            . "Pekerjaan: Pengecoran\n"
            . "Lokasi: Jl. Raya Tlogomas\n"
            . "Tanggal: 2026-07-17\n"
            . "Minggu Ke: 1\n"
            . "Tenaga: pekerja=8, tukang=4, mandor=1\n"
            . "Material: Semen|20|sak; Pasir|3|m3\n"
            . "Alat: Concrete Mixer|1; Vibrator|2\n"
            . "Catatan: Cuaca cerah\n"
            . "```";
    }
}
