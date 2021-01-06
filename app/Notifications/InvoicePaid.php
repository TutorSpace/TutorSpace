<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoicePaid extends Notification
{
    use Queueable;

    private $session;
    private $is_student_receiver;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($session, $is_student_receiver)
    {
        $this->session = $session;
        $this->is_student_receiver = $is_student_receiver;
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
        if ($this->is_student_receiver) {
            return (new MailMessage)
                    ->greeting('Dear ' . $notifiable->first_name)
                    ->line('We have received your payment for your tutoring session with ' . $this->session->tutor->first_name . ' on ' . $this->session->session_time_start . '.')
                    ->line('Thank you for using our platform!');
        } else {
            return (new MailMessage)
                    ->greeting('Dear ' . $notifiable->first_name)
                    ->line('Your tutoring session on ' . $this->session->session_time_start . ' has been paid.')
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
