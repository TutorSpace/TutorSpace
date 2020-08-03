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

    public function store(Request $request, User $user) {
        if($user->is_tutor && !Auth::user()->is_tutor) {
            Auth::user()->bookmarkedUsers()->attach($user);

            return response()->json([
                'successMsg' => 'Successfully bookmarked the user.'
            ]);
        }
    }

    public function delete(Request $request, User $user) {
        if($user->is_tutor && !Auth::user()->is_tutor) {
            Auth::user()->bookmarkedUsers()->detach($user);

            return response()->json([
                'successMsg' => 'Successfully unbookmarked the user.'
            ]);
        }

    }
}
