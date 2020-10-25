<?php

namespace App\Providers;

use App\User;
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
            foreach($user->tutorRequests as $tutorRequest) {
                if(!TimeOverlapManager::noTimeOverlap($startTime, $endTime, $tutorRequest->session_time_start, $tutorRequest->session_time_end)) $isAvailable = false;
            }
            return $user->is_tutor && $isAvailable;
        });
    }
}
