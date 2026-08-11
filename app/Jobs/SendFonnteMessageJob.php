<?php

namespace App\Jobs;

use App\Services\FonnteService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendFonnteMessageJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $endpoint, public array $data)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(FonnteService $fonnteService): void
    {
        $fonnteService->sendRawRequest($this->endpoint, $this->data);
    }
}
