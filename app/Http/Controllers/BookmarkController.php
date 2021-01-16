<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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

    // users are allowed
    public function store(Request $request, User $user) {
        Gate::authorize('bookmark-tutor', $user);
        Auth::user()->bookmarkedUsers()->attach($user);

        return response()->json([
            'successMsg' => 'Successfully bookmarked the user.'
        ]);
    }

    public function delete(Request $request, User $user) {
        Gate::authorize('bookmark-tutor', $user);
        Auth::user()->bookmarkedUsers()->detach($user);

        return response()->json([
            'successMsg' => 'Successfully unbookmarked the user.'
        ]);
    }
}
