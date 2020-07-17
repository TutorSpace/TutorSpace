<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;
use App\Message;

class Chatroom extends Model
{
    public $timestamps = false;

    // return true if the CURRENT user has unread messages
    public function haveUnreadMessages($currentUserId, $otherUserId) {

        $haveUnread = Message::where('from', $otherUserId)
                            ->where('to', $currentUserId)
                            ->where('is_read', 0)
                            ->count() > 0;

        return $haveUnread;
    }

    public function getLatestMessageTime() {
        // get all messages
        $latestMsg = Message::where(function($query) {
            $query->where('from', $this->user_id_1)->where('to', $this->user_id_2);
        })
        ->orWhere(function($query) {
            $query->where('to', $this->user_id_1)->where('from', $this->user_id_2);
        })
        ->orderBy('created_at', 'desc')
        ->first();

        return $latestMsg ? $latestMsg->created_at : null;
    }
}
