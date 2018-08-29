<?php

namespace App\Listeners;

use App\Events\triggerEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class triggerEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  triggerEvent  $event
     * @return void
     */
    public function handle(triggerEvent $event)
    {
        return $event;
    }
}
