<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;
use Auth;
use App\User;
use App\School_year;
use App\Major;


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
        

        // TODO: password should be the same
        $request->validate([
            'firstName' => ['required'],
            'lastName' => ['required'],
            'email' => [
                'required',
                'email:rfc'
            ],
            
            'schoolYear' => [
                'required', 
                'exists:school_years,school_year'
            ],
            'major' => [
                'required', 
                'exists:majors,major'
            ], 
            'password-check' => [
                'required',
                'same:password'
            ],
            'minor' => ['nullable']
        ]);

        

        $user = new User();        
        $user->first_name = $request->input('firstName');
        $user->last_name = $request->input('lastName');
        $user->email = $request->input('email');

        
        $user->minor = $request->input('minor');
        $user->is_tutor = false;
        $user->password = Hash::make($request->input('password')); // bcrypt
        
        $user->major_id = Major::where('major', '=', $request->input('major'))->first()->id;

        $user->school_year_id = School_year::where('school_year', '=', $request->input('schoolYear'))->first()->id;
        

        $user->save();

        
        

        Auth::login($user);

        return redirect()->route('profile_student');
    }

}
