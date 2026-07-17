<?php

use App\Http\Controllers\Api\FonnteWebhookController;
use App\Http\Controllers\Api\WhatsAppWebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/whatsapp/laporan', [WhatsAppWebhookController::class, 'verify'])
    ->name('api.whatsapp.laporan.verify');

Route::post('/whatsapp/laporan', [WhatsAppWebhookController::class, 'store'])
    ->name('api.whatsapp.laporan.store');

Route::any('/whatsapp/fonnte', [FonnteWebhookController::class, 'handle'])
    ->name('api.whatsapp.fonnte');

