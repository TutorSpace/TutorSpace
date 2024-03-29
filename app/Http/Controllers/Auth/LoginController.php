<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use App\Rules\EmailUSC;
use Illuminate\Http\Request;
use App\CustomClass\URLManager;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct() {
        $this->middleware('guest')->except([
            'logout'
        ]);
    }

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
        if(!User::existStudent($request->input('email'))) {
            return redirect()->back()->withInput()->withErrors([
                'loginError' => 'The identity you are trying to log in with this email does not exist.'
            ]);
        }

        // if registered with google
        // IMPORTANT: BOTH google_id and password must be transfered when user registers the second identity!!!
        if(User::registeredWithGoogle($request->input('email'))) {
            return redirect()->back()->withInput()->withErrors([
                'loginError' => 'This email is registered using Google. Please sign in with Google.'
            ]);
        }

        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'is_tutor' => false])) {
            // Authentication passed...
            if($request->query('backUrl')) {
                return redirect($request->query('backUrl'))->with([
                    'showWelcome' => true
                ]);
            }
            return redirect()->route('home')->with([
                'showWelcome' => true
            ]);
        }
        else {
            return redirect()->back()->withInput()->with([
                'passwordError' => 'Your password is incorrect.'
            ]);
        }
    }

    // log in the tutor with password
    public function storeTutor(Request $request) {
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

        // if this email does not have a tutor identity
        if(!User::existTutor($request->input('email'))) {
            return redirect()->back()->withInput()->withErrors([
                'loginError' => 'The identity you are trying to log in with this email does not exist.'
            ]);
        }

        // if registered with google
        // IMPORTANT: BOTH google_id and password must be transfered when user registers the second identity!!!
        if(User::registeredWithGoogle($request->input('email'))) {
            return redirect()->back()->withInput()->withErrors([
                'loginError' => 'This email is registered using Google. Please sign in with Google.'
            ]);
        }

        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'is_tutor' => true])) {
            // Authentication passed...

            if($request->query('backUrl')) {
                return redirect($request->query('backUrl'))->with([
                    'showWelcome' => true
                ]);
            }
            return redirect()->route('home')->with([
                'showWelcome' => true
            ]);
        }
        else {
            return redirect()->back()->withInput()->with([
                'passwordError' => 'Your password is incorrect.'
            ]);
        }
    }
}
