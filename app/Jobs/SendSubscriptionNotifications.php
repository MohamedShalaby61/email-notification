<?php

namespace App\Jobs;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\SubscriptionExpired;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSubscriptionNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $subscriptions = Subscription::where('expire_date', now()->addDay())->get();

        foreach ($subscriptions as $subscription) {
            $subscription->user->notify(new SubscriptionExpired($subscription));
        }
    }
}
