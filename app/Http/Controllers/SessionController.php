<?php

namespace App\Http\Controllers;

use Auth;

use App\User;
use App\Course;
use App\Review;
use App\Session;
use Carbon\Carbon;
use App\TutorRequest;
use App\PaymentMethod;
use App\Rules\SameDay;
use Illuminate\Http\Request;
use App\Rules\SessionOverlap;
use Illuminate\Validation\Rule;
use App\CustomClass\TimeFormatter;
use Illuminate\Support\Facades\DB;
use App\Rules\SessionDifferentUser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use App\Notifications\NewTutorRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\payment\StripeApiController;

class SessionController extends Controller
{
    // todo: check situations to cancel
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

        DB::transaction(function () use($session, $request) {
            $session->is_canceled = true;
            $session->cancelReason()->associate($request->input('cancelReasonId'));
            $session->save();
            // TODO: testing -> experience reduction
            Auth::user()->cancelSessionExperienceDeduction();
            app(StripeApiController::class)->chargeForCancellation(Auth::user());
        });

        if (!app(StripeApiController::class)->cancelInvoice($session->id)){
            return response()->json([
                'errorMsg' => "Cannot cancel invoice"
            ], 400);
        }

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
            'minTime' => TimeFormatter::getTimeForCalendarWithHours($session->session_time_start, -2),
            'maxTime' => TimeFormatter::getTimeForCalendarWithHours($session->session_time_end, 2),
            'date' => $session->session_time_start->format('Y-m-d')
        ]);
    }

    public function review(Request $request, Session $session) {
        Gate::authorize('review-session', $session);

        $request->validate([
            'review' => [
                'required'
            ],
            'star-rating' => [
                'required',
                'integer',
                'max:5',
                'min:1'
            ]
        ]);

        $review = new Review();
        $review->star_rating = $request->input('star-rating');
        $review->review = $request->input('review');
        $review->reviewer_id = Auth::id();
        $review->session_id = $session->id;
        $review->reviewee_id = $session->tutor->id;
        $review->save();

        return response()->json([
            'successMsg' => 'Successfully posted the review!'
        ]);
    }

    public function scheduleSession(Request $request) {
        // including:
        // 1. the upcoming session time validation (must be at least 2 hours after current time, same day, end time must be after start time, and no conflicting sessions with both the student and tutor's upcoming sessions)
        // 3. should not schedule tutor session with oneself (using email, not id)
        // 4. course must be taught by tutor // no need to validate with code here, because otherwise this session could not be created

        $validStartTime = Carbon::now()->addMinutes(120);
        $validator = Validator::make($request->all(), [
            'tutorId' => [
                'required',
                'exists:users,id',
                new SessionDifferentUser(),
            ],
            'startTime' => [
                'required',
                'date',
                'after_or_equal:'.$validStartTime,
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
        ],[
            'startTime.after_or_equal' => "Tutor session must be scheduled 2 hours ahead of start time. (after " . $validStartTime . ")"
        ]);

        // return validation error messages
        if ($validator->fails()){
           return response()->json(
                [
                    'error' => $validator->errors()->first()
                ], 400
            );
        }

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
            if ($sessionType == "in-person"){
                $tutorRequest->is_in_person = 1;
            }else if ($sessionType == "online"){
                $tutorRequest->is_in_person = 0;
            }
            $tutorRequest->tutor()->associate($tutor);
            $tutorRequest->student()->associate(Auth::user());
            $tutorRequest->course()->associate($course);

            $tutorRequest->save();

            $tutorRequest->refresh();

            $tutor->notify(new NewTutorRequest($tutorRequest));

            return response()->json(
                [
                    'successMsg' => 'Successfully scheduled the tutor session!',
                ]
            );
        } else{
            // no cards => redirect to add payment page AND tell the user that they need to set up the payment method before making a tutor request
            return response()->json(
                [
                    'redirectMsg' => route('home.profile'),
                ]
            );
        }
    }


}
