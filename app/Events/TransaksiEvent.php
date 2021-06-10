<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransaksiEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $connection = 'redis';
    public $queue = 'default';
    public $KodeTransaksi ;
    public $EventType;


    public function __construct($kode,$type)
    {
        $this->KodeTransaksi = $kode;
        $this->EventType = $type;
    }

    public function broadcastOn()
    {
        return new Channel('TransaksiEvent'.$this->KodeTransaksi);
    }


    public function broadcastAs()
    {
        return $this->EventType;
    }
    

    public function broadcastWith()
    {
        return [
            'Tell'=> 'ping'
        ];
    }
}
