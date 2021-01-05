<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PayoutFailed extends Notification
{
    use Queueable;

    private $is_sending_to_user;
    private $failure_code;
    private $stripe_account_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($is_sending_to_user, $failure_code, $stripe_account_id = null)
    {
        $this->is_sending_to_user = $is_sending_to_user;
        $this->failure_code = $failure_code;
        $this->stripe_account_id = $stripe_account_id;
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
                    ->line('A recent payout to you has failed.')
                    ->line('The failure reason is ' . $this->failure_code . '.')
                    ->line('Thank you for using our platform!');
        } else {
            return (new MailMessage)
                    ->greeting('Dear staff')
                    ->line('A payout to ' . $this->stripe_account_id . ' has failed for ' . $this->failure_code . '.');
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
