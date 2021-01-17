<?php

namespace App\Http\Controllers;

use App\User;
use App\Course;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function indexTutorVerification() {
        return view('admin.tutor-verification');
    }

    public function addVerifiedCourse(Request $request, User $user) {
        $user->verifiedCourses()->attach(Course::where('course', $request->input('course'))->firstOrFail());

        return redirect()->route('admin.tutor-verification');
    }
}
