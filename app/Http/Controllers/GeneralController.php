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
use App\VerifiedCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use App\Notifications\ReportBoxNotification;
use Illuminate\Support\Facades\Notification;
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

    public function report(Request $request) {
        Notification::route('mail', "tutorspacehelp@gmail.com")
            ->notify(new ReportBoxNotification($request->input('star-rating'), $request->input('report-content')));

        return redirect()->back()->with([
            'successMsg' => 'We have successfully received your feedback. Thank you letting us know your thoughts!'
        ]);
    }

    // private policy
    public function showPrivatePolicy() {
        return view('policy.private-policy');
    }

    public function showCancellationPolicy() {
        return view('policy.private-policy');
    }

    public function showTGPPolicy() {
        return view('policy.private-policy');
    }

    public function showTutorVerificationPolicy() {
        return view('policy.private-policy');
    }

    public function showRefundPolicy() {
        return view('policy.private-policy');
    }

    public function showReferralPolicy() {
        return view('policy.private-policy');
    }

    public function showUSCIntegrityPolicy() {
        return view('policy.private-policy');
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

    public function uploadProfilePic(Request $request) {
        $request->validate([
            'profile-pic' => [
                'required',
                'file',
                'mimes:jpeg,bmp,png,jpg',
                'max:10000'
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
            if(Auth::user()->is_tutor && Auth::user()->courses()->count() < 2) {
                return abort(401);
            }

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
                'courseId' => $courseId,
                'isVerified' => VerifiedCourse::where('course_id', $courseId)->where('user_id', Auth::id())->exists()
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


}
