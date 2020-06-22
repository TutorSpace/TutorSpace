<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use App\Rules\EmailUSC;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function indexStudent() {
        return view('auth.login_student');
    }

    public function indexTutor() {
        return view('auth.login_tutor');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->flush();
        return redirect()->route('index');
    }

    // log in the student with password
    public function storeStudent(Request $request) {
        $request->validate([
            'email' => [
                'required',
                'email:rfc',
                'exists:users,email'
            ],
            'password' => [
                'required'
            ]
        ]);

        // email must be a USC email
        $request->validate([
            'email' => [new EmailUSC]
        ]);

        // if this email does not have a student identity
        if(User::where('email', '=', $request->input('email'))->where('is_tutor', false)->count() == 0) {
            return redirect()->back()->withInput()->withErrors(['The identity you are trying to log in with email does not exist.']);
        }

        // if registered with google id
        // IMPORTANT: BOTH google_id and password must be transfered when user registers the second identity!!!
        if(User::where('email', '=', $request->input('email'))->where('is_tutor', false)->first()->google_id) {
            return redirect()->back()->withInput()->withErrors(['This email is registered using Google. Please sign in with Google.']);
        }

        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'is_tutor' => false])) {
            // Authentication passed...
            return redirect()->route('home');
        }
        else {
            return redirect()->back()->withInput()->with([
                'passwordError' => 'Your password is incorrect.'
            ]);
        }
    }


}
