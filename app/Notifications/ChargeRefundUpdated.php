<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChargeRefundUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    private $session;
    private $is_sending_to_user;
    private $failure_reason;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($session, $is_sending_to_user, $failure_reason)
    {
        $this->session = $session;
        $this->is_sending_to_user = $is_sending_to_user;
        $this->failure_reason = $failure_reason;
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
        if ($this->is_sending_to_user) {
            return (new MailMessage)
                    ->greeting('Dear ' . $notifiable->first_name)
                    ->line('Your refund request for tutoring session with ' . $this->session->tutor->first_name . ' on ' . $this->session->session_time_start->setTimezone('America/Los_Angeles') . ' (PST Time Zone) has failed.')
                    ->line('The failure reason is ' . $this->failure_reason . '.')
                    ->line('Please contact tutorspaceusc@gamil.com for more details.')
                    ->action('Visit TutorSpace', url('/'))
                    ->line('Thank you for using our platform!');
        } else {
            return (new MailMessage)
                    ->greeting('Dear staff')
                    ->action('Visit TutorSpace', url('/'))
                    ->line('The refund request for session ' . $this->session->id . ' has failed for ' . $this->failure_reason . '.');
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

        ];
    }
}
