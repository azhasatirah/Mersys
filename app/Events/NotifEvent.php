<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotifEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $connection = 'redis';
    public $queue = 'default';
    public $bas;


    public function __construct($data)
    {
        $this->bas = $data;
    }

    public function broadcastOn()
    {
        return new Channel('Notif');
    }


    public function broadcastAs()
    {
        return $this->bas;
    }
    

    public function broadcastWith()
    {
        return [
            'Tell'=> 'ping'
        ];
    }
}
