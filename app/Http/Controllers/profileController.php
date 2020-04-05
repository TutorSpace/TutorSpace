<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class profileController extends Controller
{
    public function showStudent(Request $request) {
        dd("inside profile student page!");


        return view('profile.profile_student');
    }

    public function showTutor() {
        dd("inside profile tutor page!");

        return view('profile.profile_tutor');
    }
}
