<?php

namespace App\Notifications;

use App\TutorRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewTutorRequest extends Notification implements ShouldQueue
{
    use Queueable;

    private $tutorRequest;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(TutorRequest $tutorRequest)
    {
        $this->tutorRequest = $tutorRequest;
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
                ->line('You just received a New Tutor Request from ' . $this->tutorRequest->student->first_name . '! The session is from ' . $this->tutorRequest->session_time_start->setTimezone('America/Los_Angeles') . ' to ' . $this->tutorRequest->session_time_end->setTimezone('America/Los_Angeles') . ' (PST Time Zone)')
                ->action('Visit TutorSpace', url('/'))
                ->line('Thank you for using our platform!');
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
            'tutorRequest' => $this->tutorRequest
        ];
    }
}
