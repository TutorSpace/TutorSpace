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

        dd(User::find(8)->getRating());

    }
}
