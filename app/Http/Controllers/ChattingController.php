<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use Illuminate\Http\Request;

class ChattingController extends Controller
{
    public function index() {
        return view('chatting.index');
    }

    public function getMessages(Request $request) {
        return view('chatting.content', [
            'user' => User::find(2),
        ]);
    }

}
