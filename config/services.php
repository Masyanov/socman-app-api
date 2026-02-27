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


    'nocaptcha' => [
        'sitekey' => env('NOCAPTCHA_SITEKEY'),
        'secret' => env('NOCAPTCHA_SECRET'),
    ],

    'telegram' => [
        'bot_token' => env('TELEGRAM_BOT_TOKEN'),
        // Secret для внутренних запросов от бота/интеграции к API
        // Передавать в заголовке: X-Bot-Secret: <secret>
        'bot_secret' => env('TELEGRAM_BOT_SECRET'),
    ],

    'docker_manager' => [
        'url' => env('DOCKER_MANAGER_URL', 'http://docker-manager:8085'),
        'token' => env('DOCKER_MANAGER_TOKEN'),
        'timeout_seconds' => (int) env('DOCKER_MANAGER_TIMEOUT', 10),
        'connect_timeout_seconds' => (int) env('DOCKER_MANAGER_CONNECT_TIMEOUT', 3),
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

];
