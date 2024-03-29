<?php

namespace App;

use Auth;

use App\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Traits\HasCompositePrimaryKey;

// IMPORTANT: chatroom must have smaller id as user_id_1 and larger as user_id_2
class Chatroom extends Model
{
    use HasCompositePrimaryKey;

    protected $primaryKey = ['user_id_1', 'user_id_2', 'creator_user_id'];
    public $incrementing = false;

    // the user should listen to this channel
    public static function getChannelName() {
        return 'chatroom.' . Auth::id();
    }

    // return true if the CURRENT user has unread messages with another user
    public static function haveUnreadMessagesWith($otherUserId) {
        return Message::where('from', $otherUserId)
                        ->where('to', Auth::id())
                        ->where('is_read', false)
                        ->exists();
    }

    public static function haveUnreadMessages() {
        return Message::where('to', Auth::id())
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

    public function hasMessages() {
        return Message::where(function($query) {
            $query->where('from', $this->user_id_1)->where('to', $this->user_id_2);
        })
        ->orWhere(function($query) {
            $query->where('to', $this->user_id_1)->where('from', $this->user_id_2);
        })
        ->exists();
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

    public static function haveChatroom($user1, $user2) {
        $userId1 = $user1->id;
        $userId2 = $user2->id;

        return Chatroom::where(function($query) use($userId1, $userId2) {
            $query->where('user_id_1', strcmp($userId1, $userId2) < 0 ? $userId1 : $userId2)->where('user_id_2', strcmp($userId1, $userId2) < 0 ? $userId2 : $userId1);
        })->exists();
    }

    public static function haveChatroomAndIsCreator($otherUser) {
        $otherUserId = $otherUser->id;

        return Chatroom::where(function($query) use($otherUserId) {
            $query->where('user_id_1', strcmp($otherUserId, Auth::id()) < 0 ? $otherUserId : Auth::id())->where('user_id_2', strcmp($otherUserId, Auth::id()) < 0 ? Auth::id() : $otherUserId)->where('creator_user_id', Auth::id());
        })->exists();
    }

}
