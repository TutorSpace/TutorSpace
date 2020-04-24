<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Dashboard_post;
use App\Tutor_request;
use App\Session;
use Carbon\Carbon;
use App\User;

class generalController extends Controller
{
    // TODO: add validation
    public function removeBookmark(Request $request) {


        $userId = $request->input('user_id');

        $user = Auth::user();
        $user->bookmarks()->detach($userId);

        return response()->json(
            [
                'successMsg' => 'Successfully removed from bookmarked users list!'
            ]
        );
    }

    // TODO: add validation
    public function addBookmark(Request $request) {

        $userId = $request->input('user_id');

        $user = Auth::user();
        $user->bookmarks()->attach($userId);

        return response()->json(
            [
                'successMsg' => 'Successfully added to bookmarked users list!'
            ]
        );
    }

    // TODO: add validation
    public function getDashboardPosts(Request $request) {
        $courseSubject = $request->input('courseSubject');
        $tutorStudent = $request->input('tutorStudent');

        $posts;
        $user = Auth::user();

        if($tutorStudent === 'my-posts') {
            $posts = Dashboard_post::select('dashboard_posts.id as post_id', 'user_id', 'course_id', 'post_message', 'subject_id', 'is_course_post', 'dashboard_posts.created_at as post_created_time', 'users.*', 'courses.*', 'subjects.*')
                    ->join('users', 'users.id', '=', 'user_id')
                    ->leftJoin('courses', 'course_id', '=', 'courses.id')
                    ->leftJoin('subjects', 'subject_id', '=', 'subjects.id')
                    ->where('user_id', '=', $user->id)
                    ->get();
        }
        else if($courseSubject === 'all-courses-subjects') {
            if($tutorStudent === 'tutor-student-posts') {

                // another way to do it, but seems unnecessary
                // $posts = Dashboard_post::join('users', 'users.id', '=', 'user_id')
                //         ->leftJoin('courses', function($join) {
                //             $join->on('course_id', '=', 'courses.id')
                //                 ->where('is_course_post', '=', 1);
                //         })
                //         ->leftJoin('subjects', function($join) {
                //             $join->on('subject_id', '=', 'subjects.id')
                //                 ->where('is_course_post', '=', 0);
                //         })
                //         ->get();

                $posts = Dashboard_post::select('dashboard_posts.id as post_id', 'user_id', 'course_id', 'post_message', 'subject_id', 'is_course_post', 'dashboard_posts.created_at as post_created_time', 'users.*', 'courses.*', 'subjects.*')
                        ->join('users', 'users.id', '=', 'user_id')
                        ->leftJoin('courses', 'course_id', '=', 'courses.id')
                        ->leftJoin('subjects', 'subject_id', '=', 'subjects.id')
                        ->where('user_id', '!=', $user->id)
                        ->get();

            }
            else if($tutorStudent === 'tutor-posts') {
                $posts = Dashboard_post::select('dashboard_posts.id as post_id', 'user_id', 'course_id', 'post_message', 'subject_id', 'is_course_post', 'dashboard_posts.created_at as post_created_time', 'users.*', 'courses.*', 'subjects.*')
                        ->join('users', 'users.id', '=', 'user_id')
                        ->leftJoin('courses', 'course_id', '=', 'courses.id')
                        ->leftJoin('subjects', 'subject_id', '=', 'subjects.id')
                        ->where('users.is_tutor', 1)
                        ->where('user_id', '!=', $user->id)
                        ->get();
            }
            else if($tutorStudent === 'student-posts') {
                $posts = Dashboard_post::select('dashboard_posts.id as post_id', 'user_id', 'course_id', 'post_message', 'subject_id', 'is_course_post', 'dashboard_posts.created_at as post_created_time', 'users.*', 'courses.*', 'subjects.*')
                        ->join('users', 'users.id', '=', 'user_id')
                        ->leftJoin('courses', 'course_id', '=', 'courses.id')
                        ->leftJoin('subjects', 'subject_id', '=', 'subjects.id')
                        ->where('users.is_tutor', 0)
                        ->where('user_id', '!=', $user->id)
                        ->get();
            }
        }
        else if($courseSubject === 'my-courses-subjects') {
            $user = Auth::user();
            // get all the interested courses and subjects of the users
            $course_ids = $user->courses()->pluck('id');
            $subject_ids = $user->subjects()->pluck('id');

            if($tutorStudent === 'tutor-student-posts') {
                $posts = Dashboard_post::select('dashboard_posts.id as post_id', 'user_id', 'course_id', 'post_message', 'subject_id', 'is_course_post', 'dashboard_posts.created_at as post_created_time', 'users.*', 'courses.*', 'subjects.*')
                        ->join('users', 'users.id', '=', 'user_id')
                        ->leftJoin('courses', 'course_id', '=', 'courses.id')
                        ->leftJoin('subjects', 'subject_id', '=', 'subjects.id')
                        ->where(function($query) use($course_ids, $subject_ids) {
                            $query->whereIn('course_id', $course_ids)
                                ->orWhereIn('subject_id', $subject_ids);
                        })
                        ->where('user_id', '!=', $user->id)
                        ->get();
            }
            else if($tutorStudent === 'tutor-posts') {
                // nested where so that course_id and subject_id are grouped together (execution order)
                $posts = Dashboard_post::select('dashboard_posts.id as post_id', 'user_id', 'course_id', 'post_message', 'subject_id', 'is_course_post', 'dashboard_posts.created_at as post_created_time', 'users.*', 'courses.*', 'subjects.*')
                        ->join('users', 'users.id', '=', 'user_id')
                        ->leftJoin('courses', 'course_id', '=', 'courses.id')
                        ->leftJoin('subjects', 'subject_id', '=', 'subjects.id')
                        ->where('users.is_tutor', 1)
                        ->where(function($query) use($course_ids, $subject_ids) {
                            $query->whereIn('course_id', $course_ids)
                                ->orWhereIn('subject_id', $subject_ids);
                        })
                        ->where('user_id', '!=', $user->id)
                        ->get();

            }
            else if($tutorStudent === 'student-posts') {
                $posts = Dashboard_post::select('dashboard_posts.id as post_id', 'user_id', 'course_id', 'post_message', 'subject_id', 'is_course_post', 'dashboard_posts.created_at as post_created_time', 'users.*', 'courses.*', 'subjects.*')
                        ->join('users', 'users.id', '=', 'user_id')
                        ->leftJoin('courses', 'course_id', '=', 'courses.id')
                        ->leftJoin('subjects', 'subject_id', '=', 'subjects.id')
                        ->where('users.is_tutor', 0)
                        ->where(function($query) use($course_ids, $subject_ids) {
                            $query->whereIn('course_id', $course_ids)
                                ->orWhereIn('subject_id', $subject_ids);
                        })
                        ->where('user_id', '!=', $user->id)
                        ->get();
            }
        }

        return response()->json(
            [
                'posts' => json_encode($posts)
            ]
        );
    }

