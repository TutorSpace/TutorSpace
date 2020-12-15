<?php

namespace App\Http\Controllers;

use Auth;

use App\Tag;
use App\Test;
use App\User;
use App\View;
use App\Reply;
use App\Course;
use App\Message;
use App\Session;
use App\Subject;
use App\Bookmark;
use App\Chatroom;

use Carbon\Carbon;

use App\TutorRequest;
use Facades\App\Post;
use App\Characteristic;
use App\Events\NewMessage;
use App\CourseVerification;
use App\Events\NewChatroom;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Notifications\EmailVerification;

use Illuminate\Support\Facades\Notification;
use App\Notifications\TutorVerificationNotification;
use App\Notifications\Forum\MarkedAsBestReplyNotification;

class testController extends Controller
{
    public function __construct() {
        // Auth::login(User::find(2));
        // $this->middleware('auth');
    }
    public function action(Request $request){


    }
    public function index(Request $request) {

        broadcast(new NewChatroom(User::find(2)));
        // return view('test');

    }

    public function index2(Request $request) {

    }

    public function test(Request $request) {
        $users = User::select("id")->where('is_tutor','1')->get();
        $test = CourseVerification::select("*")->get();

        $testCount = count($test);

        $verifiedUsersQuery = DB::table('course_user')->select("course_user.user_id")
                        ->join("course_verifications", function($join){
                            $join->on("course_verifications.course_id","=","course_user.course_id")
                        ->on("course_verifications.user_id","=","course_user.user_id");
                        })
                        ->distinct();


        User::whereIn('id',$verifiedUsersQuery)->update([
            'is_tutor_verified' => '1'
            ]);

        User::whereNotIn('id',$verifiedUsersQuery)->update([
            'is_tutor_verified' => '0'
            ]);
        // $user = DB::table('course_user')->select("course_user.user_id")
        //         // ->join("items","items.user_id","=","users.id")
        //         ->join("jobs",function($join){
        //             $join->on("jobs.user_id","=","users.id")
        //                 ->on("jobs.item_id","=","items.id");
        //         })
        //         ->get();
        dd($verifiedUsersQuery->get());

        // $user = Auth::user();
        // $user->notify(new TutorVerificationNotification(false));
        // Notification::route('mail', "huan773@usc.edu")
        //     ->notify(new TutorVerificationNotification());
        // dd($test);

        // dd(User::find(5)->users);
        // dd(User::find(2)->upcomingSessions());


        // dd(Dashboard_post::find(2)->user);
        // dd(Dashboard_post::with('user')->first());
        // dd(Dashboard_post::join('users', 'users.id', '=', 'user_id')->where('users.is_tutor', 1)->get());

        // $user = Auth::user();
        // get all the interested courses and subjects of the users
        // $course_ids = $user->courses()->pluck('id');
        // $subject_ids = $user->subjects()->pluck('id');


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
        // $navInput = "";
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


        // event(new NewMessage('hi!'));

        // return view('test');
        // Auth::logout();
        // dd(Auth::user());

        // return view('auth.passwords.reset_student');

        // dd(Storage::url('csCKCYY5gO9oDR9momyshOT05ZE0tzzLriOUYYlX.png'));

        // $path = $request->file('avatar')->storeAs(
        //     '', 'placeholder.png'
        // );


        // return $path;


    }

    public function testForum(Request $request) {

    }
}
