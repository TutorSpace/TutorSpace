<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

class loginController extends Controller
{
    public function show() {
        return view('authenticate.show_login');
    }

    public function login(Request $request) {
        
        $request->validate([
            'email' => [
                'required',
                'email:rfc',
                'exists:users'
            ],
            'password' => [
                'required'
            ]
        ]);


        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $isTutor = User::where('email', '=', $request->input('email'))->first()->is_tutor;
            if($isTutor)
                return redirect()->route('profile_tutor');
            return redirect()->route('profile_student');
        }
        else {
            return redirect()->route('login')->with(
                'loginError',
                "Please check your email and password."
            )->with('email', $request->input('email'));
        }
        
    }
}
