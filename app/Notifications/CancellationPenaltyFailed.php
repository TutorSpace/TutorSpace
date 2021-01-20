<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CancellationPenaltyFailed extends Notification implements ShouldQueue
{
    use Queueable;

    private $user_id;
    private $stripe_object_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user_id, $stripe_object_id)
    {
        $this->user_id = $user_id;
        $this->stripe_object_id = $stripe_object_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Dear staff')
                    ->line('The cancellation penalty for user with id ' . $this->user_id . ' has failed.')
                    ->line('The stripe object id is ' . $this->stripe_object_id);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
