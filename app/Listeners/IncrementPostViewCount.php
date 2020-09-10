<?php

namespace App\Listeners;

use App\View;
use Carbon\Carbon;
use App\Events\PostViewed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class IncrementPostViewCount implements ShouldQueue
{

    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 60;

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
     * @param  PostViewed  $event
     * @return void
     */
    public function handle(PostViewed $event)
    {
        $post = $event->post;
        $post->increment('view_count');

        $view = new View([
            'viewed_at' => Carbon::now()
        ]);

        $post->views()->save($view);
    }
}
