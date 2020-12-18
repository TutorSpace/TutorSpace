<?php

namespace App\Http\Controllers;

use App\Session;
use App\TutorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TutorRequestController extends Controller
{
    // TODO: double check this function
    public function acceptTutorRequest(Request $request, TutorRequest $tutorRequest) {
        $tutorId = $tutorRequest->tutor_id;
        $studentId = $tutorRequest->student_id;
        $user = Auth::user();
        $gateResponse = Gate::inspect('accept-tutor-request', [$tutorRequest]);
        if($gateResponse->allowed()){
            $session = new Session();
            $session->tutor()->associate($tutorId);
            $session->student()->associate($user);
            $session->course()->associate($tutorRequest->course_id);
            $session->session_time_start = $tutorRequest->session_time_start;
            $session->session_time_end = $tutorRequest->session_time_end;
            $session->is_in_person = $tutorRequest->is_in_person;
            $session->save();

            $tutorRequest->delete();

            // todo: start payment for the student here (wrap it inside an event called 'TutorRequestAccepted')

            return response()->json(
                [
                    'successMsg' => 'Successfully accepted the tutor request!'
                ]
            );
        } else {
            return response()->json(
                [
                    'errorMsg' => $gateResponse->message()
                ]
            );
        }
    }

    // todo: add validation here
    public function declineTutorRequest(Request $request, TutorRequest $tutorRequest) {
        $tutorRequest->delete();

        return response()->json(
            [
                'successMsg' => 'Successfully declined the tutor request!'
            ]
        );
    }
}
