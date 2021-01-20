<?php

namespace App\Notifications;

use App\User;
use App\Session;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserRequestedRefundNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $user;
    private $session;
    private $toUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, Session $session, $toUser)
    {
        $this->user = $user;
        $this->session = $session;
        $this->toUser = $toUser;
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
        // if sending to users
        if($this->toUser) {
            return (new MailMessage)
                ->greeting('Dear ' . $notifiable->first_name)
                ->line('You have successfully requested a refund.')
                ->action('Visit TutorSpace', url('/'))
                ->line('Thank you for using our platform!');
        } else {
            return (new MailMessage)
                ->line('A user requested a refund');
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
            'session' => $this->session
        ];
    }
}
