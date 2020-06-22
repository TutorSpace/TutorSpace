<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function handleGoogleCallback(Request $request) {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('index');
        }

        // only allow people with @usc.edu to login
        if(explode("@", $user->email)[1] !== 'usc.edu'){
            // if for registration
            if($request->session()->get('registerGoogleStudent')){
                return redirect()->route('register.index.student.1')->with([
                    'errorMsg' => 'Please register with your USC Email!'
                ]);
            }
            else if($request->session()->get('registerGoogleTutor')){
                return redirect()->route('register.index.tutor.1')->with([
                    'errorMsg' => 'Please register with your USC Email!'
                ]);
            }
            else if($request->session()->get('loginGoogleStudent')){
                return redirect()->route('login.index.student')->with([
                    'errorMsg' => 'Please login with your USC Email!'
                ]);
            }
            else if($request->session()->get('loginGoogleTutor')){
                return redirect()->route('login.index.tutor')->with([
                    'errorMsg' => 'Please login with your USC Email!'
                ]);
            }
        }

        // true if this email is already registered as a student
        $existStudent = User::where('email', '=', $user->email)->where('is_tutor', false)->count() != 0;
        // true if this email is already registered as a tutor
        $existTutor = User::where('email', '=', $user->email)->where('is_tutor', true)->count() != 0;

        // error if they're an existing user with the same identity
        if(($request->session()->get('registerGoogleStudent') && $existStudent) ||
            ($request->session()->get('registerGoogleTutor') && $existTutor)){
            return redirect()->route('index')->with([
                'errorMsg' => 'You already registered as a student/tutor with the same email!'
            ]);
        }

        // if the user wants to register as a student and is registered as a tutor before, he should be redirected to the specific page that is specifically designed for him
        if($request->session()->get('registerGoogleStudent') && User::where('email', '=', $user->email)->where('is_tutor', true)->count() != 0) {
            echo "<h1>if the user is registered as a tutor before, he should be redirected to the specific page that is specifically designed for him</h1>";
            dd("if the user is registered as a tutor before, he should be redirected to the specific page that is specifically designed for him");
        }

        // if the user wants to register as a tutor and is registered as a student before, he should be redirected to the specific page that is specifically designed for him
        if($request->session()->get('registerGoogleTutor') && User::where('email', '=', $user->email)->where('is_tutor', false)->count() != 0) {
            echo "<h1>if the user is registered as a student before, he should be redirected to the specific page that is specifically designed for him</h1>";
            dd("if the user is registered as a student before, he should be redirected to the specific page that is specifically designed for him");
        }

        $redirectRouteName = $request->session()->get('redirectRouteName');

        $request->session()->flush();
        // get user's information
        $userData['first-name'] = $user->user['given_name'];
        $userData['last-name'] = $user->user['family_name'];
        $userData['email'] = $user->email;
        $userData['google-id'] = $user->id;

        // stores all the information in the session
        $request->session()->put('registerDataStudent', $userData);
        $request->session()->put('emailVerifiedStudent', true);


        return redirect()->route($redirectRouteName);

    }

    // redirect to Google (student register)
    public function redirectToGoogleStudent(Request $request) {
        $request->session()->put('registerGoogleStudent', true);
        $request->session()->put('redirectRouteName', 'register.index.student.3');
        return Socialite::driver('google')->redirect();
    }







}
