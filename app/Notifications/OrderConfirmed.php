<?php

// app/Notifications/OrderConfirmed.php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class OrderConfirmed extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TwilioChannel::class];
    }

    /**
     * Get the Twilio SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \NotificationChannels\Twilio\TwilioSmsMessage
     */
    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content("Tu pedido #{$this->order->id} ha sido confirmado. ¡Gracias por tu compra!");
    }
}
