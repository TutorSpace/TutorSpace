<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChattingController extends Controller
{
    public function index() {
        return view('chatting.index');
    }
}
