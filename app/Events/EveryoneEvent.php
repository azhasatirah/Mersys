<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EveryoneEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $connection = 'redis';
    public $queue = 'default';


    public function __construct()
    {
        //
    }

    public function broadcastOn()
    {
        return new Channel('EveryoneChannel');
    }


    public function broadcastAs()
    {
        return 'EveryoneMessage';
    }
    

    public function broadcastWith()
    {
        return [
            'message'=> 'Hello!'
        ];
    }
}
