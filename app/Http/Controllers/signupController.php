<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;
use Auth;
use App\user;
use App\School_year;


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


    public function signupStudent(Request $request) {
        // TODO: major should exist, year should exist, password should be the same
        // $request->validate([
        //     'firstName' => 'required',
        //     'email' => 'required',
        //     'major' => 'required',
        //     'lastName' => 'required',
        //     'year' => 'required',
        //     'password' => 'required'
        // ]);

        

        $user = new User();        
        $user->first_name = $request->input('firstName');
        $user->last_name = $request->input('lastName');
        $user->email = $request->input('email');
        $user->major = $request->input('major');
        $user->minor = $request->input('minor');
        $user->is_tutor = false;
        $user->password = Hash::make($request->input('password')); // bcrypt
        
        
        $user->school_year_id = School_year::where('school_year', '=', $request->input('schoolYear'))->first()->id;
        
        $user->save();

        
        

        Auth::login($user);

        return redirect()->route('profile_student');
    }

}
