<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class signupController extends Controller
{
    public function show() {
        return view('authenticate.show_signup');
    }

    public function showStudent() {
        return view('authenticate.show_signup_student');
    }

    public function showTutor() {
        return view('authenticate.show_signup_tutor');
    }

}
