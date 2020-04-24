<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;

class tutorRequestController extends Controller
{
    public function showMakeTutorRequest(Request $request, User $tutor) {

        $user = Auth::user();
        if($user->is_tutor === 1 || $tutor->is_tutor === 0) {
            return redirect()->route('home');
        }

        $from = $request->input('from');

        return view('tutor_request.show_request_session', [
            "user" => $user,
            "tutor" => $tutor,
            "from" => $from
        ]);

    }


    public function showEditAvailability(Request $request) {
        $user = Auth::user();
        if($user->is_tutor === 0) {
            return redirect()->route('home');
        }

        $from = $request->input('from');
        return view('tutor_request.show_edit_availability', [
            "user" => $user,
            'from' => $from
        ]);
    }

    public function saveAvailableTime(Request $request) {
        $startTime = $request->input('startTime');
        $endTime = $request->input('endTime');


    }

}
