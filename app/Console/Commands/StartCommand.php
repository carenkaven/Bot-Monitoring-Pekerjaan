<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('start')]
#[Description('Start Laravel, Vite, and WhatsApp Bot concurrently')]
class StartCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Laravel Server, Vite, and Ngrok...');
        $this->info('Bot WhatsApp dijalankan melalui Fonnte (cloud).');
        $this->info('Press Ctrl+C to stop them all.');

        $command = 'npx concurrently -c "blue,magenta,green,yellow" "php artisan serve" "npm run dev" "ngrok http 8000" "php artisan queue:work" --names="server,vite,ngrok,queue" --kill-others';

        passthru($command);
    }
}
