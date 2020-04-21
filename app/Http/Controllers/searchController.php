<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Course;
use App\Subject;

class searchController extends Controller
{
    public function show(Request $request) {
        $user = Auth::user();
        $nameUserResults;
        $courseUserResults;
        $subjectUserResults;

        // if the user searches using the nav bar
        if($request->has('navInput')) {
            $navInput = trim($request->input('navInput'));

            // get students/tutors that match the navInput in name, course, and subjects
            // 1. name
            $nameUserResults = User::where('full_name', 'like', "%{$navInput}%")
                            ->where('is_tutor', '=', !$user->is_tutor)
                            ->get();

            // 2. course
            // get all the courses with matched input
            $course_ids = Course::where('course', 'like', "%{$navInput}%")->pluck('id');

            // get all the users who are interested in those courses
            $courseUserResults = Course::select('users.*')
                                ->join('course_user', 'course_user.course_id', '=', 'courses.id')
                                ->join('users', 'users.id', '=', 'course_user.user_id')
                                ->where('is_tutor', '=', !$user->is_tutor)
                                ->whereIn('courses.id', $course_ids)
                                ->get();

            // 3. subject
            // get all the subjects with matched input
            $subject_ids = Subject::where('subject', 'like', "%{$navInput}%")->pluck('id');

            // get all the users who are interested in those subjects
            $subjectUserResults = Subject::select('users.*')
                                ->join('subject_user', 'subject_user.subject_id', '=', 'subjects.id')
                                ->join('users', 'users.id', '=', 'subject_user.user_id')
                                ->where('is_tutor', '=', !$user->is_tutor)
                                ->whereIn('subjects.id', $subject_ids)
                                ->get();
        }
        // if the user searches by going to the searching page
        else if($request->has('searchInput')){
            $searchInput = $request->input('searchInput');

            if($user->is_tutor) {

            }
            else {

            }
        }
        else {
            return redirect()->route('home');
        }

        if($user->is_tutor) {
            return view('search.search_for_student', [
                'user' => $user,
                'results' => $nameUserResults->merge($courseUserResults)->merge($subjectUserResults)
            ]);
        }
        else {
            return view('search.search_for_tutor', [
                'user' => $user,
                'results' => $nameUserResults->merge($courseUserResults)->merge($subjectUserResults)
            ]);
        }
    }
}
