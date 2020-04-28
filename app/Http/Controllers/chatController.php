<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;


class chatController extends Controller
{
    public function show() {
        $user = Auth::user();

        return view('chatting.chatroom', [
            'user' => $user
        ]);

    }

    public function sendMessage() {


    }
}
