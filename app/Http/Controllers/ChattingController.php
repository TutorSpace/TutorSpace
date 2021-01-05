<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use App\Chatroom;
use App\Events\NewMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ChattingController extends Controller
{
    public function index(Request $request) {
        if(!$request->input('toViewOtherUserId') || $request->input('toViewOtherUserId') == Auth::id()) {
            return view('chatting.index', [
            ]);
        }

        $otherUser = User::find($request->input('toViewOtherUserId'));
        $user_id_1 = Auth::id() < $otherUser->id ? Auth::id() : $otherUser->id;
        $user_id_2 = Auth::id() < $otherUser->id ? $otherUser->id : Auth::id();
        $chatroom = Chatroom::where('user_id_1', $user_id_1)->where('user_id_2', $user_id_2)->first();

        // if no chatroom
        if(!Chatroom::haveChatroom(Auth::user(), $otherUser)) {
            $newChatroom = new Chatroom();
            $newChatroom->user_id_1 = $user_id_1;
            $newChatroom->user_id_2 = $user_id_2;
            $newChatroom->creator_user_id = Auth::id();
            $newChatroom->save();
        } else if(
            !$chatroom->hasMessages()
            && !Chatroom::haveChatroomAndIsCreator($otherUser)) {
            // if have chatroom, not have messages, and is not the creator of the chatroom
            $newChatroom = new Chatroom();
            $newChatroom->user_id_1 = $user_id_1;
            $newChatroom->user_id_2 = $user_id_2;
            $newChatroom->creator_user_id = Auth::id();
            $newChatroom->save();
        }

        return view('chatting.index', [
            'toViewOtherUserId' => $request->input('toViewOtherUserId')
        ]);
    }

    public function getMessages(Request $request) {
        $otherUserId = $request->input('userId');

        if(
            // if there is such a chatroom between the two users
            Chatroom::where(function($query) use ($otherUserId) {
                $query->where('user_id_1', Auth::id() < $otherUserId ? Auth::id() : $otherUserId)->where('user_id_2', Auth::id() < $otherUserId ? $otherUserId : Auth::id());
            })
            ->exists()
        ) {
            Chatroom::removeUnreadStatus($otherUserId);
            return view('chatting.content', [
                'user' => User::find($otherUserId),
            ]);
        }
    }

    public function sendMsg(Request $request) {
        $content = $request->input('msg-to-send');
        $to = $request->input('other-user-id');
        $from = Auth::id();

        // validate the msg
        if(Auth::user()->can('create', [Message::class, User::find($to)])) {
            $msg = new Message();
            $msg->from = $from;
            $msg->to = $to;
            $msg->message = $content;
            $msg->is_read = false;
            $msg->save();

            // remove the zombie chatrooms
            if(Chatroom::where('user_id_1', $to < $from ? $to : $from)->where('user_id_2', $to < $from ? $from : $to)->count() > 1) {
                Chatroom::where('user_id_1', $to < $from ? $to : $from)->where('user_id_2', $to < $from ? $from : $to)->where('creator_user_id', $to)->first()->delete();
                broadcast(new NewMessage($msg, true));
            } else {
                broadcast(new NewMessage($msg, false));
            }
            return 'success';
        }
    }



}
