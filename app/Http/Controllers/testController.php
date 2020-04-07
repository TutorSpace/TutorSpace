<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class testController extends Controller
{
    public function test() {
        $email = "safsa@afs";
        $isTutor = User::where('email', '=', $email)->first()->is_tutor;
        if($isTutor)
            return redirect()->route('profile_tutor');
        return redirect()->route('profile_student');
    }
}
