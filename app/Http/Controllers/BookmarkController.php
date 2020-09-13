<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function __construct() {
        $this->middleware(['auth']);
    }

    public function show(User $user) {
        return view('partials.user_card', [
            'user' => $user
        ]);
    }

    // todo: use gate to do this! remember to check whether the user is trying to bookmark his own student account
    public function store(Request $request, User $user) {
        if($user->is_tutor && !Auth::user()->is_tutor && $user->email != Auth::user()->eamil) {
            Auth::user()->bookmarkedUsers()->attach($user);

            return response()->json([
                'successMsg' => 'Successfully bookmarked the user.'
            ]);
        }
    }

    public function delete(Request $request, User $user) {
        if($user->is_tutor && !Auth::user()->is_tutor && $user->email != Auth::user()->eamil) {
            Auth::user()->bookmarkedUsers()->detach($user);

            return response()->json([
                'successMsg' => 'Successfully unbookmarked the user.'
            ]);
        }

    }
}
