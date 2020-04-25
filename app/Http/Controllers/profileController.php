<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\School_year;
use App\Major;
use App\User;
use Hash;
use App\Review;

class profileController extends Controller
{
    public function show(Request $request) {
        $user = Auth::user();

        $userPhotoUrl = $user->profile_pic_url;
        $subjects = $user->subjects;
        $courses = $user->courses;
        $characteristics = $user->characteristics;
        $upcomingSessions = $user->upcomingSessions(10000);
        $pastSessions = $user->pastSessions();

        if($user->is_tutor) {
            // get reviews the user is being reviewed
            $reviews = $user->being_reviews;
            $reviewTotalRating = $user->getRating();

            return view('profile.profile_tutor', [
                'user' => $user,
                'subjects' => $subjects,
                'courses' => $courses,
                'characteristics' => $characteristics,
                'userPhotoUrl' => asset("user_photos/{$userPhotoUrl}"),
                'upcomingSessions' => $upcomingSessions,
                'pastSessions' => $pastSessions,
                'reviews' => $reviews,
                'reviewTotalRating' => $reviewTotalRating
            ]);
        }
        else {
            // get bookmarked tutors
            $bookmarks = $user->bookmarks;

            // get reviews the user wrote
            $reviews = $user->written_reviews;
            $reviewTotalRating = $user->getRatingAsReviewer();

            return view('profile.profile_student', [
                'user' => $user,
                'subjects' => $subjects,
                'courses' => $courses,
                'characteristics' => $characteristics,
                'userPhotoUrl' => asset("user_photos/{$userPhotoUrl}"),
                'upcomingSessions' => $upcomingSessions,
                'pastSessions' => $pastSessions,
                'bookmarks' => $bookmarks,
                'reviews' => $reviews,
                'reviewTotalRating' => $reviewTotalRating
            ]);
        }
    }




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
                'hourlyRate' => $hourlyRate,
                'user' => $user
            ]);
        }
        else {
            return view('profile.edit_profile_student', [
                'fullName' => $fullName,
                'email' => $email,
                'major' => $major,
                'minor' => $minor,
                'year' => $year,
                'user' => $user
            ]);
        }
    }

    public function editProfile(Request $request) {
        $user = Auth::user();
        if($user->is_tutor) {
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
                ],
                'profile-pic' => [
                    'file',
                    'mimes:jpeg,bmp,png'
                ]

            ]);

            $user->full_name = $request->input('fullName');
            $user->minor = $request->input('minor');

            $user->major_id = Major::where('major', '=', $request->input('major'))->first()->id;

            $user->school_year_id = School_year::where('school_year', '=', $request->input('schoolYear'))->first()->id;

            $user->hourly_rate = substr($request->input('hourlyRate'), 0, 4);
            $user->gpa = substr($request->input('gpa'), 0, 4);


            $this->saveProfilePic($request, $user);

            $user->save();

            return redirect()->route('edit_profile')->with('success', 'Your profile is updated successfully!');
        }
        else {
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
                'profile-pic' => [
                    'file',
                    'mimes:jpeg,bmp,png'
                ]
            ]);



            $user->full_name = $request->input('fullName');
            $user->minor = $request->input('minor');

            $user->major_id = Major::where('major', '=', $request->input('major'))->first()->id;

            $user->school_year_id = School_year::where('school_year', '=', $request->input('schoolYear'))->first()->id;

            $this->saveProfilePic($request, $user);

            $user->save();


            return redirect()->route('edit_profile')->with('success', 'Your profile is updated successfully!');
        }
    }

    private function saveProfilePic(&$request, &$user) {
        // if user uploaded the file
        if($request->file('profile-pic')) {
            $imgURL = $request->file('profile-pic')->store('');
            $user->profile_pic_url = $imgURL;
        }
        else {
            $user->profile_pic_url = 'placeholder.png';
        }
    }

    public function viewProfile(Request $request, $viewUserId) {
        $from = $request->input('from');

        $currentUser = Auth::user();
        $viewUser = User::find($viewUserId);

        if($currentUser->is_tutor == $viewUser->is_tutor) {

            return redirect()->route('home');
        }

        $subjects = $viewUser->subjects;
        $courses = $viewUser->courses;
        $characteristics = $viewUser->characteristics;

        // get reviews the user is being reviewed
        $reviews = $viewUser->being_reviews;
        $reviewTotalRating = $viewUser->getRating();

        if(!$viewUser->is_tutor) {

            return view('profile.view_student_profile', [
                'from' => $from,
                'user' => $currentUser,
                'viewUser' => $viewUser,
                'subjects' => $subjects,
                'courses' => $courses,
                'characteristics' => $characteristics,
                'reviews' => $reviews,
                'reviewTotalRating' => $reviewTotalRating
            ]);
        }
        else {

            return view('profile.view_tutor_profile', [
                'from' => $from,
                'user' => $currentUser,
                'viewUser' => $viewUser,
                'subjects' => $subjects,
                'courses' => $courses,
                'characteristics' => $characteristics,
                'reviews' => $reviews,
                'reviewTotalRating' => $reviewTotalRating
            ]);
        }
    }

}
