<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Subject;
use App\Characteristic;
use App\Bookmark;


class testController extends Controller
{
    public function test() {

        // Sarah: dd() is laravel's way of php's dump. In your browser, go to localhost:8000/test and then this function will run. Whenever you want to test syntax, the easiest way would be go to 'localhost:8000/test', and run your test inside this function. Use this function to play around with the Database syntax


        // dd(User::find(2)->upcomingSessions());

        dd(Bookmark::bookmarkedUsers(16));
    }
}
