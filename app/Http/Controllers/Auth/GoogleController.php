<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function __construct() {
        $this->middleware('guest');
    }

    public function handleGoogleCallback(Request $request) {
        try {
            // sending a followup request to google to get the access token and profile info
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            $request->session()->flush();
            return redirect()->route('index')->with([
                'errorMsg' => 'Something went wrong with your Google Sign In. Please try again!'
            ]);
        }

        $redirectRouteName = $request->session()->get('redirectRouteName');
        // true if this email is already registered as a student
        $existStudent = User::existStudent($user->email);
        // true if this email is already registered as a tutor
        $existTutor = User::existTutor($user->email);

        $registerGoogleStudent = $request->session()->has('registerGoogleStudent');
        $registerGoogleTutor = $request->session()->has('registerGoogleTutor');
        $loginGoogleStudent = $request->session()->has('loginGoogleStudent');
        $loginGoogleTutor = $request->session()->has('loginGoogleTutor');

        // todo: remove false here in production
        // only allow people with @usc.edu to login
        if(explode("@", $user->email)[1] !== 'usc.edu' && false){
            // if for registration
            if($registerGoogleStudent){
                return redirect()->route('register.index.student.1')->with([
                    'errorMsg' => 'Please register with your USC Email!'
                ]);
            }
            else if($registerGoogleTutor){
                return redirect()->route('register.index.tutor.1')->with([
                    'errorMsg' => 'Please register with your USC Email!'
                ]);
            }
            else if($loginGoogleStudent){
                return redirect()->route('login.index.student')->with([
                    'errorMsg' => 'Please login with your USC Email!'
                ]);
            }
            else if($loginGoogleTutor){
                return redirect()->route('login.index.tutor')->with([
                    'errorMsg' => 'Please login with your USC Email!'
                ]);
            }
        }

        // if for login
        if($loginGoogleStudent || $loginGoogleTutor) {
            // if this email does not have a student identity
            if($loginGoogleStudent && !$existStudent) {
                return redirect()->route('register.index.student.1')->with([
                    'errorMsg' => 'You have not yet registered with this email as a student. Please sign up first!'
                ]);
            }
            else if($loginGoogleTutor && !$existTutor) {
                return redirect()->route('register.index.tutor.1')->with([
                    'errorMsg' => 'You have not yet registered with this email as a tutor. Please sign up first!'
                ]);
            }

            if ($loginGoogleStudent) {
                Auth::login(User::where('email', '=', $user->email)->where('is_tutor', false)->first());
                // Authentication passed...
                if($redirectRouteName) {
                    return redirect()->route($redirectRouteName)->with([
                        'showWelcome' => true
                    ]);
                }
                else if($request->session()->has('redirectUrl')) {
                    return redirect($request->session()->get('redirectUrl'))->with([
                        'showWelcome' => true
                    ]);
                }
            }
            else if ($loginGoogleTutor) {
                Auth::login(User::where('email', '=', $user->email)->where('is_tutor', true)->first());
                // Authentication passed...
                if($redirectRouteName) {
                    return redirect()->route($redirectRouteName)->with([
                        'showWelcome' => true
                    ]);
                }
                else if($request->session()->has('redirectUrl')) {
                    return redirect($request->session()->get('redirectUrl'))->with([
                        'showWelcome' => true
                    ]);
                }
            }
            else {
                return redirect()->back()->withInput()->with([
                    'passwordError' => 'Your password is incorrect.'
                ]);
            }
        }
        // if for register
        else {
            // error if they're an existing user with the same identity when signing up
            if(($registerGoogleStudent && $existStudent) ||
                ($registerGoogleTutor && $existTutor)){
                return redirect()->route('index')->with([
                    'errorMsg' => 'You already registered as a student/tutor with the same email!'
                ]);
            }

            // if the user wants to register as a student and was registered as a tutor before, he should be redirected to the specific page that is specifically designed for him
            if($registerGoogleStudent && $existTutor) {
                Auth::login(User::where('email', $user->email)->where('is_tutor', $existTutor)->first());

                return redirect()->route('switch-account.register');
            }

            // if the user wants to register as a tutor and is registered as a student before, he should be redirected to the specific page that is specifically designed for him
            if($registerGoogleTutor && $existStudent) {
                echo "<h1>if the user is registered as a student before, he should be redirected to the specific page that is specifically designed for him</h1>";
                dd("if the user is registered as a student before, he should be redirected to the specific page that is specifically designed for him");
            }

            // clear all the session data
            $request->session()->flush();

            // get user's information
            $userData['first-name'] = $user->user['given_name'];
            $userData['last-name'] = $user->user['family_name'];
            $userData['email'] = $user->email;
            $userData['google-id'] = $user->id;

            if($registerGoogleStudent) {
                // stores all the information in the session
                $request->session()->put('registerDataStudent', $userData);
                $request->session()->put('emailVerifiedStudent', true);
            }
            else if($registerGoogleTutor) {
                // stores all the information in the session
                $request->session()->put('registerDataTutor', $userData);
                $request->session()->put('emailVerifiedTutor', true);
            }
        }

        return redirect()->route($redirectRouteName);
    }

    // redirect to Google (student register)
    public function registerRedirectToGoogleStudent(Request $request) {
        $request->session()->flush();
        $request->session()->put('registerGoogleStudent', true);
        $request->session()->put('redirectRouteName', 'register.index.student.3');
        return Socialite::driver('google')->redirect();
    }

    // redirect to Google (student login)
    public function loginRedirectToGoogleStudent(Request $request) {
        $request->session()->flush();
        $request->session()->put('loginGoogleStudent', true);

        if($request->query('backUrl')) {
            $request->session()->put('redirectUrl', $request->query('backUrl'));
        }
        else {
            $request->session()->put('redirectRouteName', 'home');
        }
        return Socialite::driver('google')->redirect();
    }

    // redirect to Google (tutor register)
    public function registerRedirectToGoogleTutor(Request $request) {
        $request->session()->flush();
        $request->session()->put('registerGoogleTutor', true);
        $request->session()->put('redirectRouteName', 'register.index.tutor.3');
        return Socialite::driver('google')->redirect();
    }

    // redirect to Google (tutor login)
    public function loginRedirectToGoogleTutor(Request $request) {
        $request->session()->flush();
        $request->session()->put('loginGoogleTutor', true);

        if($request->query('backUrl')) {
            $request->session()->put('redirectUrl', $request->query('backUrl'));
        }
        else {
            $request->session()->put('redirectRouteName', 'home');
        }

        return Socialite::driver('google')->redirect();
    }


}
