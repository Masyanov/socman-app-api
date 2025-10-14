<?php

namespace App\Services;

use App\Models\TelegramToken;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    public function userActiveChanged($userId, $active)
    {
        $meta = TelegramToken::where('user_id', $userId)->first();
        if ($meta && $meta->telegram_id) {
            $botToken = config('services.telegram.bot_token');
            $tg_id = $meta->telegram_id;

            if ($active) {
                $message = 'Вы активированы!✅';
                $reply_markup = [
                    'keyboard'        => [
                        [ ['text' => 'Показать тренировки'], ['text' => 'Выйти'] ]
                    ],
                    'resize_keyboard' => true,
                ];
            } else {
                $message = 'Ваш статус был изменён: вы теперь деактивирован❌.';
                $reply_markup = [
                    'keyboard'        => [ [ ['text' => 'Выйти'] ] ],
                    'resize_keyboard' => true,
                ];
            }

            $response = Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $tg_id,
                'text'    => $message,
                'reply_markup' => json_encode($reply_markup),
            ]);

            if (!$response->ok()) {
                Log::error('Telegram send error', [
                    'user_id' => $userId,
                    'telegram_id' => $tg_id,
                    'body' => $response->body(),
                ]);
            }
        }
    }
}
