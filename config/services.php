<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'whatsapp' => [
        'webhook_token' => env('WHATSAPP_WEBHOOK_TOKEN'),
    ],

    'fonnte' => [
        'token' => env('FONNTE_TOKEN'),
        // Guardrails for a consent-based, inbound-only support bot. These
        // settings deliberately pace replies and stop a single conversation
        // from producing an excessive number of outbound messages.
        'minimum_reply_interval_seconds' => (int) env('FONNTE_MIN_REPLY_INTERVAL_SECONDS', 10),
        'recipient_cooldown_seconds' => (int) env('FONNTE_RECIPIENT_COOLDOWN_SECONDS', 15),
        'daily_reply_limit' => (int) env('FONNTE_DAILY_REPLY_LIMIT', 60),
        'inbound_dedup_seconds' => (int) env('FONNTE_INBOUND_DEDUP_SECONDS', 20),
    ],

];
