<?php

namespace App\Events;

use App\User;
use App\Message;
use Carbon\Carbon;
use App\CustomClass\TimeFormatter;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // this function will be called only if you implements the shouldbroadcast
        // broadcast on the chatting channel between the two users
        return new PrivateChannel($this->message->getChannelName());
    }

    public function broadcastAs()
    {
        return 'NewMessage';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        $tz = TimeFormatter::getTZ();
        $user = User::find($this->message->from);
        return [
            'from' => $this->message->from,
            'to' => $this->message->to,
            // 'message' => $this->message->message,
            'message' => $tz,
            'created_at' => date('Y-m-d H:i:s', strtotime($this->message->created_at->setTimeZone($tz))),
            'imgUrl' => Storage::url($user->profile_pic_url),
            'chatroomView' => view('chatting.side-bar-chatting-msg', [
                'user' => $user,
                'message' => $this->message->message,
                'time' => date('Y-m-d H:i:s', strtotime($this->message->created_at->setTimeZone($tz)))
            ])->render(),
            'imgPlaceholder' => strtoupper($user->first_name[0]) . ' ' . strtoupper($user->last_name[0]),
        ];
    }
}
