<?php

namespace App\Providers;

use App\User;
use App\Review;
use App\Session;
use App\Chatroom;
use Carbon\Carbon;
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

        Gate::define('accept-tutor-request', function ($user, $tutorRequest) {
            if($user->id != $tutorRequest->tutor_id || $tutorRequest->session_time_start <= Carbon::now()->addMinutes(10))
                return Response::deny('This session conflicts with an existing session!');

            $isAvailable = true;
            foreach($user->upcomingSessions as $session) {
                if(!TimeOverlapManager::noTimeOverlap($tutorRequest->session_time_start, $tutorRequest->session_time_end, $session->session_time_start, $session->session_time_end)) $isAvailable = false;
            }

            return $user->is_tutor && $isAvailable ? Response::allow() : Response::deny('This session conflicts with an existing session!');
        });

        Gate::define('review-session', function($user, $session) {
            // 1) the reviewer is the student, 2) have not reviewed this session before
            return $user->id == $session->student_id && !Review::where('session_id', $session->id)->exists();
        });

        // users are allowed to bookmark their own tutor account
        Gate::define('show-bookmark-svg', function($user, $bookmarkedUser) {
            return
                !Auth::check()
                || (!Auth::user()->is_tutor && $bookmarkedUser->is_tutor);
        });
    }
}
