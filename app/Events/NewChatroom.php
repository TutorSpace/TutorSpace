<?php

namespace App\Events;

use App\Chatroom;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewChatroom implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chatroom;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Chatroom $chatroom)
    {
        $this->chatroom = $chatroom;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel($this->chatroom->getChannelName());
    }

    public function broadcastAs()
    {
        return 'NewChatroom';
    }
}
