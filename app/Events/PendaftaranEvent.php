<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PendaftaranEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $connection = 'redis';
    public $queue = 'default';
    public $broadcastAs ;


    public function __construct($data)
    {
        $this->broadcastAs = $data;
    }

    public function broadcastOn()
    {
        return new Channel('Pendaftaran');
    }


    public function broadcastAs()
    {
        return $this->broadcastAs;
    }
    

    public function broadcastWith()
    {
        return [
            'Tell'=> 'ping'
        ];
    }
}
