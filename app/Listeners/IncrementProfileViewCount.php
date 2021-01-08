<?php

namespace App\Listeners;

use App\Events\ProfileViewed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class IncrementProfileViewCount implements shouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProfileViewed  $event
     * @return void
     */
    public function handle(ProfileViewed $event)
    {
        $user = $event->user;
        $view = new View([
            'viewed_at' => Carbon::now()
        ]);

        $user->views()->save($view);
    }
}
