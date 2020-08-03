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

    public function addAvailableTime(Request $request, User $user) {
        Auth::user()->bookmarkedUsers()->attach($user);

        return response()->json([
        ]);
    }

    public function deleteAvailableTime(Request $request, User $user) {
        $availableTimeId = $request->input('available-time-id');
        $availableTime = Auth::user()->availableTimes()->where('id', $availableTimeId)->firstOrFail();

        $availableTime->delete();

        return response()->json([

        ]);
    }
}
