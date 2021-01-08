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

        return view('home.view_profile.index', [
            'user' => $user,
            'displayForumActivities' => $request->input('display-forum-activities') || !$user->is_tutor
        ]);
    }
}
