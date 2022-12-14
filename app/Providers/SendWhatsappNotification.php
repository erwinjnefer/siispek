<?php

namespace App\Providers;

use App\Http\Controllers\MBroker;
use App\Providers\Whatsapp;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendWhatsappNotification
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
     * @param  Whatsapp  $event
     * @return void
     */
    public function handle(Whatsapp $event)
    {
        //
        $wa = new MBroker();
        $wa->send($event->no_wa, $event->text);
    }
}
