<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use App\Chatroom;
use App\Events\NewMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChattingController extends Controller
{
    public function index() {
        return view('chatting.index');
    }

    public function getMessages(Request $request) {
        $otherUserId = $request->input('userId');

        if(Chatroom::where(function($query) use ($otherUserId) {
            $query->where('user_id_1', Auth::id())->where('user_id_2', $otherUserId);
        })->orWhere(function($query) use ($otherUserId) {
            $query->where('user_id_2', Auth::id())->where('user_id_1', $otherUserId);
        })->count() == 1) {
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
