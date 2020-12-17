<?php

namespace App\Http\Controllers;

use Auth;

use App\User;
use App\Course;
use App\Session;
use App\PaymentMethod;
use Illuminate\Http\Request;
use App\CustomClass\TimeFormatter;

class SessionController extends Controller
{

    public function cancelSession(Request $request, Session $session) {
        $request->validate([
            'cancelReasonId' => [
                'required',
                'exists:session_cancel_reasons,id'
            ]
        ]);

        $session->is_canceled = true;

        $session->cancelReason()->associate($request->input('cancelReasonId'));

        $session->save();

        return response()->json(
            [
                'successMsg' => 'Successfully cancelled the tutor session!'
            ]
        );
    }

    public function scheduleSession(Request $request) {
        // todo: validate all the input data before creating a session
        $request->validate([

        ]);

        $startTime = TimeFormatter::getTime($request->input('startTime'), $request->input('startTime'));
        $endTime = TimeFormatter::getTime($request->input('endTime'), $request->input('endTime'));
        $course = Course::find($request->input('course'));
        $sessionType = $request->input('sessionType');
        $tutor = User::find($request->input('tutorId'));

        $session = new Session();
        $session->session_time_start = $startTime;
        $session->session_time_end = $endTime;
        $session->is_in_person = $sessionType;
        $session->is_upcoming = true;
        $session->is_canceled = false;

        $session->tutor()->associate($tutor);
        $session->student()->associate(Auth::user());
        $session->course()->associate($course);


       
        // $session->save();



        //TODO: create transaction

        // calculate session fee
        $hourlyRate = $tutor->hourly_rate;
        $startTimeInTime = strtotime($startTime);
        $endTimeInTime = strtotime($endTime);
        $sessionDurationInHour = round(abs($endTimeInTime - $startTimeInTime)/3600,2);
        $sessionFee = $sessionDurationInHour*$hourlyRate;

        // get tutor stripe account




        return response()->json(
            [
                'successMsg' => $sessionFee,
            ]
        );



        // return response()->json(
        //     [
        //         'successMsg' => 'Successfully scheduled the tutor session!',
        //     ]
        // );
    }


}
