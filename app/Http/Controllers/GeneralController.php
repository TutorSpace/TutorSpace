<?php

namespace App\Http\Controllers;

use Auth;

use App\User;
use App\Session;
use Carbon\Carbon;
use App\ReportForum;
use App\Tutor_request;
use App\Dashboard_post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Notifications\InviteToBeTutorNotification;
use Illuminate\Support\Facades\Log;

class GeneralController extends Controller
{
    // show the application index page
    public function index(Request $request) {
        if(Auth::check()) {
            $request->session()->reflash();
            return redirect()->route('home');
        }
        return view('index');
    }

    // private policy
    public function showPrivatePolicy() {
        return view('policy.index');
    }

    // report forum
    public function storeReport(Request $request) {
        $request->validate([
            'report-reason' => [
                'required',
                'exists:report_reasons,id'
            ],
            'report-for' => [
                'required'
            ]
        ]);

        $report = new ReportForum();
        $report->reporter_id = Auth::user()->id;
        $report->report = $request->input('report');
        $report->report_for = $request->input('report-for');
        $report->report_reason_id = $request->input('report-reason');
        $report->save();


        return redirect()->back()->with([
            'successMsg' => 'Successfully Reported!'
        ]);
    }

    public function inviteToBeTutor(User $user) {
        if(!User::existTutor($user->email)) {
            $user->notify(new InviteToBeTutorNotification(Auth::user()));
            return response()->json(
                [
                    'successMsg' => "Successfully invited $user->first_name $user->last_name to be a tutor!"
                ]
            );
        }
        else {
            return response()->json(
                [
                    'errorMsg' => 'The user already had a tutor account.'
                ]
            );
        }
    }

    public function uploadProfilePic(Request $request) {
        $request->validate([
            'profile-pic' => [
                'required',
                'file',
                'mimes:jpeg,bmp,png'
            ]
        ]);

        $user = Auth::user();
        DB::transaction(function() use($request, $user) {
            // if user uploaded the file
            if($request->file('profile-pic')) {
                $user->deleteImage();
                $user->profile_pic_url = $request->file('profile-pic')->store('/user-profile-photos');
            }

            $user->save();
        });

        return response()->json([
            'successMsg' => 'Successfully updated the profile photo.',
            'imgUrl' => $user->profile_pic_url
        ]);

    }

    public function getRecommendedTutors() {
        return view('partials.recommended_tutors');
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

    //add or remove the course id to/from the user
    public function addRemoveCourseToProfile(Request $request) {
        $new_course_id = $request->input('new_course_id');
        // Log::channel('stderr')->info($new_course_id);
        if(Auth::user()->courses()->find($new_course_id)) {
            Auth::user()->courses()->detach($new_course_id);

            return response()->json([
                'successMsg' => 'Successfully removed the course.'
            ]);
        }
        else {
            Auth::user()->courses()->attach($new_course_id);

            return response()->json([
                'successMsg' => 'Successfully added the course.'
            ]);

        }

    }

    //add or remove the tag id to/from the user
    public function addRemoveTagToProfile(Request $request) {
        $new_tag_id = $request->input('new_tag_id');
        // Log::channel('stderr')->info($new_tag_id);
        // Log::channel('stderr')->info(Auth::user()->id);
        if(Auth::user()->tags()->find($new_tag_id)) {
            Auth::user()->tags()->detach($new_tag_id);

            return response()->json([
                'successMsg' => 'Successfully removed the tag.'
            ]);
        }
        else {
            Auth::user()->tags()->attach($new_tag_id);

            return response()->json([
                'successMsg' => 'Successfully added the tag.'
            ]);
        }
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






}
