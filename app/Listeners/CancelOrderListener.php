<?php

namespace App\Listeners;

use App\Helpers\Helpers;
use App\Events\CancelOrderEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\CancelOrderNotification;

class CancelOrderListener implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(CancelOrderEvent $event)
    {
        if ($event->order->consumer_id) {
            $consumer = Helpers::getConsumerById($event->order->consumer_id);
            if ($consumer) {
                $consumer->notify(new CancelOrderNotification($event->order, $consumer));
            }
        }
    }
}
