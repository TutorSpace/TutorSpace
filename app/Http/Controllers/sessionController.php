<?php

namespace App\Http\Controllers;

use Auth;

use App\User;
use App\Course;
use App\Session;
use App\TutorRequest;
use App\PaymentMethod;
use Illuminate\Http\Request;

use App\CustomClass\TimeFormatter;
use App\Http\Controllers\payment\StripeApiController;

class SessionController extends Controller
{

    public function cancelSession(Request $request, Session $session) {
        // todo: validate that it is truly the current user's session
        $request->validate([
            'cancelReasonId' => [
                'required',
                'exists:session_cancel_reasons,id'
            ]
        ]);

         // TODO: cancel invoice in transaction, must have an invoice associated with it. otherwise will raise error
        $stripeApiController = new StripeApiController();
        $stripeApiController->cancelInvoice($session->id);




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
        // including:
        // 1. the upcoming session time validation (must be at least 30 minutes after current time, and be the same day, end time must be after start time, and no conflicting sessions)
        // 3. should not schedule tutor session with oneself
        // 4. course must be taught be tutor // no need to validate, because otherwise this session could not be created
        $request->validate([

        ]);


        // TODO: check if customer has >= 1 payment methods
        $stripeApiController = new StripeApiController();

        if ($stripeApiController->customerHasCards()){
            // has cards

        }else{
            // no cards: redirect to add payment page

        }





        $startTime = TimeFormatter::getTime($request->input('startTime'), $request->input('startTime'));
        $endTime = TimeFormatter::getTime($request->input('endTime'), $request->input('endTime'));
        $course = Course::find($request->input('course'));
        $sessionType = $request->input('sessionType');
        $tutorId = $request->input('tutorId');
        $tutor = User::find($tutorId);

        $tutorRequest = new TutorRequest();
        $tutorRequest->hourly_rate = $tutor->hourly_rate;
        $tutorRequest->session_time_start = $startTime;
        $tutorRequest->session_time_end = $endTime;
        $tutorRequest->is_in_person = $sessionType;
        // $tutorRequest->is_canceled = false;

        $tutorRequest->tutor()->associate($tutor);
        $tutorRequest->student()->associate(Auth::user());
        $tutorRequest->course()->associate($course);

        $tutorRequest->save();

        return response()->json(
            [
                'successMsg' => 'Successfully scheduled the tutor session!',
            ]
        );
    }


}
