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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class WhatsAppWebhookController extends Controller
{
    public function verify(Request $request): Response
    {
        $expectedToken = (string) config('services.whatsapp.webhook_token', '');
        $verifyToken = (string) (
            $request->query->get('hub.verify_token')
            ?? $request->query->get('hub_verify_token')
            ?? $request->query('token', '')
        );
        $challenge = (string) (
            $request->query->get('hub.challenge')
            ?? $request->query->get('hub_challenge')
            ?? ''
        );

        if ($expectedToken === '' || hash_equals($expectedToken, $verifyToken)) {
            return response($challenge);
        }

        return response('Forbidden', 403);
    }

    public function store(Request $request): JsonResponse
    {
        if (!$this->isAuthorized($request)) {
            return response()->json([
                'message' => 'Token webhook WhatsApp tidak valid.',
            ], 401);
        }

        $incoming = $this->extractIncomingMessage($request);

        $validator = Validator::make($incoming, [
            'from' => ['required', 'string'],
            'message' => ['required_without:report', 'nullable', 'string'],
            'report' => ['nullable', 'array'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Payload WhatsApp tidak lengkap.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $karyawan = $this->findKaryawanByPhone($incoming['from']);

        if (!$karyawan) {
            // Auto register the user based on their phone number so anyone can send reports
            $karyawan = Karyawan::create([
                'nama' => 'Pengguna WA (' . $this->normalizePhone($incoming['from']) . ')',
                'no_hp' => $this->normalizePhone($incoming['from']),
                'jabatan' => 'Guest',
                'status' => 'aktif',
                'is_verified' => true,
            ]);
        } else if (!$karyawan->isUsable()) {
            // Auto activate the user so they can send reports immediately
            $karyawan->update([
                'status' => 'aktif',
                'is_verified' => true,
            ]);
        }

        $parsedMessage = $this->parseMessage((string) ($incoming['message'] ?? ''));
        $report = array_replace($parsedMessage, $incoming['report'] ?? []);
        $report = $this->normalizeReport($report);

        $reportValidator = Validator::make($report, [
            'nama_proyek' => ['required', 'string', 'max:150'],
            'kegiatan' => ['required', 'string', 'max:150'],
            'sub_kegiatan' => ['nullable', 'string', 'max:150'],
            'pekerjaan' => ['required', 'string', 'max:255'],
            'lokasi' => ['required', 'string', 'max:150'],
            'kontraktor' => ['nullable', 'string', 'max:150'],
            'konsultan' => ['nullable', 'string', 'max:150'],
            'pic' => ['nullable', 'string', 'max:100'],
            'minggu_ke' => ['nullable', 'string', 'max:20'],
            'tanggal' => ['required', 'date'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ]);

        if ($reportValidator->fails()) {
            return response()->json([
                'message' => 'Format laporan WhatsApp belum sesuai.',
                'errors' => $reportValidator->errors(),
                'contoh_format' => $this->exampleMessage(),
            ], 422);
        }

        $laporan = DB::transaction(function () use ($karyawan, $report) {
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

            foreach ($this->parseWorkItems($report) as $namaPekerjaan) {
                LaporanPekerjaan::create([
                    'laporan_id' => $laporan->id,
                    'nama_pekerjaan' => $namaPekerjaan,
                ]);
            }

            $tenaga = $this->parseTenaga($report['tenaga'] ?? null);
            if ($tenaga) {
                LaporanTenaga::create([
                    'laporan_id' => $laporan->id,
                    'pekerja' => $tenaga['pekerja'] ?? 0,
                    'tukang' => $tenaga['tukang'] ?? 0,
                    'mandor' => $tenaga['mandor'] ?? 0,
                    'pelaksana' => $tenaga['pelaksana'] ?? 0,
                ]);
            }

            foreach ($this->parseMaterials($report['material'] ?? $report['materials'] ?? null) as $material) {
                LaporanMaterial::create([
                    'laporan_id' => $laporan->id,
                    'nama_material' => $material['nama_material'],
                    'volume' => $material['volume'],
                    'satuan' => $material['satuan'],
                ]);
            }

            foreach ($this->parseAlats($report['alat'] ?? $report['alats'] ?? null) as $alat) {
                LaporanAlat::create([
                    'laporan_id' => $laporan->id,
                    'nama_alat' => $alat['nama_alat'],
                    'jumlah' => $alat['jumlah'],
                ]);
            }

            foreach ($this->parseFotos($report['foto'] ?? $report['fotos'] ?? null) as $foto) {
                LaporanFoto::create([
                    'laporan_id' => $laporan->id,
                    'foto' => $foto['foto'],
                    'keterangan' => $foto['keterangan'] ?? null,
                ]);
            }

            return $laporan;
        });

        return response()->json([
            'message' => 'Laporan WhatsApp berhasil masuk ke website.',
            'laporan_id' => $laporan->id,
            'status' => $laporan->status,
        ], 201);
    }

    private function isAuthorized(Request $request): bool
    {
        $expectedToken = (string) config('services.whatsapp.webhook_token', '');

        if ($expectedToken === '') {
            return true;
        }

        $token = $request->bearerToken()
            ?: $request->header('X-Webhook-Token')
            ?: $request->input('token');

        return is_string($token) && hash_equals($expectedToken, $token);
    }

    private function extractIncomingMessage(Request $request): array
    {
        $payload = $request->all();
        $metaMessage = data_get($payload, 'entry.0.changes.0.value.messages.0');

        $reportKeys = [
            'nama_proyek',
            'kegiatan',
            'sub_kegiatan',
            'pekerjaan',
            'pekerjaan_detail',
            'lokasi',
            'kontraktor',
            'konsultan',
            'pic',
            'minggu_ke',
            'tanggal',
            'catatan',
            'tenaga',
            'material',
            'materials',
            'alat',
            'alats',
            'foto',
            'fotos',
        ];

        $topLevelReport = Arr::only($payload, $reportKeys);

        return [
            'from' => $request->input('from')
                ?: $request->input('sender')
                ?: $request->input('phone')
                ?: data_get($metaMessage, 'from'),
            'message' => $request->input('message')
                ?: $request->input('text')
                ?: $request->input('body')
                ?: data_get($metaMessage, 'text.body'),
            'report' => $request->input('report') ?: ($topLevelReport ?: null),
        ];
    }

    private function findKaryawanByPhone(string $phone): ?Karyawan
    {
        $normalized = $this->normalizePhone($phone);

        return Karyawan::query()
            ->whereNotNull('no_hp')
            ->get()
            ->first(fn(Karyawan $karyawan) => $this->normalizePhone($karyawan->no_hp) === $normalized);
    }

    private function normalizePhone(string $phone): string
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

    private function parseMessage(string $message): array
    {
        $report = [];

        foreach (preg_split('/\R+/', $message) ?: [] as $line) {
            if (!str_contains($line, ':')) {
                continue;
            }

            [$label, $value] = array_map('trim', explode(':', $line, 2));
            $field = $this->mapLabelToField($label);

            if ($field && $value !== '') {
                $report[$field] = $value;
            }
        }

        return $report;
    }

    private function mapLabelToField(string $label): ?string
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
            'detail pekerjaan' => 'pekerjaan_detail',
            'pekerjaan detail' => 'pekerjaan_detail',
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
            'materials' => 'materials',
            'alat' => 'alat',
            'alats' => 'alats',
            'foto' => 'foto',
            'fotos' => 'fotos',
        ][$key] ?? null;
    }

    private function normalizeReport(array $report): array
    {
        $normalized = [];

        foreach ($report as $key => $value) {
            $field = $this->mapLabelToField((string) $key) ?: $key;
            $normalized[$field] = is_string($value) ? trim($value) : $value;
        }

        $normalized['tanggal'] = $normalized['tanggal'] ?? now()->toDateString();

        return $normalized;
    }

    private function parseWorkItems(array $report): array
    {
        $items = $this->splitItems($report['pekerjaan_detail'] ?? null);

        if (!$items && isset($report['pekerjaan'])) {
            $items = [(string) $report['pekerjaan']];
        }

        return array_values(array_filter($items));
    }

    private function parseTenaga(mixed $value): array
    {
        if (is_array($value)) {
            return array_map('intval', Arr::only($value, ['pekerja', 'tukang', 'mandor', 'pelaksana']));
        }

        if (!is_string($value)) {
            return [];
        }

        preg_match_all('/(pekerja|tukang|mandor|pelaksana)\s*[:=]\s*(\d+)/i', $value, $matches, PREG_SET_ORDER);

        $tenaga = [];
        foreach ($matches as $match) {
            $tenaga[Str::lower($match[1])] = (int) $match[2];
        }

        return $tenaga;
    }

    private function parseMaterials(mixed $value): array
    {
        if (is_array($value)) {
            return collect($value)
                ->map(fn($item) => is_array($item) ? [
                    'nama_material' => $item['nama_material'] ?? $item['nama'] ?? null,
                    'volume' => $item['volume'] ?? null,
                    'satuan' => $item['satuan'] ?? null,
                ] : null)
                ->filter(fn($item) => $item && $item['nama_material'] && $item['volume'] !== null && $item['satuan'])
                ->values()
                ->all();
        }

        return collect($this->splitItems($value))
            ->map(function (string $item) {
                $parts = array_map('trim', explode('|', $item));

                if (count($parts) < 3) {
                    return null;
                }

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

    private function parseAlats(mixed $value): array
    {
        if (is_array($value)) {
            return collect($value)
                ->map(fn($item) => is_array($item) ? [
                    'nama_alat' => $item['nama_alat'] ?? $item['nama'] ?? null,
                    'jumlah' => $item['jumlah'] ?? 1,
                ] : null)
                ->filter(fn($item) => $item && $item['nama_alat'])
                ->values()
                ->all();
        }

        return collect($this->splitItems($value))
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

    private function parseFotos(mixed $value): array
    {
        if (is_array($value)) {
            return collect($value)
                ->map(fn($item) => is_array($item) ? [
                    'foto' => $item['foto'] ?? $item['url'] ?? null,
                    'keterangan' => $item['keterangan'] ?? null,
                ] : ['foto' => $item])
                ->filter(fn($item) => $item['foto'])
                ->values()
                ->all();
        }

        return collect($this->splitItems($value))
            ->map(fn($foto) => ['foto' => $foto])
            ->filter(fn($item) => $item['foto'])
            ->values()
            ->all();
    }

    private function splitItems(mixed $value): array
    {
        if (is_array($value)) {
            return array_values(array_filter(array_map('trim', $value)));
        }

        if (!is_string($value) || trim($value) === '') {
            return [];
        }

        return array_values(array_filter(array_map('trim', preg_split('/\s*;\s*/', $value) ?: [])));
    }

    private function exampleMessage(): string
    {
        return implode("\n", [
            'Nama Proyek: Pembangunan Jalan Lingkar Barat',
            'Kegiatan: Pekerjaan Beton',
            'Sub Kegiatan: Rigid Pavement',
            'Pekerjaan: Pengecoran',
            'Lokasi: Jl. Raya Tlogomas',
            'Tanggal: 2026-07-16',
            'Minggu Ke: 1',
            'Tenaga: pekerja=8, tukang=4, mandor=1, pelaksana=1',
            'Material: Semen Portland|20|sak; Pasir Beton|3|m3',
            'Alat: Concrete Mixer|1; Vibrator|2',
            'Catatan: Cuaca cerah',
        ]);
    }
}
