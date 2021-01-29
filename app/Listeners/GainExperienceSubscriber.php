<?php

namespace App\Listeners;

use App\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GainExperienceSubscriber
{
    // Experience amounts
    private static $RATE_HOUR_EXP = 10;
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
        
        // Check whether course is verified
        if (DB::table('course_user')->select("course_user.user_id")
                ->join("verified_courses", function($join){
                    $join->on("verified_courses.course_id","=","course_user.course_id")
                        ->on("verified_courses.user_id","=","course_user.user_id");
                })->where('course_user.user_id', $tutor->id)
                ->where('course_user.course_id', $session->course_id)->exists()) {
            $factor = 1.5;
        } else {
            $factor = 1;
        }

        $total_exp = round($factor * self::$RATE_HOUR_EXP * $session->getDurationInHour());
        $tutor->addExperience($total_exp);
    }

    /**
     * Handle tutoring hour ended
     */
    public function handleReviewPosted($event) {
        Log::info('handleReviewPosted triggered.');
        $event->session->tutor->addExperience(5 * $event->rating);
    }

    /**
     * Handle note posted
     */
    public function handleNotePosted($event) {
        Log::info('handleNotePosted triggered.');
        $post = $event->post;
        $user = $post->user;
        // At most one post can be added to experience in one day
        if ($user->posts()->where('id', '!=', $post->id)
                        // important: make sure post_type_id is "note"
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
            'App\Events\SessionReviewPosted',
            'App\Listeners\GainExperienceSubscriber@handleReviewPosted'
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
