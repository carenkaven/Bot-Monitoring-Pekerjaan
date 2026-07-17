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
}
