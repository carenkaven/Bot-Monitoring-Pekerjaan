<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected string $token;
    protected string $baseUrl = 'https://api.fonnte.com';

    public function __construct()
    {
        $this->token = (string) config('services.fonnte.token');
    }

    /**
     * Kirim pesan teks ke nomor WhatsApp.
     */
    public function sendMessage(string $target, string $message): array
    {
        return $this->request('/send', [
            'target' => $target,
            'message' => $message,
        ]);
    }

    /**
     * Kirim gambar dengan caption.
     */
    public function sendImage(string $target, string $imageUrl, string $caption = ''): array
    {
        return $this->request('/send', [
            'target' => $target,
            'message' => $caption,
            'url' => $imageUrl,
        ]);
    }

    /**
     * Kirim request ke Fonnte API.
     */
    protected function request(string $endpoint, array $data): array
    {
        try {
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Authorization' => $this->token,
                ])->post($this->baseUrl . $endpoint, $data);

            $result = $response->json() ?? [];

            if (!$response->successful()) {
                Log::warning('Fonnte API error', [
                    'status' => $response->status(),
                    'response' => $result,
                    'target' => $data['target'] ?? null,
                ]);
            }

            return $result;
        } catch (\Exception $e) {
            Log::error('Fonnte API exception', [
                'message' => $e->getMessage(),
                'target' => $data['target'] ?? null,
            ]);

            return ['status' => false, 'reason' => $e->getMessage()];
        }
    }

    /**
     * Download media dari Fonnte URL dan simpan ke lokal.
     * Mengembalikan path relative di storage (contoh: laporan/xxx.jpg).
     */
    public function downloadMedia(string $url): string
    {
        if (empty($url)) return '';

        try {
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Authorization' => $this->token,
                ])->get($url);

            if ($response->successful()) {
                $extension = 'jpg';
                $contentType = $response->header('Content-Type');
                if (is_string($contentType)) {
                    if (str_contains($contentType, 'image/png')) $extension = 'png';
                    elseif (str_contains($contentType, 'image/jpeg')) $extension = 'jpg';
                    elseif (str_contains($contentType, 'image/webp')) $extension = 'webp';
                    elseif (str_contains($contentType, 'video/mp4')) $extension = 'mp4';
                }
                
                $filename = 'laporan/' . \Illuminate\Support\Str::uuid() . '.' . $extension;
                \Illuminate\Support\Facades\Storage::disk('public')->put($filename, $response->body());
                return $filename;
            } else {
                Log::warning('Fonnte API download error', [
                    'status' => $response->status(),
                    'url' => $url,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Fonnte API download exception', [
                'message' => $e->getMessage(),
                'url' => $url,
            ]);
        }

        return $url; // Fallback
    }
}
