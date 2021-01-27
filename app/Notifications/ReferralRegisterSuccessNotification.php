<?php

namespace App\Notifications;

use App\User;
use App\InviteUser;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReferralRegisterSuccessNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $forNewUser;
    private $sendToUsers;
    private $bonus; // in dollars

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($bonus, $forNewUser, $sendToUsers)
    {
        $this->forNewUser = $forNewUser;
        $this->sendToUsers = $sendToUsers;
        $this->bonus = $bonus;
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
        if(!$this->sendToUsers) {
            return (new MailMessage)
            ->line('A user claimed the rewards successfully. You should send him/her bonus via Venmo with a bonus of $' . $this->bonus . '.');
        }
        else if($this->forNewUser) {
            return (new MailMessage)
            ->greeting('Dear ' . $notifiable->first_name)
            ->line('You have successfully claimed a referral bonus of $' . $this->bonus . '. One of our staff member will shortly send you an email to ask for your Venmo account, and your bonus will be sent to you via Venmo within 3 days.')
            ->action('Visit TutorSpace', url('/'))
            ->line('Thank you for using our platform!');
        } else {
            return (new MailMessage)
            ->greeting('Dear ' . $notifiable->first_name)
            ->line('Your referral code is successfully activated by a student you invited. You will receive a referral bonus of $' . $this->bonus . '. One of our staff member will shortly send you an email to ask for your Venmo account, and your bonus will be sent to you via Venmo within 3 days.')
            ->action('Visit TutorSpace', url('/'))
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
            'forNewUser' => $this->forNewUser,
            'bonus' => $this->bonus
        ];
    }
}
