<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use App\Events\ProfileViewed;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;

class ViewProfileController extends Controller
{
    public function index(Request $request, User $user) {
        // create cookie name
        $cookieName = "viewed-"."user-".$user->id;
        // check if cookie exists
        if (!$request->cookie($cookieName)) {
            // create event
            event(new ProfileViewed($user));
            // distribute cookie
            Cookie::queue(Cookie::make($cookieName, 'true', 60));
        }

        $toDisplayPosts = $request->input('display-forum-activities') || !$user->is_tutor;

        return view('home.view_profile.index', [
            'user' => $user,
            'displayForumActivities' => $toDisplayPosts,
            'posts' => $toDisplayPosts ? Post::with([
                'tags',
                'user'
            ])
            ->withCount([
                'usersUpvoted',
                'replies',
                'tags'
            ])
            // todo: modify the formula
            ->where('user_id', $user->id)
            ->orderByRaw(POST::POPULARITY_FORMULA)
            ->get()
            ->paginate(3) : []
        ]);
    }
}