    // TODO: add validation
    public function addDashboardPosts(Request $request) {
        $postMsg = $request->input('postMsg');
        $inputCourseSubject = $request->input('inputCourseSubject');
        $isCourse = explode("-", $inputCourseSubject)[0] === 'course';
        $courseSubjectId = explode("-", $inputCourseSubject)[1];
        // list($isCourse, $courseSubjectId) = split("-", $inputCourseSubjec);


        $user = Auth::user();
        $dashboardPost = new Dashboard_post();
        $dashboardPost->user_id = $user->id;
        $dashboardPost->post_message = $postMsg;
        $dashboardPost->is_course_post = $isCourse;
        if($isCourse) {
            $dashboardPost->course_id = $courseSubjectId;
        }
        else {
            $dashboardPost->subject_id = $courseSubjectId;
        }
        $dashboardPost->save();


        return response()->json(
            [
                'successMsg' => 'Successfully added the post!'
            ]
        );
    }

    // TODO: add validation
    public function acceptTutorRequest(Request $request) {
        $user = Auth::user();
        $tutorRequestId = $request->input('tutor_request_id');

        $tutorRequest = Tutor_request::find($tutorRequestId);

        // Must not accept the tutor if it is outdated
        $mytime = Carbon::now();
        $requestTime = User::getTime($tutorRequest->tutor_session_date, $tutorRequest->start_time);
        if($requestTime <= $mytime) {
            $tutorRequest->delete();
            return response()->json(
                [
                    'errorMsg' => 'The tutor request is outdated! Going to remove it automatically!'
                ]
            );
        }

        // Must not accept the tutor request if it conflicts with a scheduled session
        $upcomingSessions = $user->upcomingSessions(1000);
        foreach($upcomingSessions as $upcomingSession) {
            $upcomingSessionStartTime = User::getTime($upcomingSession->date, $upcomingSession->start_time);
            $upcomingSessionEndTime = User::getTime($upcomingSession->date, $upcomingSession->end_time);

            $requestTimeEnd = User::getTime($tutorRequest->tutor_session_date, $tutorRequest->end_time);

            // if it conflicts
            if(($requestTime >= $upcomingSessionStartTime && $requestTime <= $upcomingSessionEndTime) || ($requestTimeEnd >= $upcomingSessionStartTime && $requestTimeEnd <= $upcomingSessionEndTime)) {
                $tutorRequest->delete();
                return response()->json(
                    [
                        'errorMsg' => 'The tutor request is conflicted with an already scheduled tutor session! Going to remove it automatically!'
                    ]
                );
            }
        }


        $session = new Session();
        $session->tutor_id = $tutorRequest->tutor_id;
        $session->student_id = $tutorRequest->student_id;
        $session->is_course = $tutorRequest->is_course_request;
        $session->course_id = $tutorRequest->course_id;
        $session->subject_id = $tutorRequest->subject_id;
        $session->start_time = $tutorRequest->start_time;
        $session->end_time = $tutorRequest->end_time;
        $session->date = $tutorRequest->tutor_session_date;
        $session->is_upcoming = 1;
        $session->save();

        Tutor_request::find($tutorRequestId)->delete();

        return response()->json(
            [
                'successMsg' => 'Successfully accepted the tutor request!'
            ]
        );

    }

    // TODO: add validation
    public function rejectTutorRequest(Request $request) {
        $tutorRequestId = $request->input('tutor_request_id');

        Tutor_request::find($tutorRequestId)->delete();

        return response()->json(
            [
                'successMsg' => 'Successfully rejected the tutor request!'
            ]
        );
    }




}
