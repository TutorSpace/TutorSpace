<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Course;

class courseController extends Controller
{
    public function removeFavCourse(Request $request) {
        $courseId = $request->input('course_id');

        $user = Auth::user();
        $user->courses()->detach($courseId);

        return response()->json([
            'successMsg' => 'Successfully removed from your favorite courses!'
        ]);
    }

    public function addFavCourse(Request $request) {
        $request->validate([
            'course' => [
                'required'
            ]
        ]);

        $courseInput = $request->input('course');

        $user = Auth::user();

        $words = explode(" ", strtoupper(trim($courseInput)));

        // validate the user's data by checking there must exactly contain two words
        if(count($words) != 2) {
            return redirect('profile')->with([
                'error' => 'Please enter two words as course name! E.g. CSCI 201'
            ]);
        }

        // the first word must be all letters
        if(!ctype_alpha($words[0])) {
            return redirect('profile')->with([
                'error' => 'The first word bust be all letters! E.g. CSCI 201'
            ]);
        }
        //  the second word should must contains only numbers
        if(!ctype_digit($words[1])) {
            return redirect('profile')->with([
                'error' => 'The second word bust be all numbers! E.g. CSCI 201'
            ]);
        }

        $courseInput = $words[0] . ' ' . $words[1];

        // check whether use's data is already inside the database
        $course = Course::where('course', '=', $courseInput)->first();


        if($course) {
            $courseId = $course->id;

            // if exist, and user does not faved that course, fav it
            if(!$user->favedCourse($courseId)) {
                $user->courses()->attach($courseId);
                return redirect('profile')->with([
                    'success' => 'Successfully added to favorite course!'
                ]);
            }

            // if exist, but user faved that course, return error
            return redirect('profile')->with([
                'error' => 'The course you added is already your favorite course!'
            ]);
        }

        // if not exist, add to database and fav this course
        $addCourse = new Course();
        $addCourse->course = $courseInput;
        $addCourse->save();

        $user->courses()->attach($addCourse->id);

        return redirect('profile')->with([
            'success' => 'Successfully added to favorite course!'
        ]);
    }

}
