<?php

namespace App\Http\Controllers;

use App\Session;
use App\TutorRequest;
use App\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\payment\StripeApiController;
class TutorRequestController extends Controller
{
    // TODO: double check this function
    public function acceptTutorRequest(Request $request, TutorRequest $tutorRequest) {
        $tutorId = $tutorRequest->tutor_id;
        $studentId = $tutorRequest->student_id;
        $gateResponse = Gate::inspect('accept-tutor-request', [$tutorRequest]);

        if($gateResponse->allowed()){

            // wrap in DB::transaction
            DB::transaction(function () use($tutorRequest,$tutorId,$studentId) {
                //create new tutor session
                $session = new Session();
                $session->hourly_rate = $tutorRequest->hourly_rate;
                $session->tutor()->associate($tutorId);
                $session->student()->associate($studentId);
                $session->course()->associate($tutorRequest->course_id);
                $session->session_time_start = $tutorRequest->session_time_start;
                $session->session_time_end = $tutorRequest->session_time_end;
                $session->is_in_person = $tutorRequest->is_in_person;
                $session->save();
                $session->refresh();
                // delete tutor request
                $tutorRequest->delete();

                // todo: start payment for the student here (wrap it inside an event called 'TutorRequestAccepted')

                // calculate session fee
                $sessionFee = $this->calculateSessionFee($session);
                // create a transaction in our database and invoice in stripe
                $this->initializeInvoice($sessionFee,$session);
            });

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

    public function calculateSessionFee($session) {
        $hourlyRate = $session->hourly_rate;
        $startTimeInTime = strtotime($session->session_time_start);
        $endTimeInTime = strtotime($session->session_time_end);
        $sessionDurationInHour = round(abs($endTimeInTime - $startTimeInTime)/3600,2);
        $sessionFee = $sessionDurationInHour * $hourlyRate;
        return $sessionFee;
    }

    public function initializeInvoice($sessionFee,$session) {
        $tutorStripeAccountId = PaymentMethod::where("user_id",$session->tutor_id)->get()[0]->stripe_account_id;
        $initializeInvoiceResponse = app(StripeApiController::class)->initializeInvoice($sessionFee,$tutorStripeAccountId, $session);
    }
}
