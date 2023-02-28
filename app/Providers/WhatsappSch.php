<?php

namespace App\Providers;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WhatsappSch
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $no_wa;
    public $text;
    public $sch;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($no_wa, $text, $sch)
    {
        $this->no_wa = $no_wa;
        $this->text = $text;
        $this->sch = $sch;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
