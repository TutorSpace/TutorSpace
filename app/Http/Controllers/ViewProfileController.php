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
    // optional parameter orderByOption: popularity(default), timeAsc, timeDesc
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

        $orderByOption = $request->input('order-by-option');
        if ($orderByOption == "timeAsc"){
            $orderByQuery = "created_at ASC";
        } else if ($orderByOption == "timeDesc"){
            $orderByQuery = "created_at DESC";
        } else {
            $orderByQuery = POST::POPULARITY_FORMULA;
            $orderByOption = 'popularity';
        }

        // should not show the request session popup every time the page reloads

        $toRequest = $request->input('request') && url()->previous() != url()->full();

        return view('home.view_profile.index', [
            'user' => $user,
            'orderByOption' => $orderByOption,
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
            ->orderByRaw($orderByQuery)
            ->get()
            ->paginate(3) : [],
            'request' => $toRequest
        ]);
    }
}
