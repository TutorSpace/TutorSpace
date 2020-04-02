<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class profileController extends Controller
{
    public function showStudent() {
        return view('profile.profile_student');
    }

    public function showTutor() {
        return view('profile.profile_tutor');
    }
}
