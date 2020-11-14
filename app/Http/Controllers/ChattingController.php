<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use App\Chatroom;
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
            return view('chatting.content', [
                'user' => User::find($otherUserId),
            ]);
        }

        return view('chatting.content', [
            'user' => User::find($otherUserId),
        ]);
    }

}
