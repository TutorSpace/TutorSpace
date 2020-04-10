<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\School_year;
use App\Major;
use Hash;

class profileController extends Controller
{

    // TODO: fill in the data of the user into subjects/characteristics/courses, sessions, saved, and reviews
    public function show(Request $request) {
        $user = Auth::user();
        if($user->is_tutor) {
            return view('profile.profile_tutor');
        }
        else {
            return view('profile.profile_student');
        }
        
    }

    // TODO: fill in the data of the user into inputs
    public function showEdit() {
        $user = Auth::user();
        if($user->is_tutor) {
            return view('profile.edit_profile_tutor');
        }
        else {
            
            return view('profile.edit_profile_student');
        }
    }

    public function editProfile(Request $request) {
        $user = Auth::user();
        if($user->is_tutor) {

        }
        else {
            // TODO: check for profile image
            $request->validate([
                'fullName' => ['
                    required'
                ],
                'password' => [
                    'required'
                ],
                'schoolYear' => [
                    'required', 
                    'exists:school_years,school_year'
                ],
                'major' => [
                    'required', 
                    'exists:majors,major'
                ],
                'minor' => [
                    'nullable'
                ]
            ]);

            $user->full_name = $request->input('fullName');
            $user->password = Hash::make($request->input('password'));
            $user->minor = $request->input('minor');

            $user->major_id = Major::where('major', '=', $request->input('major'))->first()->id;

            $user->school_year_id = School_year::where('school_year', '=', $request->input('schoolYear'))->first()->id;

            $user->save();

            return redirect()->route('edit_profile')->with('success', 'Your profile is updated successfully!');
        }
    }

    
}
