<?php

use App\User;
use App\Chatroom;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// chatting - messages
Broadcast::channel('message.{userId1}-{userId2}', function($user, $userId1, $userId2) {
    return ($user->id == $userId1 || $user->id == $userId2) && Chatroom::haveChatroom(User::find($userId1), User::find($userId2));
});

// chatting - chatrooms
Broadcast::channel('chatroom.{userId}', function($user, $userId) {
    return $user->id == $userId;
});
