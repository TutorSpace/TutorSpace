<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function __construct() {
        $this->middleware(['auth']);
    }

    public function addAvailableTime(Request $request, User $user) {
        $availableTime = Auth::user()->availableTimes()->create([
            'available_time_start' => $request->input('start-time'),
            'available_time_end' => $request->input('end-time')
        ]);

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
