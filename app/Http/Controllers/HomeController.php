<?php

namespace App\Http\Controllers;

use Auth;
use App\Post;
use App\User;
use App\Course;
use App\Session;
use Carbon\Carbon;
use Illuminate\Http\Request;

class homeController extends Controller
{
    public function __construct() {
        $this->middleware(['auth']);
    }

    public function index() {

        $posts = Post::with(['tags', 'user'])->withCount(['usersUpvoted', 'replies', 'tags']);

        $user = Auth::user();
        $interestedTagIDs = $user->tags()->pluck('id');
        $posts = $posts->join('post_tag', 'posts.id', '=', 'post_tag.post_id')
                        ->join('tags', 'tags.id', '=', 'post_tag.tag_id')
                        ->whereIn('tags.id', $interestedTagIDs)
                        ->where('posts.user_id', '!=', $user->id)
                        ->groupBy(['posts.id'])
                        ->orderByRaw(POST::POPULARITY_FORMULA)
                        ->take(5)
                        ->get();


        // if there are < 5 posts, put other posts here to fill the 5 spots
        if($posts->count() < 5) {
            $posts = $posts->merge(
                Post::with(['tags', 'user'])
                    ->withCount(['usersUpvoted', 'replies', 'tags'])
                    ->where('posts.user_id', '!=', $user->id)
                    ->orderByRaw(POST::POPULARITY_FORMULA)
                    ->get()
            )->take(5);
        }

        return view('home.index', [
            'posts' => $posts
        ]);


        // $user = Auth::user();

        // // get data of the dashboard
        // $posts = Dashboard_post::select('dashboard_posts.id as post_id', 'user_id', 'course_id', 'post_message', 'subject_id', 'is_course_post', 'dashboard_posts.created_at as post_created_time', 'users.*', 'courses.*', 'subjects.*')
        //         ->join('users', 'users.id', '=', 'user_id')
        //         ->leftJoin('courses', 'course_id', '=', 'courses.id')
        //         ->leftJoin('subjects', 'subject_id', '=', 'subjects.id')
        //         ->where('user_id', '!=', $user->id)
        //         ->get();

        // // get all the subjects and posts that the user is interested in
        // $interestedCourses = $user->courses;
        // $interestedSubjects = $user->subjects;

        // //whenever a user goes to the home page, we need to REMOVE the outdated tutor_requests
        // $mytime = Carbon::now();
        // $tutorRequests = Tutor_request::all();
        // foreach($tutorRequests as $tutorRequest) {
        //     $requestTime = User::getTime($tutorRequest->tutor_session_date, $tutorRequest->start_time);
        //     if($requestTime <= $mytime) {
        //         $tutorRequest->delete();
        //     }
        // }


        // // get total # of unread messages
        // $numUnreadMsgs = User::leftJoin('messages', 'users.id', '=', 'messages.from')
        // ->where('is_read', 0)
        // ->where('to', $user->id)
        // ->where('messages.from', '!=', $user->id)
        // ->count();




        // if($user->is_tutor) {
        //     // get upcoming sessions (at most 4)
        //     $upcomingSessions = $user->upcomingSessions(4);

        //     // get tutor requests
        //     $tutorRequests = Tutor_request::select('tutor_requests.id as tutor_request_id', 'student_id', 'tutor_id', 'course_id', 'subject_id', 'is_course_request', 'start_time', 'end_time', 'tutor_session_date', 'users.*', 'courses.*', 'subjects.*')
        //                     ->join('users', 'users.id', '=', 'tutor_requests.student_id')
        //                     ->leftJoin('courses', 'tutor_requests.course_id', '=', 'courses.id')
        //                     ->leftJoin('subjects', 'tutor_requests.subject_id', '=', 'subjects.id')
        //                     ->where('tutor_id', '=', $user->id)
        //                     ->get();


        //     // build availability calendar
        //     $times = $user->available_times;
        //     $upcomingSessions = $user->upcomingSessions(10000);

        //     return view('home.home_tutor', [
        //         'upcomingSessions' => $upcomingSessions,
        //         'posts' => $posts,
        //         'interestedCourses' => $interestedCourses,
        //         'interestedSubjects' => $interestedSubjects,
        //         'tutorRequests' =>$tutorRequests,
        //         'user' => $user,
        //         'times' => $times,
        //         'upcomingSessions' => $upcomingSessions,
        //         'numUnreadMsgs' => $numUnreadMsgs
        //     ]);

        // }
        // else {
        //     // get all the courses that users are interested in
        //     $course_ids = $user->courses()->pluck('id');

        //     // get recommendations for the courses
        //     $recommendedCourses = Course::select('users.*', 'courses.course')
        //                         ->whereIn('courses.id', $course_ids)
        //                         ->join('course_user', 'course_user.course_id', '=', 'courses.id')
        //                         ->join('users', 'users.id', '=', 'user_id')
        //                         ->where('user_id', '!=', $user->id)
        //                         ->where('is_tutor', '=', '1')
        //                         ->get();



        //     // same for the subjects
        //     $subject_ids = $user->subjects()->pluck('id');
        //     $recommendedSubjects = Subject::select('users.*', 'subjects.subject')
        //                         ->whereIn('subjects.id', $subject_ids)
        //                         ->join('subject_user', 'subject_user.subject_id', '=', 'subjects.id')
        //                         ->join('users', 'users.id', '=', 'user_id')
        //                         ->where('user_id', '!=', $user->id)
        //                         ->where('is_tutor', '=', '1')
        //                         ->get();


        //     // get upcoming sessions (at most 3)
        //     $upcomingSessions = $user->upcomingSessions(3);

        //     // get tutors of the past sessions (at most 2)
        //     $pastTutors = $user->pastTutors(2);


        //     return view('home.home_student', [
        //         'recommendedCourses' => $recommendedCourses,
        //         'recommendedSubjects' => $recommendedSubjects,
        //         'upcomingSessions' => $upcomingSessions,
        //         'pastTutors' => $pastTutors,
        //         'posts' => $posts,
        //         'interestedCourses' => $interestedCourses,
        //         'interestedSubjects' => $interestedSubjects,
        //         'user' => $user,
        //         'numUnreadMsgs' => $numUnreadMsgs
        //     ]);
        // }
    }

    public function tutorSessions() {
        
    }
}
