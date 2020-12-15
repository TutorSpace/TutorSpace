<?php

namespace App\Events;

use App\User;
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

    public $otherUser;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($otherUser)
    {
        $this->otherUser = $otherUser;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel(Chatroom::getChannelName());
    }

    public function broadcastAs()
    {
        return 'NewChatroom';
    }

        /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'otherUserId' => $this->otherUser->id,
            'view' => view('chatting.side-bar-chatting-msg', [
                'user' => User::find(2),
                'message' => 'testing',
                'time' => 'time'
            ])->render()
        ];
    }
}
