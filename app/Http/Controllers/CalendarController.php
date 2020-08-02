<?php

namespace App\Http\Controllers;

use App\AvailableTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function __construct() {
        $this->middleware(['auth']);
    }

    public function addAvailableTime(Request $request) {
        // dd($request->all());
        $request->validate([
            'start-time' => [
                'required',
                'date_format:Y-m-d H:i:00',
                'after_or_equal:today'
            ],
            'end-time' => [
                'required',
                'date_format:Y-m-d H:i:00',
                'after_or_equal:today',
                'after_or_equal:start-time'
            ]
        ]);

        Auth::user()->availableTimes()->create([
            'available_time_start' => $request->input('start-time'),
            'available_time_end' => $request->input('end-time')
        ]);

        return redirect()->route('home')->with([
            'successMsg' => 'Successfully updated your availability.'
        ]);
    }
}
