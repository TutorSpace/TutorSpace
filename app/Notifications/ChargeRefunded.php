<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChargeRefunded extends Notification
{
    use Queueable;

    private $session;
    private $is_student;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($session, $is_student)
    {
        $this->session = $session;
        $this->is_student = $is_student;
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
        if ($this->is_student) {
            return (new MailMessage)
                    ->greeting('Dear ' . $notifiable->first_name)
                    ->line('You have successfully refunded your payment for session with ' . $this->session->tutor->first_name . ' on ' . $this->session->session_time_start . '.')
                    ->line('Thank you for using our platform!');
        } else {
            return (new MailMessage)
                    ->greeting('Dear ' . $notifiable->first_name)
                    ->line('Your tutoring session with ' . $this->session->student->first_name . ' on ' . $this->session->session_time_start . ' was refunded.')
                    ->line('Thank you for using our platform!');
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
