<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Session;
use App\Course;
use App\Subject;
use App\User;
use App\Dashboard_post;
use App\Tutor_request;


class homeController extends Controller
{
    public function show() {
        $user = Auth::user();


        // get data of the dashboard
        $posts = Dashboard_post::select('dashboard_posts.id as post_id', 'user_id', 'course_id', 'post_message', 'subject_id', 'is_course_post', 'dashboard_posts.created_at as post_created_time', 'users.*', 'courses.*', 'subjects.*')
                ->join('users', 'users.id', '=', 'user_id')
                ->leftJoin('courses', 'course_id', '=', 'courses.id')
                ->leftJoin('subjects', 'subject_id', '=', 'subjects.id')
                ->where('user_id', '!=', $user->id)
                ->get();

        // get all the subjects and posts that the user is interested in
        $interestedCourses = $user->courses;
        $interestedSubjects = $user->subjects;


        if($user->is_tutor) {
            // get upcoming sessions (at most 4)
            $upcomingSessions = $user->upcomingSessions(4);

            // get tutor requests
            $tutorRequests = Tutor_request::select('tutor_requests.id as tutor_request_id', 'student_id', 'tutor_id', 'course_id', 'subject_id', 'is_course_request', 'start_time', 'end_time', 'tutor_session_date', 'users.*', 'courses.*', 'subjects.*')
                            ->join('users', 'users.id', '=', 'tutor_requests.student_id')
                            ->leftJoin('courses', 'tutor_requests.course_id', '=', 'courses.id')
                            ->leftJoin('subjects', 'tutor_requests.subject_id', '=', 'subjects.id')
                            ->where('tutor_id', '=', $user->id)
                            ->get();


            // build availability calendar
            $times = $user->available_times;
            $upcomingSessions = $user->upcomingSessions(10000);

            return view('home.home_tutor', [
                'upcomingSessions' => $upcomingSessions,
                'posts' => $posts,
                'interestedCourses' => $interestedCourses,
                'interestedSubjects' => $interestedSubjects,
                'tutorRequests' =>$tutorRequests,
                'user' => $user,
                'times' => $times,
                'upcomingSessions' => $upcomingSessions
            ]);

        }
        else {
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





            return view('home.home_student', [
                'recommendedCourses' => $recommendedCourses,
                'recommendedSubjects' => $recommendedSubjects,
                'upcomingSessions' => $upcomingSessions,
                'pastTutors' => $pastTutors,
                'posts' => $posts,
                'interestedCourses' => $interestedCourses,
                'interestedSubjects' => $interestedSubjects,
                'user' => $user
            ]);
        }
    }
}
