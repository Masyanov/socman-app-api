<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class TelegramActiveChanged extends Notification
{
    protected $active;

    public function __construct($active)
    {
        $this->active = $active;
    }

    public function via($notifiable)
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable)
    {
        return [
            'text' => $this->active
                ? 'Вы активированы!✅'
                : 'Ваш статус был изменён: вы теперь деактивирован❌.'
        ];
    }
}
