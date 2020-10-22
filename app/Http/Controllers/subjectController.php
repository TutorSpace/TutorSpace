<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Subject;

class subjectController extends Controller
{
    public function removeFavSubject(Request $request) {
        $subjectId = $request->input('subject_id');

        $user = Auth::user();
        $user->subjects()->detach($subjectId);

        return response()->json([
            'successMsg' => 'Successfully removed from your favorite subjects!'
        ]);
    }

    public function addFavSubject(Request $request) {
        $request->validate([
            'subject' => [
                'required'
            ]
        ]);

        $subjectInput = $request->input('subject');

        $user = Auth::user();

        // trim the user's data and capitalize each words
        $subjectInput = ucwords(strtolower(trim($subjectInput)));

        // check whether use's data is already inside the database
        $subject = Subject::where('subject', '=', $subjectInput)->first();


        if($subject) {
            $subjectId = $subject->id;

            // if exist, and user does not faved that subject, fav it
            if(!$user->favedSubject($subjectId)) {
                $user->subjects()->attach($subjectId);
                return redirect('profile')->with([
                    'success' => 'Successfully added to favorite subject!'
                ]);
            }

            // if exist, but user faved that subject, return error
            return redirect('profile')->with([
                'error' => 'The subject you added is already your favorite subject!'
            ]);
        }

        // if not exist, add to database and fav this course
        $addSubject = new Subject();
        $addSubject->subject = $subjectInput;
        $addSubject->save();

        $user->subjects()->attach($addSubject->id);

        return redirect('profile')->with([
            'success' => 'Successfully added to favorite subject!'
        ]);
    }

}
