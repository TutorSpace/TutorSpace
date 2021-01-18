<?php

namespace App\Notifications;

use App\User;
use App\Session;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Http\Controllers\Payment\StripeApiController;

class UnpaidInvoiceReminder extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    private $session;
    private $toUser;

    public function __construct(Session $session, $toUser)
    {
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
            // Retrieve payment url and send
            $payment_url = app(StripeApiController::class)->getPaymentUrl($this->session);

            return (new MailMessage)
                ->greeting('Dear ' . $notifiable->first_name)
                ->line('You have an unpaid tutor session. Please pay your invoice on stripe as soon as possible.')
                ->line('Payment URL: ' . $payment_url)
                ->action('Pay', $payment_url)
                ->line('Thank you for using our platform!');
        } else {
            return (new MailMessage)
                ->line('Session (' . $this->session->id . ') has an unpaid tutor session.');
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
            'session' => $this->session
        ];
    }
}
