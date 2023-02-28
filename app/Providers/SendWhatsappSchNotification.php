<?php

namespace App\Providers;

use App\Http\Controllers\MBroker;
use App\Http\Controllers\MBrokerSch;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendWhatsappSchNotification
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
     * @param  WhatsappSch  $event
     * @return void
     */
    public function handle(WhatsappSch $event)
    {
        //
        $wa = new MBrokerSch();
        $wa->send($event->no_wa, $event->text, $event->sch);
    }
}
