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
use App\Events\SessionReviewPosted;
use App\Rules\SessionDifferentUser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use App\Notifications\NewTutorRequest;
use Illuminate\Support\Facades\Validator;
use App\Notifications\CancelSessionNotification;
use App\Http\Controllers\Payment\StripeApiController;

class SessionController extends Controller
{
    public function cancelSession(Request $request, Session $session) {
        $userId = Auth::user()->id;
        $request->validate([
            'cancelReasonId' => [
                'required',
                'exists:session_cancel_reasons,id'
            ]
        ]);

        $acceptedUserIds = array($session->tutor_id, $session->student_id);
        // neither student nor tutor for the session, or it is already a past session
        if (!in_array($userId, $acceptedUserIds) || $session->session_time_start <= Carbon::now()) {
            return response()->json([
                'errorMsg' => "You are not authorized to cancel this session."
            ], 400);
        }

        DB::transaction(function () use($session, $request) {
            $session->is_canceled = true;
            $session->cancelReason()->associate($request->input('cancelReasonId'));
            $session->save();


            if(Auth::user()->is_tutor) {
                $expLost = 0;
                $tooLate = false;
                // if too late
                if(Carbon::now()->addHours(24) > $session->session_time_start) {
                    $expLost = Auth::user()->cancelSessionExperienceDeduction();
                    app(StripeApiController::class)->chargeForCancellation(Auth::user());
                    $tooLate = true;
                }

                Auth::user()->notify(new CancelSessionNotification($session, true, $expLost, $tooLate));
                $session->student->notify(new CancelSessionNotification($session, true, $expLost, $tooLate));

            } else {
                $tooLate = false;
                // if too late
                if(Carbon::now()->addHours(12) > $session->session_time_start) {
                    // student will not be deducted the exp points
                    app(StripeApiController::class)->chargeForCancellation(Auth::user());
                    $tooLate = true;
                }
                Auth::user()->notify(new CancelSessionNotification($session, false, 0, $tooLate));
                $session->tutor->notify(new CancelSessionNotification($session, false, 0, $tooLate));
            }
        });

        if (!app(StripeApiController::class)->cancelInvoice($session->id)){
            return response()->json([
                'errorMsg' => "Cannot cancel invoice"
            ], 400);
        }

        return response()->json(
            [
                'successMsg' => 'Successfully cancelled the tutoring session!'
            ]
        );
    }

    public function viewDetails(Request $request, Session $session) {
        if($session->student->id != Auth::id() && $session->tutor->id != Auth::id()) {
            return abort(403);
        }
        $tz = TimeFormatter::getTZ();
        return response()->json([
            'view' => view('session.view-session-overview', [
                'tz' => $tz,
                'session' => $session
            ])->render(),
            'time' => $session->session_time_start->setTimeZone($tz)->format('H:i:s'),
            'date' => $session->session_time_start->setTimeZone($tz)->format('Y-m-d')
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

        // TUTOR EXPERIENCE += 5 * RATING
        event(new SessionReviewPosted($session, (int)($request->input('review'))));

        return response()->json([
            'successMsg' => 'Successfully posted the review!'
        ]);
    }

    public function scheduleSession(Request $request) {
        // 1. the upcoming session time validation (must be at least 2 hours after current time, same day, end time must be after start time, and no conflicting sessions with both the student and tutor's upcoming sessions)
        // 3. should not schedule tutoring session with oneself (using email, not id)
        // 4. course must be taught by tutor
        // 5. current user must be a student and the requested user must be a tutor

        // rule 4 & 5
        if(
            !User::find($request->input('tutorId'))->is_tutor
            || User::find($request->input('tutorId'))->courses()->where('id', $request->input('course'))->doesntExist()
        ) {
            return abort(401);
        }

        // important: the input time must all be in utc timezone

        // rule 1, 2, 3
        $validStartTime = Carbon::now()->addMinutes(120);
        // duration cannot be greater than 8 hours
        $validEndTime = Carbon::parse($request->input('startTime'))->addHours(8);

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
                new SessionOverlap($request['tutorId'], Auth::user()->id, $request['startTime'], $request['endTime']),
            ],
            'endTime' => [
                'required',
                'date',
                'after:startTime',
                'before_or_equal:'. $validEndTime,
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
            'startTime.after_or_equal' => "Tutoring session must be scheduled 2 hours ahead of start time.",
            'endTime.before_or_equal' => "Tutoring session duration cannot be greater than 8 hours."
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
                    'successMsg' => 'Successfully requested the tutoring session!',
                ]
            );
        } else{
            // no cards => redirect to add payment page AND tell the user that they need to set up the payment method before making a tutor request
            return response()->json(
                [
                    'redirectMsg' => route('home.profile') .'?payment-section-redirect=true',
                ]
            );
        }
    }
}
