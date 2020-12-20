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

        // if no chatroom
        if(!Chatroom::haveChatroom(Auth::user(), $otherUser)) {
            $newChatroom = new Chatroom();
            $newChatroom->user_id_1 = $user_id_1;
            $newChatroom->user_id_2 = $user_id_2;
            $newChatroom->creater_user_id = Auth::id();
            $newChatroom->save();

            return view('chatting.index', [
                'toViewOtherUserId' => $request->input('toViewOtherUserId')
            ]);
        } else {
            // if have chatroom
            $chatroom = Chatroom::where('user_id_1', $user_id_1)->where('user_id_2', $user_id_2)->first();

            // 1. have messages sent
            if($chatroom->hasMessages()) {
                return view('chatting.index', [
                    'toViewOtherUserId' => $request->input('toViewOtherUserId')
                ]);
            } else {
                // 2. no messages sent
                if(Chatroom::haveChatroomAndIsCreater($otherUser)) {
                    dd('here');
                } else {
                    $newChatroom = new Chatroom();
                    $newChatroom->user_id_1 = $user_id_1;
                    $newChatroom->user_id_2 = $user_id_2;
                    $newChatroom->creater_user_id = Auth::id();
                    $newChatroom->save();

                    return view('chatting.index', [
                        'toViewOtherUserId' => $request->input('toViewOtherUserId')
                    ]);
                }
            }
        }


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
            broadcast(new NewMessage($msg));
            return 'success';
        }
    }



}
