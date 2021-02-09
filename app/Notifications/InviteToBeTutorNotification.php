<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InviteToBeTutorNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $user;
    private $inviteCode;
    private $toSendUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($inviteCode, User $user, $toSendUser)
    {
        $this->user = $user;
        $this->inviteCode = $inviteCode;
        $this->toSendUser = $toSendUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if($this->toSendUser) {
            return (new MailMessage)
            ->greeting('Dear ' . $notifiable->first_name)
            ->line($this->user->first_name . ' ' . $this->user->last_name . ' invited you to be a tutor.')
            ->line('Register now and earn a bonus of $5!')
            ->action('Register Now', route('invite-to-be-tutor.attempt-claim-bonus', $this->inviteCode))
            ->line('Thank you for using TutorSpace!');
        } else {
            return (new MailMessage)
                    ->greeting('Dear Student')
                    ->line($this->user->first_name . ' ' . $this->user->last_name . ' invited you to be a tutor.')
                    ->line('Register now and earn a bonus of $5!')
                    ->action('Register Now', route('invite-to-be-tutor.attempt-claim-bonus', $this->inviteCode))
                    ->line('Thank you for using TutorSpace!');
        }

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
            'user' => $this->user,
            'inviteCode' => $this->inviteCode
        ];
    }
}
