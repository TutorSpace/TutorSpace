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
            // SARAH: get the student information and put it into the profile_student page. Let's first try getting the user's name.
            


            return view('profile.profile_student');

            // Sarah: instead of 'return view('profile.profile_student');', you can refer to the return statement in function showEdit(). it is returning an array of variables. So in this way, you can pass the username to 'profile_student.blade.php'. Please refer to my notes in 'profile_student.blade.php'
        }
        
    }

    // TODO: fill in the data of the user's photo
    public function showEdit() {
        $user = Auth::user();
        $fullName = $user->full_name;
        $email = $user->email;
        $major = Major::where('id', '=', $user->major_id)->first()->major;
        $minor = $user->minor;
        $year = School_year::where('id', '=', $user->school_year_id)->first()->school_year;

        if($user->is_tutor) {
            $gpa = $user->gpa;
            $hourlyRate = $user->hourly_rate;
            return view('profile.edit_profile_tutor', [
                'fullName' => $fullName,
                'email' => $email,
                'major' => $major,
                'minor' => $minor,
                'year' => $year,
                'gpa' => $gpa,
                'hourlyRate' => $hourlyRate
            ]);
        }
        else {
            return view('profile.edit_profile_student', [
                'fullName' => $fullName,
                'email' => $email,
                'major' => $major,
                'minor' => $minor,
                'year' => $year
            ]);
        }
    }

    public function editProfile(Request $request) {
        $user = Auth::user();
        if($user->is_tutor) {
            // TODO: check for profile image
            $request->validate([
                'fullName' => ['
                    required'
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
                ],
                'hourlyRate' => [
                    'required',
                    'numeric'
                ],
                'gpa' => [
                    'nullable',
                    'numeric'
                ]
            ]);

            $user->full_name = $request->input('fullName');
            $user->password = Hash::make($request->input('password'));
            $user->minor = $request->input('minor');

            $user->major_id = Major::where('major', '=', $request->input('major'))->first()->id;

            $user->school_year_id = School_year::where('school_year', '=', $request->input('schoolYear'))->first()->id;

            $user->hourly_rate = substr($request->input('hourlyRate'), 0, 4);
            $user->gpa = substr($request->input('gpa'), 0, 4);

            $user->save();

            return redirect()->route('edit_profile')->with('success', 'Your profile is updated successfully!');
        }
        else {
            // TODO: check for profile image
            $request->validate([
                'fullName' => ['
                    required'
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
