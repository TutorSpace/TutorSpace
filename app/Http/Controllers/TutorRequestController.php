<?php

namespace App\Http\Controllers;

use App\User;
use App\Session;
use App\TutorRequest;
use App\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Notifications\TutorRequestAccepted;
use App\Notifications\TutorRequestDeclined;
use App\Http\Controllers\Payment\StripeApiController;

class TutorRequestController extends Controller
{

    public function acceptTutorRequest(Request $request, TutorRequest $tutorRequest) {
        $tutorId = $tutorRequest->tutor_id;
        $studentId = $tutorRequest->student_id;
        $gateResponse = Gate::inspect('accept-tutor-request', [$tutorRequest]);

        if($gateResponse->allowed()){
            DB::transaction(function () use($tutorRequest,$tutorId,$studentId) {
                //create new tutoring session
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

                // should not delete tutor request, because we need to show it.
                $tutorRequest->status = 'accepted';
                $tutorRequest->save();

                $tutorRequest->refresh();

                User::find($studentId)->notify(new TutorRequestAccepted($session));

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

    public function declineTutorRequest(Request $request, TutorRequest $tutorRequest) {
        if($tutorRequest->tutor->id != Auth::id()) return abort(401);

        $tutorRequest->status = 'declined';
        $tutorRequest->save();

        $tutorRequest->refresh();

        $tutorRequest->student->notify(new TutorRequestDeclined($tutorRequest));

        return response()->json(
            [
                'successMsg' => 'Successfully declined the tutor request!'
            ]
        );
    }

    public function calculateSessionFee($session) {
        $hourlyRate = $session->hourly_rate;
        $sessionFee = $session->getDurationInHour() * $hourlyRate;
        return $sessionFee;
    }

    public function initializeInvoice($sessionFee,$session) {
        $tutorStripeAccountId = PaymentMethod::where("user_id",$session->tutor_id)->get()[0]->stripe_account_id;
        $initializeInvoiceResponse = app(StripeApiController::class)->initializeInvoice($sessionFee,$tutorStripeAccountId, $session);
    }

    public function cancelTutorRequest(Request $request, TutorRequest $tutorRequest) {
        $tutorRequest->status = 'canceled';
        $tutorRequest->save();

        return response()->json(
            [
                'successMsg' => 'Successfully canceled the tutor request!'
            ]
        );
    }
}
