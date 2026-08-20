<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use App\Services\FonnteService;

class SendFotoReplyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $sender,
        public int $count
    ) {}

    public function handle(FonnteService $fonnte): void
    {
        $cacheKey = 'foto_reply_pending_' . $this->sender;
        $currentExpected = Cache::get($cacheKey);

        // Jika count saat ini di cache sama dengan count job ini, berarti belum ada foto tambahan yang masuk
        if ((int)$currentExpected === $this->count) {
            $fonnte->sendMessage(
                $this->sender,
                "Foto ke-{$this->count} berhasil diterima. Kirim foto berikutnya atau balas 0 jika sudah."
            );
            Cache::forget($cacheKey);
        }
    }
}
