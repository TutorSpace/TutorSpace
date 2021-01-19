<?php

namespace App\Providers;

use App\User;
use App\Review;
use App\Session;
use App\Chatroom;
use Carbon\Carbon;
use App\TutorRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\CustomClass\TimeOverlapManager;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Post' => 'App\Policies\PostPolicy',
        'App\Message' => 'App\Policies\MessagePolicy' // users are allowed to chat with the account of the opposite identity but can not chat with themselves
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('add-available-time', function ($user, $startTime, $endTime) {
            $isAvailable = true;
            foreach($user->availableTimes as $availableTime) {
                if(!TimeOverlapManager::noTimeOverlap($startTime, $endTime, $availableTime->available_time_start, $availableTime->available_time_end)) $isAvailable = false;
            }
            foreach($user->upcomingSessions as $session) {
                if(!TimeOverlapManager::noTimeOverlap($startTime, $endTime, $session->session_time_start, $session->session_time_end)) $isAvailable = false;
            }
            return $user->is_tutor && $isAvailable;
        });

        // must be at least 1 hour prior to the session start time
        // must not conflicts with any tutor sessions
        // must have already set up the payment method
        // must be in pending status
        // must be the tutor of this tutor request
        Gate::define('accept-tutor-request', function ($user, TutorRequest $tutorRequest) {
            if($user->id != $tutorRequest->tutor_id) {
                return Response::deny('You are not authorized to accept this tutor request.');
            } else if($tutorRequest->status != 'pending') {
                return Response::deny('You are not authorized to accept this tutor request.');
            } else if($tutorRequest->session_time_start <= Carbon::now()->addMinutes(60)) {
                return Response::deny('You can only accept tutor requests that are at least two hours before the current time.');
            } else if(!Auth::user()->tutorHasStripeAccount()) {
                return Response::deny('You must first set up your payment method in the profile page before accepting any tutor request.');
            } else {
                $isAvailable = true;
                foreach($user->upcomingSessions as $session) {
                    if(!TimeOverlapManager::noTimeOverlap($tutorRequest->session_time_start, $tutorRequest->session_time_end, $session->session_time_start, $session->session_time_end)) $isAvailable = false;
                }

                return $isAvailable ? Response::allow() : Response::deny('This session conflicts with an existing session!');
            }
        });

        Gate::define('review-session', function($user, $session) {
            // 1) the reviewer is the student, 2) have not reviewed this session before
            return $user->id == $session->student_id && !Review::where('session_id', $session->id)->exists();
        });

        // users are allowed to bookmark their own tutor account
        Gate::define('bookmark-tutor', function($user, $bookmarkedUser) {
            return
                !Auth::check()
                || (!Auth::user()->is_tutor && $bookmarkedUser->is_tutor);
        });
    }
}
