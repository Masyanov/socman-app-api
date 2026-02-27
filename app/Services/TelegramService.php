<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    /**
     * Низкоуровневый клиент Telegram Bot API.
     * Возвращает true/false, исключения наружу не кидает.
     */
    public function sendMessage(string $chatId, string $text, ?array $replyMarkup = null): bool
    {
        $botToken = (string) config('services.telegram.bot_token');
        if ($botToken === '') {
            Log::error('TelegramService: TELEGRAM_BOT_TOKEN is not configured');
            return false;
        }

        $payload = [
            'chat_id' => $chatId,
            'text' => $text,
        ];

        if ($replyMarkup !== null) {
            $payload['reply_markup'] = json_encode($replyMarkup);
        }

        try {
            $response = Http::timeout(10)
                ->connectTimeout(3)
                ->retry(2, 200)
                ->post("https://api.telegram.org/bot{$botToken}/sendMessage", $payload);

            if (!$response->ok()) {
                Log::error('Telegram send error', [
                    'chat_id' => $chatId,
                    'body' => $response->body(),
                    'status' => $response->status(),
                ]);
                return false;
            }

            return true;
        } catch (\Throwable $e) {
            Log::error('Telegram send exception', [
                'chat_id' => $chatId,
                'message' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
