<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Subject;
use App\Characteristic;

class testController extends Controller
{
    public function test() {
        dd(Characteristic::find(1)->users);
    }
}
