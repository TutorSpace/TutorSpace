<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerification extends Notification implements ShouldQueue
{
    use Queueable;

    public $verificationCode;
    public $userName;
    public $isTutor;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($verificationCode, $userName, $isTutor)
    {
        $this->verificationCode = $verificationCode;
        $this->userName = $userName;
        $this->isTutor = $isTutor;
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
        if($this->isTutor) {
            $route = route('register.index.tutor.2');
        }
        else {
            $route = route('register.index.student.2');
        }
        return (new MailMessage)
                    ->greeting('Dear ' . $this->userName)
                    ->line('Your verification code is ' . $this->verificationCode)
                    ->action('Continue to register', $route)
                    ->line('Please feel free to checkout the latest news of TutorSpace at https://www.tutorspace.info. Thank you for joining TutorSpace!');
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
