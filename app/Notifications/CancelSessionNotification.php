<?php

namespace App\Notifications;

use App\Session;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CancelSessionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $session;
    private $canceledByTutor;
    private $expLost;
    private $tooLate;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Session $session, $canceledByTutor, $expLost, $tooLate)
    {
        $this->session = $session;
        $this->canceledByTutor = $canceledByTutor;
        $this->expLost = $expLost;
        $this->tooLate = $tooLate;
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
                ->line('Your session from ' . $this->session->session_time_start->setTimezone('America/Los_Angeles') . ' to ' . $this->session->session_time_end->setTimezone('America/Los_Angeles') . ' (PST Time Zone) is canceled.')
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
            'session' => $this->session,
            'canceledByTutor' => $this->canceledByTutor,
            'expLost' => $this->expLost,
            'tooLate' => $this->tooLate,
        ];
    }
}
