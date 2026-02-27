<?php

namespace App\Jobs;

use App\Models\TelegramToken;
use App\Services\TelegramService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TelegramNotifyUserActiveChanged implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $userId,
        public bool $active
    ) {}

    public function handle(TelegramService $telegramService): void
    {
        $meta = TelegramToken::where('user_id', $this->userId)->first();
        if (!$meta || !$meta->telegram_id) {
            return;
        }

        $message = $this->active
            ? 'Вы активированы!✅'
            : 'Ваш статус был изменён: вы теперь деактивирован❌.';

        $replyMarkup = $this->active
            ? [
                'keyboard' => [
                    [['text' => 'Показать тренировки'], ['text' => 'Выйти']],
                ],
                'resize_keyboard' => true,
            ]
            : [
                'keyboard' => [
                    [['text' => 'Выйти']],
                ],
                'resize_keyboard' => true,
            ];

        $ok = $telegramService->sendMessage(
            chatId: (string) $meta->telegram_id,
            text: $message,
            replyMarkup: $replyMarkup
        );

        if (!$ok) {
            Log::warning('TelegramNotifyUserActiveChanged: send failed', [
                'user_id' => $this->userId,
                'telegram_id' => $meta->telegram_id,
            ]);
        }
    }
}

