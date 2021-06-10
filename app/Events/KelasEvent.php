<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class KelasEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $connection = 'redis';
    public $queue = 'default';
    public $KodeKelas ;


    public function __construct($data)
    {
        $this->KodeKelas = $data;
    }

    public function broadcastOn()
    {
        return new Channel('Event'.$this->KodeKelas);
    }


    public function broadcastAs()
    {
        return 'Kelas';
    }
    

    public function broadcastWith()
    {
        return [
            'Tell'=> 'ping'
        ];
    }
}
