<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InviteToBeTutorNotification extends Notification
{
    use Queueable;

    public $user;
    public $inviteCode;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, $inviteCode)
    {
        $this->user = $user;
        $this->inviteCode = $inviteCode;
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
                    ->greeting('Hi there,')
                    ->line($this->user->first_name . ' ' . $this->user->last_name . ' invited you to be a tutor.')
                    ->line('Please register to be a tutor and earn your bonus!')
                    ->action('Register Here', url('/'))
                    ->line('Thank you for using TutorSpace!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {

    }
}
