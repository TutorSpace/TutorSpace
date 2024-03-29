<?php

namespace App\Notifications;

use App\Session;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RefundDeclinedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $session;
    private $declineReason;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Session $session, $declineReason)
    {
        $this->session = $session;
        $this->declineReason = $declineReason;
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
                    ->line('Your refund request with session ' . $this->session->id . ' has been declined for the following reason: ' . $this->declineReason)
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
            'declineReason' => $this->declineReason
        ];
    }
}
