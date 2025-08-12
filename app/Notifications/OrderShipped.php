<?php

namespace App\Notifications;


use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class OrderShipped extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return [TwilioChannel::class];
    }

    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content("Tu pedido #{$notifiable->id} ha sido enviado. ¡Gracias por tu compra!");
    }
}
