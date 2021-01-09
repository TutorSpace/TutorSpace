<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;

class ViewProfileController extends Controller
{
    public function index(Request $request, User $user) {
        // todo: update this
        // return view('home.view_profile.index', [
        //     'user' => $user,
        //     'posts' => Post::all()->take(5)
        // ]);
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
            ->paginate(3) : null
        ]);
    }
}
