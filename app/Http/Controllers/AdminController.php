<?php

namespace App\Http\Controllers;

use App\User;
use App\Course;
use Illuminate\Http\Request;
use App\Notifications\TutorVerificationCompleted;

class AdminController extends Controller
{
    public function indexTutorVerification() {
        return view('admin.tutor-verification');
    }

    public function addVerifiedCourse(Request $request, User $user) {
        $user->verifiedCourses()->attach(Course::where('course', $request->input('course'))->firstOrFail());

        return redirect()->route('admin.tutor-verification');
    }

    public function sendTutorVerificationCompleted(Request $request, User $user) {
        if($user->notifications()->where('type', 'App\Notifications\TutorVerificationCompleted')->exists()) {
            return redirect()->route('admin.tutor-verification', [
                'errorMsg' => 'You have already sent the tutor verification!'
            ]);
        }

        $user->notify(new TutorVerificationCompleted());
        return redirect()->route('admin.tutor-verification', [
            'successMsg' => 'Successfully sent the tutor verification!'
        ]);
    }
}
