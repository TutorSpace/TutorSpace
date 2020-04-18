<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

class generalController extends Controller
{
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

    public function getDashboardPosts(Request $request) {
        $courseSubject = $request->input('courseSubject');
        $tutorStudent = $request->input('tutorStudent');

        

        return response()->json(
            [
                'successMsg' =>
            ]
        );
    }
}
