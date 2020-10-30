<?php

namespace App\Http\Controllers;

use Auth;

use App\Tag;
use App\User;
use App\Course;
use App\Session;
use Carbon\Carbon;
use App\ReportForum;
use App\TutorRequest;
use App\Dashboard_post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use App\Notifications\InviteToBeTutorNotification;

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
            if(Auth::user()->invitedUsers()->where('invited_user_id', $user->id)->exists()) {
                return response()->json(
                [
                    'successMsg' => "This request has already been sent to $user->first_name $user->last_name"
                ]
            );
            }
            else {
                Auth::user()->invitedUsers()->attach($user->id);
            }
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
                    'errorMsg' => 'The user already has a tutor account.'
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
        $profile_pic_url = "";

        // if user uploaded the file
        if($request->file('profile-pic')) {
            $user->deleteImage();
            $profile_pic_url = $request->file('profile-pic')->store('/user-profile-photos');

            foreach(User::where('email', $user->email)->get() as $tmpUser) {
                $tmpUser->profile_pic_url = $profile_pic_url;
                $tmpUser->save();
            }
        }

        return response()->json([
            'successMsg' => 'Successfully updated the profile photo.',
            'imgUrl' => $profile_pic_url
        ]);

    }

    public function getRecommendedTutors() {
        return view('partials.recommended_tutors');
    }

    //add or remove the course id to/from the user
    public function addRemoveCourseToProfile(Request $request) {
        $courseId = $request->input('courseId') ?? Course::where('course', $request->input('courseName'))->first()->id;

        if(Auth::user()->courses()->find($courseId)) {
            Auth::user()->courses()->detach($courseId);

            return response()->json([
                'successMsg' => 'Successfully removed the course.'
            ]);
        }
        else if(Auth::user()->courses()->count() < 7){
            Auth::user()->courses()->attach($courseId);

            return response()->json([
                'successMsg' => 'Successfully added the course.',
                'courseName' => $request->input('courseName'),
                'courseId' => $courseId
            ]);
        }
    }

    //add or remove the tag id to/from the user
    public function addRemoveTagToProfile(Request $request) {
        $tagId = $request->input('tagId') ?? Tag::where('tag', $request->input('tagName'))->first()->id;

        if(Auth::user()->tags()->find($tagId)) {
            Auth::user()->tags()->detach($tagId);

            return response()->json([
                'successMsg' => 'Successfully removed the tag.'
            ]);
        }
        else if(Auth::user()->tags()->count() < 10){
            Auth::user()->tags()->attach($tagId);

            return response()->json([
                'successMsg' => 'Successfully added the tag.',
                'tagName' => $request->input('tagName'),
                'tagId' => $tagId
            ]);
        }
    }

    // TODO: add validation
    public function rejectTutorRequest(Request $request) {
        $tutorRequestId = $request->input('tutor_request_id');

        TutorRequest::find($tutorRequestId)->delete();

        return response()->json(
            [
                'successMsg' => 'Successfully rejected the tutor request!'
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
        $tutorRequestId = $request->input('tutorRequestId');
        $tutorRequest = TutorRequest::find($tutorRequestId);
        $tutorId = $tutorRequest->tutor_id;
        $studentId = $tutorRequest->student_id;
        $user = Auth::user();
        $gateResponse = Gate::inspect('add-tutor-sesssion', [$tutorRequest]);
        if($gateResponse->allowed()){
            $session = new Session();
            $session->tutor_id = $tutorRequest->tutor_id;
            $session->student_id = $tutorRequest->student_id;
            $session->course_id = $tutorRequest->course_id;
            $session->session_time_start = $tutorRequest->session_time_start;
            $session->session_time_end = $tutorRequest->session_time_end;
            $session->is_in_person = 1;
            $session->save();
            $tutorRequest->status = 'accepted';
            $tutorRequest->save();

            TutorRequest::find($tutorRequestId)->delete();
            return response()->json(
                [
                    'successMsg' => 'Successfully accepted the tutor request!'
                ]
            );
        } else {
            return response()->json(
                [
                    'errorMsg' => $response->message()
                ]
            );
        }
    }

    public function getHint(Request $request) {
        $q = $request->input('str');
        $course_name = Course::all();
        $hint = "";
        if ($q !== "") {
          $q = strtolower($q);
          $len=strlen($q);
          foreach($course_name as $course) {
            if (stristr($q, substr($course->course, 0, $len))) {
              if ($hint === "") {
                // "<option value="{{ $course->id }}">{{ $course->course }}</option>"
                $hint = $course->course."<br />";
              } else {
                $hint .= "$course->course"."<br />";
              }
            }
          }
        }

        if ($hint === "") {
            return response()->json(
            [
                'successMsg'=> "no suggestion"
            ]
        );
        }
        else {
            return response()->json(
            [
                'successMsg' => $hint,
            ]
        );
        }
    }
}
