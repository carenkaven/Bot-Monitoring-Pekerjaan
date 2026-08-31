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
        $mediaUrl = trim($request->input('url', ''));
        $name = $request->input('name', '');

        if ($mediaUrl !== '') {
            $mediaUrl = $this->fonnte->downloadMedia($mediaUrl);
        }

        // Abaikan pesan dari grup
        if (Str::contains($sender, '-') || Str::contains($sender, '@g.us')) {
            return response()->json(['status' => 'ignored', 'reason' => 'group']);
        }

        if ($message === '' && $mediaUrl === '') {
            return response()->json(['status' => 'ignored', 'reason' => 'empty']);
        }


        Log::info('Fonnte webhook FULL payload', $request->all());

        Log::info('Fonnte webhook received', [
            'sender' => $sender,
            'name' => $name,
            'message' => Str::limit($message, 200),
        ]);

        $upperMessage = Str::upper(trim(Str::before($message, "\n")));

        // === Cek State Navigasi Selesai Laporan ===
        $navigasiKey = "navigasi_{$sender}";
        if (Cache::has($navigasiKey)) {
            if ($upperMessage === '1') {
                Cache::forget($navigasiKey);
                $upperMessage = 'BANTUAN';
            } elseif ($upperMessage === '2') {
                Cache::forget($navigasiKey);
                $upperMessage = 'LAPOR';
            } elseif ($upperMessage === '3') {
                Cache::forget($navigasiKey);
                $this->fonnte->sendMessage($sender, "Terima kasih, sesi telah diakhiri. Semoga hari Anda menyenangkan!");
                return response()->json(['status' => 'ok', 'action' => 'selesai_navigasi']);
            } else {
                $this->fonnte->sendMessage($sender, "Pilihan tidak valid. Silakan balas 1, 2, atau 3.\n\n1. Kembali ke Menu Utama\n2. Buat Laporan Baru\n3. Selesai");
                return response()->json(['status' => 'ok', 'action' => 'invalid_navigasi']);
            }
        }

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
        $stateKey = "foto_laporan_{$sender}";
        if (Cache::has($stateKey)) {
            return $this->handleFotoUpload($sender, $message, $mediaUrl, $stateKey);
        }

        // === Perintah: BANTUAN ===
        if ($upperMessage === 'BANTUAN' || $upperMessage === 'HELP') {
            $this->fonnte->sendMessage($sender, $this->helpMessage());
            return response()->json(['status' => 'ok', 'action' => 'bantuan']);
        }

        // === Perintah: PING / TEST ===
        if (in_array($upperMessage, ['TEST', 'PING', 'HALO', 'HAI', 'P', 'HI', 'ASSALAMUALAIKUM', 'PAGI', 'SIANG', 'SORE', 'MALAM'])) {
            $this->fonnte->sendMessage($sender, "Halo! Sistem WhatsApp Monitoring aktif.\n\n" . $this->helpMessage());
            return response()->json(['status' => 'ok', 'action' => 'ping']);
        }

        // === Perintah: STATUS ===
        if ($upperMessage === 'STATUS') {
            return $this->handleStatus($sender);
        }

        $isReportFormat = preg_match('/^\s*LAPORAN HARIAN/mi', $message)
            || (preg_match('/^\s*Tanggal\s*:/mi', $message) && preg_match('/^\s*Pekerjaan\s*:/mi', $message));

        // === Perintah: LAPOR ===
        if (Str::startsWith($upperMessage, 'LAPOR') || $isReportFormat) {
            if (trim($upperMessage) === 'LAPOR' && !$isReportFormat) {
                $template = "*FORM LAPORAN HARIAN*\n\n"
                    . "Silakan salin format berikut, isi datanya, lalu kirim kembali dalam SATU pesan (boleh disertai foto).\n\n"
                    . "==============================\n\n"
                    . "LAPORAN HARIAN\n\n"
                    . "Pekerjaan :\n"
                    . "Lokasi :\n"
                    . "Tanggal :\n"
                    . "Minggu Ke :\n"
                    . "Kontraktor Pelaksana :\n"
                    . "Konsultan Pengawas :\n\n"
                    . "Pekerjaan Yang Dilakukan :\n"
                    . "- \n"
                    . "- \n\n"
                    . "Bahan / Material :\n"
                    . "- \n"
                    . "- \n\n"
                    . "Tenaga Kerja :\n"
                    . "Pekerja = \n"
                    . "Tukang = \n"
                    . "Mandor = \n"
                    . "Pelaksana = \n\n"
                    . "Alat :\n"
                    . "- \n"
                    . "- \n\n"
                    . "Jam Kerja :\n"
                    . "Cuaca :\n\n"
                    . "Kendala :\n\n"
                    . "Keterangan :\n\n"
                    . "Catatan / Progress :\n";

                $this->fonnte->sendMessage($sender, $template);
                return response()->json(['status' => 'ok', 'action' => 'lapor_start']);
            }

            // Format laporan (dari template atau langsung)
            return $this->handleLapor($sender, $message, $name, $mediaUrl);
        }

        // Pesan tidak dikenal
        $this->fonnte->sendMessage($sender, "Maaf, perintah tidak dikenali.\n\n" . $this->helpMessage());
        return response()->json(['status' => 'ok', 'action' => 'unknown']);
    }

    /**
     * Handle perintah LAPOR.
     */
    protected function handleLapor(string $sender, string $message, string $senderName, string $mediaUrl = ''): JsonResponse
    {
        // Cari / auto-create karyawan
        $karyawan = $this->findOrCreateKaryawan($sender, $senderName);

        // Parse isi laporan dari pesan
        $report = $this->parseReport($message);

        // Validasi minimal
        $missing = [];
        if (empty($report['pekerjaan']))
            $missing[] = 'Pekerjaan';
        if (empty($report['lokasi']))
            $missing[] = 'Lokasi';

        if (!empty($missing)) {
            $this->fonnte->sendMessage(
                $sender,
                "Laporan belum lengkap. Field berikut wajib diisi:\n- " .
                implode("\n- ", $missing) .
                "\n\n" . $this->contohFormat()
            );
            return response()->json(['status' => 'error', 'reason' => 'incomplete', 'missing' => $missing], 422);
        }

        $initialPhotoCount = 0;
        if ($mediaUrl !== '') {
            $report['fotos'][] = ['url' => $mediaUrl, 'keterangan' => 'Foto Laporan'];
            $initialPhotoCount = 1;
        }

        // Simpan ke database
        try {
            $laporan = $this->saveLaporan($karyawan, $report);

            if ($initialPhotoCount === 1) {
                $reply = "Laporan berhasil diterima beserta 1 foto.\n\n"
                    . "Selanjutnya silakan kirim foto dokumentasi berikutnya (Maksimal 3 foto).\n\n"
                    . "Foto dapat dikirim satu per satu atau sekaligus.\n"
                    . "Jika tidak ada dokumentasi tambahan, balas dengan angka:\n"
                    . "0";
            } else {
                $reply = "Laporan berhasil diterima.\n\n"
                    . "Selanjutnya silakan kirim maksimal 3 foto dokumentasi pekerjaan.\n\n"
                    . "Foto dapat dikirim satu per satu atau sekaligus.\n"
                    . "Jika tidak ada dokumentasi, balas dengan angka:\n"
                    . "0";
            }

            // Set state for photo uploads
            Cache::put("foto_laporan_{$sender}", [
                'laporan_id' => $laporan->id,
                'count' => $initialPhotoCount
            ], now()->addHours(1));

            $this->fonnte->sendMessage($sender, $reply);

            return response()->json([
                'status' => 'ok',
                'action' => 'laporan_saved_waiting_foto',
                'laporan_id' => $laporan->id,
            ], 201);

        } catch (\Exception $e) {
            Log::error('Fonnte: gagal simpan laporan', [
                'sender' => $sender,
                'error' => $e->getMessage(),
            ]);

            $this->fonnte->sendMessage($sender, "Terjadi kesalahan saat menyimpan laporan.\n\nSilakan coba lagi atau hubungi admin.");
            return response()->json(['status' => 'error', 'reason' => $e->getMessage()], 500);
        }
    }

    /**
     * Selesaikan sesi laporan dan tampilkan menu navigasi.
     */
    protected function endReportSession(string $sender, string $stateKey, string $pesanSelesai): JsonResponse
    {
        Cache::forget($stateKey);
        
        $menu = $pesanSelesai . "\n\nSilakan pilih menu berikut:\n\n1. Kembali ke Menu Utama\n2. Buat Laporan Baru\n3. Selesai";
        $this->fonnte->sendMessage($sender, $menu);
        
        Cache::put("navigasi_{$sender}", true, now()->addHours(1));
        
        return response()->json(['status' => 'ok', 'action' => 'done_report_menu']);
    }

    /**
     * Handle upload foto dokumentasi laporan.
     */
    protected function handleFotoUpload(string $sender, string $message, string $mediaUrl, string $stateKey): JsonResponse
    {
        $state = Cache::get($stateKey);
        $laporanId = $state['laporan_id'];
        $count = $state['count'];
        
        $val = trim(Str::upper($message));

        if ($val === '0' && $count === 0) {
            return $this->endReportSession($sender, $stateKey, "Laporan berhasil disimpan tanpa dokumentasi foto.");
        }

        if ($val === '0' || $val === 'SELESAI') {
            return $this->endReportSession($sender, $stateKey, "Dokumentasi berhasil disimpan. Terima kasih, laporan telah selesai.");
        }

        if ($mediaUrl !== '') {
            LaporanFoto::create([
                'laporan_id' => $laporanId,
                'foto' => $mediaUrl,
                'keterangan' => $message ?: 'Foto Dokumentasi',
            ]);

            $count++;
            
            if ($count >= 3) {
                Cache::forget('foto_reply_pending_' . $sender);
                return $this->endReportSession($sender, $stateKey, "Informasi: 3 foto telah diterima.\n\nDokumentasi berhasil disimpan. Terima kasih, laporan telah selesai.");
            } else {
                $state['count'] = $count;
                Cache::put($stateKey, $state, now()->addHours(1));
                
                Cache::put('foto_reply_pending_' . $sender, $count, now()->addMinutes(1));
                \App\Jobs\SendFotoReplyJob::dispatch($sender, $count)->delay(now()->addSeconds(3));
                
                return response()->json(['status' => 'ok', 'action' => 'foto_received_delayed', 'count' => $count]);
            }
        }

        // Kalau bukan '0' dan tidak ada foto
        $this->fonnte->sendMessage($sender, "Mohon kirimkan foto dokumentasi, atau balas 0 untuk mengakhiri.");
        return response()->json(['status' => 'ok', 'action' => 'wait_foto']);
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

        $text = "*5 Laporan Terakhir Anda:*\n\n";
        foreach ($laporans as $lap) {
            $statusEmoji = match ($lap->status) {
                Laporan::STATUS_DISETUJUI => '[Disetujui]',
                Laporan::STATUS_DITOLAK => '[Ditolak]',
                default => '[Menunggu]',
            };

            $text .= "• Proyek: {$lap->nama_proyek}\n"
                . "   Tanggal: {$lap->tanggal->format('d M Y')} — {$statusEmoji}\n\n";
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
        $section = 'general';
        $currentMaterial = [];
        $currentAlat = [];
        
        $materials = [];
        $alats = [];
        $pekerjaanYangDilakukan = [];

        foreach (preg_split('/\R+/', $message) ?: [] as $line) {
            $lineTrim = trim($line);
            if (empty($lineTrim)) continue;

            $lowerLine = Str::lower($lineTrim);
            
            // Detect sections
            if (preg_match('/^pekerjaan\s+yang\s+dilakukan\s*:?/i', $lineTrim)) {
                $section = 'pekerjaan';
                continue;
            } elseif (preg_match('/^(?:bahan|material)(?:\s*\/\s*(?:bahan|material))?\s*:?/i', $lineTrim)) {
                $section = 'material';
                if (!empty($currentMaterial)) $materials[] = $currentMaterial;
                $currentMaterial = [];
                continue;
            } elseif (preg_match('/^(?:per)?alat(?:an)?\s*:?/i', $lineTrim)) {
                $section = 'alat';
                if (!empty($currentAlat)) $alats[] = $currentAlat;
                $currentAlat = [];
                continue;
            } elseif (preg_match('/^tenaga\s+kerja\s*:?/i', $lineTrim)) {
                $section = 'tenaga';
                continue;
            } elseif (preg_match('/^kendala\s*:?/i', $lineTrim)) {
                $section = 'kendala';
                $lineTrim = trim(preg_replace('/^kendala\s*:?/i', '', $lineTrim));
                if ($lineTrim === '') continue;
            } elseif (preg_match('/^keterangan\s*:?/i', $lineTrim)) {
                $section = 'keterangan';
                $lineTrim = trim(preg_replace('/^keterangan\s*:?/i', '', $lineTrim));
                if ($lineTrim === '') continue;
            } elseif (preg_match('/^(catatan(?:\s*\/\s*progress)?|progress)\s*:?/i', $lineTrim)) {
                $section = 'catatan_progress';
                $lineTrim = trim(preg_replace('/^(catatan(?:\s*\/\s*progress)?|progress)\s*:?/i', '', $lineTrim));
                if ($lineTrim === '') continue;
            }

            // Parse based on section
            $hasColon = str_contains($lineTrim, ':');
            if (!$hasColon && str_contains($lineTrim, '=')) {
                $hasColon = true;
                $lineTrim = str_replace('=', ':', $lineTrim);
            }
            
            // Prevent taking over valid general fields
            if ($hasColon && in_array($section, ['kendala', 'keterangan', 'catatan', 'progress', 'catatan_progress', 'pekerjaan', 'material', 'alat', 'tenaga'])) {
                $testLabel = explode(':', $lineTrim, 2)[0];
                if ($this->mapLabelToField(trim(preg_replace('/^[\-\d\.]+\s*/', '', $testLabel)))) {
                    $section = 'general';
                }
            }

            if (in_array($section, ['kendala', 'keterangan', 'catatan', 'progress', 'catatan_progress'])) {
                $targetField = in_array($section, ['progress', 'catatan_progress', 'catatan']) ? 'catatan' : $section;
                
                if (in_array($section, ['progress', 'catatan_progress'])) {
                    if (preg_match('/(?:progress|mencapai)[^:]*?:?\s*([\d,\.]+)\s*%/i', $lineTrim, $matches)) {
                        if (stripos($lineTrim, 'harian') === false && stripos($lineTrim, 'target') === false) {
                            $report['progress'] = (int) str_replace(',', '.', $matches[1]);
                        }
                    }
                }

                $report[$targetField] = isset($report[$targetField]) ? $report[$targetField] . "\n" . $lineTrim : $lineTrim;
                continue;
            }

            if ($section === 'pekerjaan') {
                $pekerjaanYangDilakukan[] = preg_replace('/^[\-\*\d\.]+\s*/', '', $lineTrim);
                continue;
            }

            if ($hasColon) {
                [$label, $value] = array_map('trim', explode(':', $lineTrim, 2));
                $labelClean = preg_replace('/^[\-\d\.]+\s*/', '', $label); // remove list hyphen and numbers
                $labelClean = trim($labelClean);
                $value = trim($value);

                if ($section === 'material') {
                    $lowerLabel = strtolower($labelClean);
                    if ($lowerLabel === 'nama material' || $lowerLabel === 'material') {
                        if (!empty($currentMaterial)) $materials[] = $currentMaterial; // push previous
                        $currentMaterial = ['nama_material' => $value, 'volume' => 0, 'satuan' => 'ls'];
                    } elseif ($lowerLabel === 'volume') {
                        $currentMaterial['volume'] = (float) str_replace(',', '.', $value);
                    } elseif ($lowerLabel === 'satuan') {
                        $currentMaterial['satuan'] = $value;
                    } else {
                        // Label is not a standard keyword, treat as "Name : Volume Unit"
                        $nama = preg_replace('/^[\-\*\d\.]+\s*/', '', $label); // strip leading bullets
                        $vol = 1;
                        $sat = 'ls';
                        if (preg_match('/^([\d,\.]+)\s*(.*)$/', $value, $m)) {
                            $vol = (float) str_replace(',', '.', $m[1]);
                            $sat = trim($m[2]) ?: 'ls';
                        }
                        if (!empty($currentMaterial)) $materials[] = $currentMaterial;
                        $currentMaterial = ['nama_material' => trim($nama), 'volume' => $vol, 'satuan' => $sat];
                    }
                } elseif ($section === 'alat') {
                    $lowerLabel = strtolower($labelClean);
                    if ($lowerLabel === 'nama alat' || $lowerLabel === 'alat') {
                        if (!empty($currentAlat)) $alats[] = $currentAlat; // push previous
                        $currentAlat = ['nama_alat' => $value, 'jumlah' => 1];
                    } elseif ($lowerLabel === 'jumlah') {
                        $currentAlat['jumlah'] = (int) $value;
                    } else {
                        // Label is not a standard keyword, treat as "Name : Jumlah Unit"
                        $nama = preg_replace('/^[\-\*\d\.]+\s*/', '', $label); // strip leading bullets
                        $jum = 1;
                        if (preg_match('/^([\d,\.]+)\s*(.*)$/', $value, $m)) {
                            $jum = (int) str_replace(',', '.', $m[1]);
                        }
                        if (!empty($currentAlat)) $alats[] = $currentAlat;
                        $currentAlat = ['nama_alat' => trim($nama), 'jumlah' => $jum];
                    }
                } elseif ($section === 'tenaga') {
                     $lowerLabel = strtolower($labelClean);
                     if (in_array($lowerLabel, ['pekerja', 'tukang', 'mandor', 'pelaksana'])) {
                         $report['jumlah_' . $lowerLabel] = (int) $value;
                     } else {
                         $field = $this->mapLabelToField($labelClean);
                         if ($field) $report[$field] = $value;
                     }
                } else {
                    $field = $this->mapLabelToField($labelClean);
                    if ($field === 'jam_kerja') {
                        $value = str_replace(['–', '—'], '-', $value); // Replace en-dash/em-dash with standard hyphen
                        $parts = explode('-', $value);
                        if (count($parts) >= 2) {
                            $report['jam_mulai'] = trim($parts[0]);
                            $report['jam_selesai'] = trim($parts[1]);
                        } else {
                            $report['jam_mulai'] = trim($value);
                        }
                    } elseif ($field && $value !== '') {
                        $report[$field] = $value;
                    }
                }
            } else {
                // Fallback for inline items like "Semen PCC (100 sak)" or "1 Unit Concrete Pump"
                $inlineText = preg_replace('/^[\-\*\d\.]+\s*/', '', $lineTrim); // remove numbering
                if ($section === 'material') {
                    $vol = 1;
                    $sat = 'ls';
                    $nama = $inlineText;
                    if (preg_match('/^(.*?)\s*\(?([\d,\.]+)\s*([a-zA-Z]+)\)?$/', $inlineText, $m)) {
                        $nama = trim($m[1]);
                        $vol = (float) str_replace(',', '.', $m[2]);
                        $sat = trim($m[3]);
                    }
                    if (!empty($currentMaterial)) $materials[] = $currentMaterial;
                    $currentMaterial = ['nama_material' => $nama, 'volume' => $vol, 'satuan' => $sat];
                } elseif ($section === 'alat') {
                    $jum = 1;
                    $nama = $inlineText;
                    if (preg_match('/^([\d]+)\s*(?:unit|buah|set)?\s*(.*)$/i', $inlineText, $m)) {
                        $jum = (int) $m[1];
                        $nama = trim($m[2]);
                    } elseif (preg_match('/^(.*?)\s*\(?([\d]+)\s*(?:unit|buah|set)?\)?$/i', $inlineText, $m)) {
                        $nama = trim($m[1]);
                        $jum = (int) $m[2];
                    }
                    if (!empty($currentAlat)) $alats[] = $currentAlat;
                    $currentAlat = ['nama_alat' => $nama, 'jumlah' => $jum];
                }
            }
        }
        
        // Push last material/alat
        if (!empty($currentMaterial)) $materials[] = $currentMaterial;
        if (!empty($currentAlat)) $alats[] = $currentAlat;
        
        $report['materials_parsed'] = $materials;
        $report['alats_parsed'] = $alats;
        
        if (!empty($pekerjaanYangDilakukan)) {
            $report['pekerjaan_yang_dilakukan'] = $pekerjaanYangDilakukan;
        }

        // Default tanggal
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
            ->replace(['_', '-', '(', ')', '%'], '')
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
            'kontraktor pelaksana' => 'kontraktor',
            'kontraktor / kontraktor pelaksana' => 'kontraktor',
            'konsultan' => 'konsultan',
            'konsultan pengawas' => 'konsultan',
            'pic' => 'pic',
            'minggu' => 'minggu_ke',
            'minggu ke' => 'minggu_ke',
            'tanggal' => 'tanggal',
            'tanggal yyyymmdd' => 'tanggal',
            'progress' => 'progress',
            'uraian' => 'pekerjaan',
            'jumlah pekerja' => 'jumlah_pekerja',
            'jumlah tukang' => 'jumlah_tukang',
            'jumlah mandor' => 'jumlah_mandor',
            'jam mulai' => 'jam_mulai',
            'jam selesai' => 'jam_selesai',
            'material' => 'material',
            'peralatan' => 'alat',
            'alat' => 'alat',
            'cuaca cerahmendunghujan' => 'cuaca',
            'cuaca' => 'cuaca',
            'kendala' => 'kendala',
            'rencana besok' => 'rencana_besok',
            'keterangan' => 'keterangan',
            'catatan' => 'catatan',
            'tenaga' => 'tenaga',
            'jam kerja' => 'jam_kerja',
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
                'nama_proyek' => $report['nama_proyek'] ?? 'Proyek ' . ($report['lokasi'] ?? ''),
                'kegiatan' => $report['kegiatan'] ?? ($report['pekerjaan'] ?? ''),
                'sub_kegiatan' => $report['sub_kegiatan'] ?? null,
                'pekerjaan' => $report['pekerjaan'] ?? '',
                'lokasi' => $report['lokasi'] ?? '',
                'kontraktor' => $report['kontraktor'] ?? null,
                'konsultan' => $report['konsultan'] ?? null,
                'pic' => $report['pic'] ?? null,
                'minggu_ke' => $report['minggu_ke'] ?? null,
                'tanggal' => Carbon::parse(str_ireplace(['januari','februari','maret','mei','juni','juli','agustus','oktober','desember'], ['january','february','march','may','june','july','august','october','december'], $report['tanggal'] ?? now()))->toDateString(),
                'progress' => isset($report['progress']) ? (int) $report['progress'] : null,
                'jam_mulai' => $report['jam_mulai'] ?? null,
                'jam_selesai' => $report['jam_selesai'] ?? null,
                'status' => Laporan::STATUS_MENUNGGU,
                'catatan' => $report['catatan'] ?? null,
                'cuaca' => $report['cuaca'] ?? null,
                'kendala' => $report['kendala'] ?? null,
                'rencana_besok' => $report['rencana_besok'] ?? null,
                'keterangan' => $report['keterangan'] ?? null,
            ]);

            // Pekerjaan detail
            if (!empty($report['pekerjaan_yang_dilakukan'])) {
                foreach ($report['pekerjaan_yang_dilakukan'] as $pek) {
                    if (trim($pek) !== '') {
                        LaporanPekerjaan::create([
                            'laporan_id' => $laporan->id,
                            'nama_pekerjaan' => $pek,
                        ]);
                    }
                }
            } elseif (!empty($report['pekerjaan'])) {
                LaporanPekerjaan::create([
                    'laporan_id' => $laporan->id,
                    'nama_pekerjaan' => $report['pekerjaan'],
                ]);
            }

            // Tenaga kerja
            $pekerja = (int) ($report['jumlah_pekerja'] ?? 0);
            $tukang = (int) ($report['jumlah_tukang'] ?? 0);
            $mandor = (int) ($report['jumlah_mandor'] ?? 0);
            $pelaksana = (int) ($report['jumlah_pelaksana'] ?? 0);

            if (!empty($report['tenaga'])) {
                $tenaga = $this->parseTenaga($report['tenaga']);
                $pekerja = $tenaga['pekerja'] ?? $pekerja;
                $tukang = $tenaga['tukang'] ?? $tukang;
                $mandor = $tenaga['mandor'] ?? $mandor;
                $pelaksana = $tenaga['pelaksana'] ?? $pelaksana;
            }

            if ($pekerja > 0 || $tukang > 0 || $mandor > 0 || $pelaksana > 0) {
                LaporanTenaga::create([
                    'laporan_id' => $laporan->id,
                    'pekerja' => $pekerja,
                    'tukang' => $tukang,
                    'mandor' => $mandor,
                    'pelaksana' => $pelaksana,
                ]);
            }

            // Material
            if (!empty($report['materials_parsed'])) {
                foreach ($report['materials_parsed'] as $material) {
                    if (!empty($material['nama_material'])) {
                        LaporanMaterial::create([
                            'laporan_id' => $laporan->id,
                            'nama_material' => $material['nama_material'],
                            'volume' => $material['volume'],
                            'satuan' => $material['satuan'],
                        ]);
                    }
                }
            } elseif (!empty($report['material'])) {
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
            if (!empty($report['alats_parsed'])) {
                foreach ($report['alats_parsed'] as $alat) {
                    if (!empty($alat['nama_alat'])) {
                        LaporanAlat::create([
                            'laporan_id' => $laporan->id,
                            'nama_alat' => $alat['nama_alat'],
                            'jumlah' => $alat['jumlah'],
                        ]);
                    }
                }
            } elseif (!empty($report['alat'])) {
                foreach ($this->parseAlats($report['alat']) as $alat) {
                    LaporanAlat::create([
                        'laporan_id' => $laporan->id,
                        'nama_alat' => $alat['nama_alat'],
                        'jumlah' => $alat['jumlah'],
                    ]);
                }
            }

            // Foto
            if (!empty($report['fotos'])) {
                foreach ($report['fotos'] as $foto) {
                    if (!empty($foto['url'])) {
                        LaporanFoto::create([
                            'laporan_id' => $laporan->id,
                            'foto' => $foto['url'],
                            'keterangan' => $foto['keterangan'] ?: 'Tidak ada keterangan',
                        ]);
                    }
                }
            } elseif (!empty($report['foto_url'])) {
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
        if (str_contains($value, '|')) {
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
        } else {
            return collect(array_filter(array_map('trim', explode(',', $value))))
                ->map(function (string $item) {
                    return [
                        'nama_material' => $item,
                        'volume' => 1,
                        'satuan' => 'ls',
                    ];
                })
                ->filter()
                ->values()
                ->all();
        }
    }

    /**
     * Parse alat: "Concrete Mixer|1; Vibrator|2"
     */
    protected function parseAlats(string $value): array
    {
        if (str_contains($value, '|')) {
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
        } else {
            return collect(array_filter(array_map('trim', explode(',', $value))))
                ->map(function (string $item) {
                    return [
                        'nama_alat' => $item,
                        'jumlah' => 1,
                    ];
                })
                ->filter(fn($item) => $item['nama_alat'])
                ->values()
                ->all();
        }
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
        return "*Silakan pilih menu dengan membalas angka:*\n\n"
            . "1. Isi Laporan Harian (Interaktif)\n"
            . "2. Cek Riwayat Laporan Terakhir\n"
            . "3. Bantuan / Panduan Lengkap\n"
            . "0. Batal / Buat Ulang Percakapan";
    }

    protected function contohFormat(): string
    {
        return "*FORM LAPORAN HARIAN*\n\n"
            . "Silakan salin format berikut, isi datanya, lalu kirim kembali dalam SATU pesan (boleh disertai foto).\n\n"
            . "==============================\n\n"
                    . "LAPORAN HARIAN\n\n"
            . "Tanggal :\n"
            . "Kontraktor / Kontraktor Pelaksana :\n"
            . "Konsultan :\n"
            . "PIC :\n"
            . "Minggu Ke :\n"
            . "Kegiatan :\n"
            . "Sub Kegiatan :\n"
            . "Pekerjaan :\n"
            . "Lokasi :\n"
            . "Cuaca :\n"
            . "Jam Kerja :\n\n"
            . "Pekerjaan Yang Dilakukan:\n"
            . "-\n\n"
            . "Material\n"
            . "- Nama Material :\n"
            . "- Volume :\n"
            . "- Satuan :\n\n"
            . "Alat\n"
            . "- Nama Alat : \n"
            . "- Jumlah:\n\n"
            . "Tenaga Kerja\n"
            . "Pekerja :\n"
            . "Tukang :\n"
            . "Mandor :\n"
            . "Pelaksana :\n\n"
            . "Progress :\n\n"
            . "Kendala :\n\n"
            . "Keterangan :\n";
    }
}
