<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SubscriptionExpired extends Notification
{
    use Queueable;

    protected $subscription;

    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Subscription Expiring Soon')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your ' . $this->subscription->subscription_type . ' subscription will expire on ' . $this->subscription->expire_date . '. Please renew your subscription before it expires.')
            ->line('Thank you for using our platform!');
    }
}
