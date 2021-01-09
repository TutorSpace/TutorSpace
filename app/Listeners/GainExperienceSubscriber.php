<?php

namespace App\Listeners;

use App\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GainExperienceSubscriber
{
    // Experience amounts
    private static $RATE_HOUR_EXP = 5;
    private static $NOTE_EXP = 10;
    private static $LIKE_EXP = 1;
    private static $BEST_REPLY_EXP = 25;

    /**
     * Handle tutoring hour ended
     */
    public function handleTutoringHourEnded($event) {
        Log::info('handleTutoringHourEnded triggered.');
        $tutor = $event->tutor;
        $session = $event->session;
        $avg_rating = (float)$tutor->aboutReviews()->avg('star_rating');
        $total_exp = round(self::$RATE_HOUR_EXP * $avg_rating * $session->getDurationInHour());
        $tutor->addExperience($total_exp);
    }

    /**
     * Handle note posted
     */
    public function handleNotePosted($event) {
        Log::info('handleNotePosted triggered.');
        $post = $event->post;
        $user = $post->user;
        // At most one post can be added to experience
        if ($user->posts()->where('id', '!=', $post->id)
                        ->where('post_type_id', 2)
                        ->whereDate('created_at', '=', Carbon::today()->toDateString())
                        ->exists()) {
            return;
        }
        $post->user->addExperience(self::$NOTE_EXP);
    }

    /**
     * Handle marked as best reply in a more than 100 viewd post
     */
    public function handleMarkedAsBestReply($event) {
        Log::info('handleMarkedAsBestReply triggered.');
        $reply = $event->reply;
        $reply->user->addExperience(self::$BEST_REPLY_EXP);
    }

    /**
     * Handle post like received
     */
    public function handlePostLikeReceived($event) {
        Log::info('handlePostLikeReceived triggered.');
        $post = $event->post;
        $is_like = $event->is_like;
        if ($is_like) {
            $post->user->addExperience(self::$LIKE_EXP);
        } else {
            $post->user->addExperience(-self::$LIKE_EXP);
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return void
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\TutoringHourEnded',
            // [GainExperienceSubscriber::class, 'handleTutoringHourEnded']
            'App\Listeners\GainExperienceSubscriber@handleTutoringHourEnded'
        );

        $events->listen(
            'App\Events\NotePosted',
            // [GainExperienceSubscriber::class, 'handleNotePosted']
            'App\Listeners\GainExperienceSubscriber@handleNotePosted'
        );

        $events->listen(
            'App\Events\MarkedAsBestReply',
            // [GainExperienceSubscriber::class, 'handleMarkedAsBestReply']
            'App\Listeners\GainExperienceSubscriber@handleMarkedAsBestReply'
        );

        $events->listen(
            'App\Events\PostLikeReceived',
            // [GainExperienceSubscriber::class, 'handlePostLikeReceived']
            'App\Listeners\GainExperienceSubscriber@handlePostLikeReceived'
        );
    }
}