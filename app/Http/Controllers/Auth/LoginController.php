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

    // public function show() {
    //     return view('authenticate.show_login');
    // }

    // public function login(Request $request) {

    //     $request->validate([
    //         'email' => [
    //             'required',
    //             'email:rfc',
    //             'exists:users'
    //         ],
    //         'password' => [
    //             'required'
    //         ]
    //     ]);


    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {
    //         // Authentication passed...
    //         return redirect()->route('home');
    //     }
    //     else {
    //         return redirect()->route('login')->with(
    //             'loginError',
    //             "Please check your email and password."
    //         )->with('email', $request->input('email'));
    //     }

    // }

    // public function logout() {
    //     Auth::logout();
    //     return redirect()->route('index');
    // }


}
