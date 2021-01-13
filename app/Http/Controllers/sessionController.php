<?php

namespace App\Http\Controllers;

use Auth;

use App\User;
use App\Course;
use App\Session;
use App\TutorRequest;
use App\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\CustomClass\TimeFormatter;
use App\Http\Controllers\payment\StripeApiController;
use Illuminate\Support\Facades\Log;
use App\Rules\SessionOverlap;
use App\Rules\SessionDifferentUser;
use App\Rules\SameDay;
use Carbon\Carbon;

class SessionController extends Controller
{

    // todo: NATE
    // 做完以后别把我留下的todo comment删掉，我们之后要一起过一遍代码确保ok
    public function cancelSession(Request $request, Session $session) {
        $userId = Auth::user()->id;
        $request->validate([
            'cancelReasonId' => [
                'required',
                'exists:session_cancel_reasons,id'
            ]
        ]);

        $acceptedUserIds = array($session->tutor_id, $session->student_id);
        // neither student nor tutor for the session
        if (!in_array($userId, $acceptedUserIds)) {
            return response()->json([
                'errorMsg' => "Validation fails"
            ], 400);
        }

        if (!app(StripeApiController::class)->cancelInvoice($session->id)){
            return response()->json([
                'errorMsg' => "Cannot cancel invoice"
            ], 400);
        }

        $session->is_canceled = true;

        $session->cancelReason()->associate($request->input('cancelReasonId'));

        $session->save();

        return response()->json(
            [
                'successMsg' => 'Successfully cancelled the tutor session!'
            ]
        );
    }

    public function viewDetails(Request $request, Session $session) {
        if($session->student->id != Auth::id() && $session->tutor->id != Auth::id()) {
            return abort(403);
        }

        return response()->json([
            'view' => view('session.view-session-overview', [
                'session' => $session
            ])->render(),
            // need to ensure the time is between 8 - 24
            'minTime' => $session->session_time_start->addHours(-2)->format('H:i:s'),
            'maxTime' => $session->session_time_end->addHours(2)->format('H:i:s'),
            'date' => $session->session_time_start->format('Y-m-d')
        ]);
    }

    // todo: NATE
    // 做完以后别把我留下的todo comment删掉，我们之后要一起过一遍代码确保ok
    public function scheduleSession(Request $request) {
        // including:
        // 1. the upcoming session time validation (must be at least 30 minutes after current time, same day, end time must be after start time, and no conflicting sessions with both the student and tutor's upcoming sessions)
        // 3. should not schedule tutor session with oneself (using email, not id)
        // 4. course must be taught by tutor // no need to validate with code here, because otherwise this session could not be created

        // todo: decide the time that the student make a tutor request and the tutor can accept the tutor request
        $validStartTime = Carbon::now()->addMinutes(30);
        $request->validate([
            'tutorId' => [
                'required',
                'exists:users,id',
                new SessionDifferentUser(),
            ],
            'startTime' => [
                'required',
                'date',
                'after_or_equal:'.$validStartTime,
                
                //TODO: nate check same day, overlap
                new SameDay($request['endTime']),
                new SessionOverlap($request['tutorId'], Auth::user()->id, $request['startTime'], $request['endTime']),
            ],
            'endTime' => [
                'required',
                'date',
                'after:startTime',
            ],
            'course' => [
                'required',
                'exists:courses,id',
            ],
            'sessionType' => [
                'required',
                'in:in-person,online'
            ],
        ]);

        if (app(StripeApiController::class)->customerHasCards()){
            // has cards
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
            // TODO: nate change to boolean
            if ($sessionType == "in-person"){
                $tutorRequest->is_in_person = 1;
            }else if ($sessionType == "online"){
                $tutorRequest->is_in_person = 0;
            }
            $tutorRequest->tutor()->associate($tutor);
            $tutorRequest->student()->associate(Auth::user());
            $tutorRequest->course()->associate($course);

            $tutorRequest->save();

            return response()->json(
                [
                    'successMsg' => 'Successfully scheduled the tutor session!',
                ]
            );
        } else{
            // TODO: no cards => redirect to add payment page AND tell the user that they need to set up the payment method before making a tutor request
            return response()->json(
                [
                    'redirectMsg' => route('home.profile'),
                ]
            );
        }
    }


}
