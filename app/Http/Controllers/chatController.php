<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Chatroom;
use App\Message;
use App\User;

use App\NewMessage;

class chatController extends Controller
{
    public function show() {
        $user = Auth::user();
        $myId = Auth::id();

        $chatrooms = Chatroom::where(function($query) use($myId) {
                        $query->where('user_id_1', $myId)->where('user_id_2', '!=', $myId);
                    })
                    ->orWhere(function($query) use($myId) {
                        $query->where('user_id_2', $myId)->where('user_id_1', '!=', $myId);
                    })
                    ->get();

        return view('chatting.chatroom', [
            'user' => $user,
            'chatrooms' => $chatrooms
        ]);
    }

    public function showChat(Request $request, User $otherUser) {
        // make sure there is such conversation
        $user = Auth::user();
        $myId = Auth::id();

        if($myId == $otherUser->id){
            return redirect()->route('home');
        }

        $otherUserId = $otherUser->id;

        $haveChatroom = Chatroom::where(function($query) use($myId, $otherUserId) {
                        $query->where('user_id_1', $myId)->where('user_id_2', '=', $otherUserId);
                    })
                    ->orWhere(function($query) use($myId, $otherUserId) {
                        $query->where('user_id_2', $myId)->where('user_id_1', '=', $otherUserId);
                    })
                    ->count() != 0;

        // if no chatting room, create one
        if(!$haveChatroom) {
            $chatroom = new Chatroom();
            $chatroom->user_id_1 = $myId;
            $chatroom->user_id_2 = $otherUserId;
            $chatroom->save();
        }

        $chatrooms = Chatroom::where(function($query) use($myId) {
            $query->where('user_id_1', $myId)->where('user_id_2', '!=', $myId);
        })
        ->orWhere(function($query) use($myId) {
            $query->where('user_id_2', $myId)->where('user_id_1', '!=', $myId);
        })
        ->get();

        $request->session()->flash('showChatUserId', $otherUserId);

        return view('chatting.chatroom', [
                    'user' => $user,
                    'chatrooms' => $chatrooms
                ])
                ->with('showChatUserId', $otherUserId);
    }

    public function sendMessage(Request $request) {
        $from = Auth::id();
        $to = $request->receiver_id;
        $message = $request->message;

        $data = new Message();
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->is_read = 0;
        $data->save();

        $msg = [
            'from' => $from,
            'to' => $to,
            'msg' => $message,
            'time' => $data->created_at
        ];

        event(new NewMessage($msg));

        return 'success';
    }

    public function getMessages($otherUserId) {
        $myId = Auth::id();

        // update to read
        Message::where(function($query) use($myId, $otherUserId) {
            $query->where('to', $myId)->where('from', $otherUserId);
        })
        ->update(['is_read' => 1]);

        // get all messages
        $messages = Message::where(function($query) use($myId, $otherUserId) {
            $query->where('from', $myId)->where('to', $otherUserId);
        })
        ->orWhere(function($query) use($myId, $otherUserId) {
            $query->where('to', $myId)->where('from', $otherUserId);
        })
        ->orderBy('created_at')
        ->get();


        return view('chatting.message_box', [
            'messages' => $messages,
            'otherUser' => User::find($otherUserId),
            'user' => Auth::user()
        ]);


    }
}
