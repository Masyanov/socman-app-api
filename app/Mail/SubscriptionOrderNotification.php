<?php
namespace App\Mail;

use App\Models\SubscriptionOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionOrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $forUser;

    public function __construct(SubscriptionOrder $order, $forUser = false)
    {
        $this->order = $order;
        $this->forUser = $forUser;
    }

    public function build()
    {
        if ($this->forUser) {
            return $this->subject('Ваша заявка получена')
                        ->view('emails.subscription_user');
        } else {
            return $this->subject('Новая заявка на подписку')
                        ->view('emails.subscription_admin');
        }
    }
}

