<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TutorLevelUpNotification extends Notification
{
    use Queueable;

    private $exp;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {

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
        return (new MailMessage)
                    ->greeting('Dear ' . $notifiable->first_name)
                    ->line('Congrats! You just reached the ' . $notifiable->tutorLevel->tutor_level . ' level.')
                    ->action('Visit TutorSpace', url('/'))
                    ->line('Thank you for using our application!');
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
            'levelProgressPercentage' => $notifiable->getLevelProgressPercentage(),
            'currLevel' => $notifiable->currentLevel(),
            'nextLevel' => $notifiable->nextLevel(),
        ];
    }
}
