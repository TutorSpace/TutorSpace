<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Session;
use App\Course;
use App\Subject;


class homeController extends Controller
{
    public function show() {
        $user = Auth::user();


        if($user->is_tutor) {
            return view('home.home_tutor');
        }
        else {
            // choose randomly from subjects and courses the user is interested in, and display all of them. (If there is no courses/subjects the user interested, show nothing for that specific one)

            // get all the courses that users are interested in
            $course_ids = $user->courses()->pluck('id');

            // get recommendations for the courses
            $recommendedCourses = Course::select('users.*', 'courses.course')
                                ->whereIn('courses.id', $course_ids)
                                ->join('course_user', 'course_user.course_id', '=', 'courses.id')
                                ->join('users', 'users.id', '=', 'user_id')
                                ->where('user_id', '!=', $user->id)
                                ->where('is_tutor', '=', '1')
                                ->get();



            // same for the subjects
            $subject_ids = $user->subjects()->pluck('id');
            $recommendedSubjects = Subject::select('users.*', 'subjects.subject')
                                ->whereIn('subjects.id', $subject_ids)
                                ->join('subject_user', 'subject_user.subject_id', '=', 'subjects.id')
                                ->join('users', 'users.id', '=', 'user_id')
                                ->where('user_id', '!=', $user->id)
                                ->where('is_tutor', '=', '1')
                                ->get();



            // get upcoming sessions (at most 2)
            $upcomingSessions = $user->upcomingSessions(2);


            // get tutors of the past sessions (at most 2)
            $pastTutors = $user->pastTutors(2);


            // TODO: get data of the dashboard




            return view('home.home_student', [
                'recommendedCourses' => $recommendedCourses,
                'recommendedSubjects' => $recommendedSubjects,
                'upcomingSessions' => $upcomingSessions,
                'pastTutors' => $pastTutors
            ]);
        }
    }
}
