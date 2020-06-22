<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function indexStudent() {
        return view('auth.login_student');
    }

    public function logout() {
        Auth::logout();
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

        // if this email does not have a student identity
        if(User::where('email', '=', $request->input('email'))->where('is_tutor', false)->count() == 0) {
            return redirect()->back()->withInput()->withErrors(['The identity you are trying to log in with email does not exist.']);
        }

        $credentials = $request->only('email', 'password');

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
