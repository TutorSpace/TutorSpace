<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\Messages\SubscriptionMessage;


class EmailSubscription extends Notification implements ShouldQueue
{
    use Queueable;

    public $userName;
    public $email;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($userName, $email)
    {
        $this->userName = $userName;
        $this->email = $email;
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
        return (new SubscriptionMessage($this->email))
                    ->greeting('Dear ' . $this->userName)
                    ->line('Thanks for subscribing to TutorSpace! We will send you the latest updates in the future.')
                    ->action('Start your journey as a Student/Tutor!', route('index'))
                    ->line('Please feel free to checkout the latest news of TutorSpace at https://www.tutorspace.info. Thank you for joining TutorSpace!');
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
