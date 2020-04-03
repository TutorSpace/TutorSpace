<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class testController extends Controller
{
    public function test() {
        return User::find(3)->major;
    }
}
