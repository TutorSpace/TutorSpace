<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReferralRegisterSuccessNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $userInvitedBy;
    private $forNewUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $userInvitedBy, $forNewUser)
    {
        $this->userInvitedBy = $userInvitedBy;
        $this->forNewUser = $forNewUser;
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
        if($this->forNewUser) {
            return (new MailMessage)
            ->greeting('Dear ' . $notifiable->first_name)
            ->line('You have successfully claimed the referral bonus. Your bonus will be sent to your account within 3 days.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
        } else {

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
            //
        ];
    }
}
