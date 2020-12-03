<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;

class ViewProfileController extends Controller
{
    public function index(User $user) {
        return view('home.view_profile.index', [
            'user' => $user,
            'posts' => Post::all()->take(5)
        ]);
    }
}
