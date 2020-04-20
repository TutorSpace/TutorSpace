<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\School_year;
use App\Major;
use App\User;
use Hash;

class profileController extends Controller
{

    // TODO: fill in the data of the user into subjects/characteristics/courses, sessions, saved, and reviews
    public function show(Request $request) {
        $user = Auth::user();

        $userPhotoUrl = $user->profile_pic_url;
        $subjects = $user->subjects;
        $courses = $user->courses;
        $characteristics = $user->characteristics;
        $upcomingSessions = $user->upcomingSessions(10000);
        $pastSessions = $user->pastSessions();



        if($user->is_tutor) {

            return view('profile.profile_tutor', [
                'user' => $user,
                'subjects' => $subjects,
                'courses' => $courses,
                'characteristics' => $characteristics,
                'userPhotoUrl' => asset("user_photos/{$userPhotoUrl}"),
                'upcomingSessions' => $upcomingSessions,
                'pastSessions' => $pastSessions
            ]);
        }
        else {

            return view('profile.profile_student', [
                'user' => $user,
                'subjects' => $subjects,
                'courses' => $courses,
                'characteristics' => $characteristics,
                'userPhotoUrl' => asset("user_photos/{$userPhotoUrl}"),
                'upcomingSessions' => $upcomingSessions,
                'pastSessions' => $pastSessions
            ]);
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
