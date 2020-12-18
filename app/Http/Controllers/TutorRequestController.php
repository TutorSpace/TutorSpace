<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TutorRequestController extends Controller
{
    // TODO: double check this function
    public function acceptTutorRequest(Request $request) {
        $tutorRequestId = $request->input('tutorRequestId');
        $tutorRequest = TutorRequest::find($tutorRequestId);
        $tutorId = $tutorRequest->tutor_id;
        $studentId = $tutorRequest->student_id;
        $user = Auth::user();
        $gateResponse = Gate::inspect('accept-tutor-request', [$tutorRequest]);
        if($gateResponse->allowed()){
            $session = new Session();
            $session->tutor_id = $tutorRequest->tutor_id;
            $session->student_id = $tutorRequest->student_id;
            $session->course_id = $tutorRequest->course_id;
            $session->session_time_start = $tutorRequest->session_time_start;
            $session->session_time_end = $tutorRequest->session_time_end;
            $session->is_in_person = $tutorRequest->is_in_person;
            $session->save();

            $tutorRequest->delete();
            return response()->json(
                [
                    'successMsg' => 'Successfully accepted the tutor request!'
                ]
            );
        } else {
            return response()->json(
                [
                    'errorMsg' => $response->message()
                ]
            );
        }
    }

    public function rejectTutorRequest(Request $request) {
        // $tutorRequestId = $request->input('tutor_request_id');

        // TutorRequest::find($tutorRequestId)->delete();

        // return response()->json(
        //     [
        //         'successMsg' => 'Successfully rejected the tutor request!'
        //     ]
        // );
    }
}
