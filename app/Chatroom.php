<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;
use App\Message;

class Chatroom extends Model
{
    public $timestamps = false;


    // return true if the CURRENT user has unread messages
    public static function haveUnreadMessages($otherUserId) {
        return Message::where('from', $otherUserId)
                        ->where('to', Auth::id())
                        ->where('is_read', false)
                        ->exists();
    }

    public static function removeUnreadStatus($otherUserId) {
        Message::where('from', $otherUserId)
                ->where('to', Auth::id())
                ->update(['is_read' => true]);
    }

    public function getLatestMessageTime() {
        return Message::where(function($query) {
            $query->where('from', $this->user_id_1)->where('to', $this->user_id_2);
        })
        ->orWhere(function($query) {
            $query->where('to', $this->user_id_1)->where('from', $this->user_id_2);
        })
        ->orderBy('created_at', 'desc')
        ->first()
        ->created_at;
    }

    public function getLatestMessage() {
        return Message::where(function($query) {
            $query->where('from', $this->user_id_1)->where('to', $this->user_id_2);
        })
        ->orWhere(function($query) {
            $query->where('to', $this->user_id_1)->where('from', $this->user_id_2);
        })
        ->orderBy('created_at', 'desc')
        ->first()
        ->message;
    }

}
