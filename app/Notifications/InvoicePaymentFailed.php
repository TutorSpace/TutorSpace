<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Http\Controllers\Payment\StripeApiController;

class InvoicePaymentFailed extends Notification implements ShouldQueue
{
    use Queueable;

    private $session;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($session)
    {
        $this->session = $session;
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
        // Retrieve payment url and send
        $payment_url = app(StripeApiController::class)->getPaymentUrl($this->session);
        return (new MailMessage)
                    ->greeting('Dear ' . $notifiable->first_name)
                    ->line('Your payment for tutoring session with ' . $this->session->tutor->first_name . ' on ' . $this->session->session_time_start->setTimezone('America/Los_Angeles') . ' (PST Time Zone) has failed.')
                    ->line('Payment URL: ' . $payment_url)
                    ->action('Pay', $payment_url)
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
            'session' => $this->session
        ];
    }
}
