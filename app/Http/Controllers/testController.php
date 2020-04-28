<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Subject;
use App\Characteristic;
use App\Bookmark;
use App\Dashboard_post;
use Auth;
use App\Tutor_request;
use App\Session;
use App\Course;

use Carbon\Carbon;

use App\NewMessage;

class testController extends Controller
{
    public function test() {

        // Sarah: dd() is laravel's way of php's dump. In your browser, go to localhost:8000/test and then this function will run. Whenever you want to test syntax, the easiest way would be go to 'localhost:8000/test', and run your test inside this function. Use this function to play around with the Database syntax


        // dd(User::find(5)->users);
        // dd(User::find(2)->upcomingSessions());


        // dd(Dashboard_post::find(2)->user);
        // dd(Dashboard_post::with('user')->first());
        // dd(Dashboard_post::join('users', 'users.id', '=', 'user_id')->where('users.is_tutor', 1)->get());

        $user = Auth::user();
        // get all the interested courses and subjects of the users
        $course_ids = $user->courses()->pluck('id');
        $subject_ids = $user->subjects()->pluck('id');


        // $posts = Dashboard_post::join('users', 'users.id', '=', 'user_id')
        //                 ->leftJoin('courses', function($join) {
        //                     $join->on('course_id', '=', 'courses.id')
        //                         ->where('is_course_post', '=', 1);
        //                 })
        //                 ->leftJoin('subjects', function($join) {
        //                     $join->on('subject_id', '=', 'subjects.id')
        //                         ->where('is_course_post', '=', 0);
        //                 })
        //                 ->get();

        // $post = Dashboard_post::select('dashboard_posts.id as post_id', 'user_id', 'course_id', 'post_message', 'subject_id', 'is_course_post', 'dashboard_posts.created_at as post_created_time', 'users.*', 'courses.*', 'subjects.*')
        //                 ->join('users', 'users.id', '=', 'user_id')
        //                 ->leftJoin('courses', 'course_id', '=', 'courses.id')
        //                 ->leftJoin('subjects', 'subject_id', '=', 'subjects.id')
        //                 ->get();

        // $interestedCourses = $user->courses;

        // dd($interestedCourses);

        // dd(User::find(8)->getRating());
        // dd(Session::find(3)->courseSubject());
        $navInput = "";
        // $nameResults = User::where('full_name', 'like', "%{$navInput}%")->get();
        // dd($nameResults);

        // $navInput = "it";
        // $course_ids = Course::where('course', 'like', "%{$navInput}%")->pluck('id');
        // dd($course_ids);


        // // get all the courses with matched input
        // $course_ids = Course::where('course', 'like', "%{$navInput}%")->pluck('id');

        // // get all the users who are interested in those courses
        // $courseUserResults = Course::select('users.*')
        //                     ->join('course_user', 'course_user.course_id', '=', 'courses.id')
        //                     ->join('users', 'users.id', '=', 'course_user.user_id')
        //                     ->where('is_tutor', '=', '0')
        //                     ->whereIn('courses.id', $course_ids)
        //                     ->get();
        // // dd($courseUserResults);

        // $nameUserResults = User::where('full_name', 'like', "%{$navInput}%")
        // ->where('is_tutor', '=', !$user->is_tutor)
        // ->get();

        // // 2. course
        // // get all the courses with matched input
        // $course_ids = Course::where('course', 'like', "%{$navInput}%")->pluck('id');

        // // get all the users who are interested in those courses
        // $courseUserResults = Course::select('users.*')
        //             ->join('course_user', 'course_user.course_id', '=', 'courses.id')
        //             ->join('users', 'users.id', '=', 'course_user.user_id')
        //             ->where('is_tutor', '=', !$user->is_tutor)
        //             ->whereIn('courses.id', $course_ids)
        //             ->get();

        // // 3. subject
        // // get all the subjects with matched input
        // $subject_ids = Subject::where('subject', 'like', "%{$navInput}%")->pluck('id');

        // // get all the users who are interested in those subjects
        // $subjectUserResults = Subject::select('users.*')
        //             ->join('subject_user', 'subject_user.subject_id', '=', 'subjects.id')
        //             ->join('users', 'users.id', '=', 'subject_user.user_id')
        //             ->where('is_tutor', '=', !$user->is_tutor)
        //             ->whereIn('subjects.id', $subject_ids)
        //             ->get();

        // $test = $nameUserResults->merge($courseUserResults)->merge($subjectUserResults);
        // dd($test);

        // $mytime = Carbon::now();
        // // dd($mytime->toDateTimeString());

        // $outdatedSessions = Session::where('is_upcoming', 1)
        //             ->where('is_canceled', 0)
        //             ->get();

        // foreach($outdatedSessions as $outdatedSession) {
        //     $sessionTime = User::getTime($outdatedSession->date, $outdatedSession->start_time);
        //     if($sessionTime <= $mytime) {
        //         $outdatedSession->delete();
        //     }
        // }


        event(new NewMessage('hi!'));
    }
}
