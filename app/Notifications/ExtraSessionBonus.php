<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExtraSessionBonus extends Notification implements ShouldQueue
{
    use Queueable;

    private $session;
    private $extra_bonus_amount;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($session, $extra_bonus_amount)
    {
        $this->session = $session;
        $this->extra_bonus_amount = $extra_bonus_amount;
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
        return (new MailMessage)
                    ->greeting('Dear staff')
                    ->line('There is an extra session bonus for session id ' . $this->session->id)
                    ->line('The amount is ' . $this->extra_bonus_amount);
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
