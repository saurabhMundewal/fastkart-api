<?php

namespace App\Listeners;

use App\Events\UpdateOrderStatusEvent;
use App\Helpers\Helpers;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\UpdateOrderStatusNotification;

class UpdateOrderStatusListener implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(UpdateOrderStatusEvent $event)
    {
        if ($event->order->consumer_id) {
            $consumer = Helpers::getConsumerById($event->order->consumer_id);
            if ($consumer) {
                $consumer->notify(new UpdateOrderStatusNotification($event->order, $consumer));
            }
        }
    }
}
