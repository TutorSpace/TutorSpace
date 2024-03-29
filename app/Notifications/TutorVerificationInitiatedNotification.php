<?php

namespace App\Notifications;

use Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class TutorVerificationInitiatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $isUserVerifyMessage;
    public $fileUrl;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($isUserVerifyMessage, $fileUrl)
    {
        $this->isUserVerifyMessage = $isUserVerifyMessage;
        $this->fileUrl = $fileUrl;
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

        // for user email
        if ($this->isUserVerifyMessage){
            return (new MailMessage)
                    ->greeting('Dear ' . $notifiable->first_name)
                    ->line('We have received your verification request. ')
                    ->line('We will verify your account as soon as possible.')
                    ->action('Visit TutorSpace', url('/'))
                    ->line('Thank you for using our application!');
        }
        else{
            $url = Storage::url($this->fileUrl);
            return (new MailMessage)
                    ->line('A user requested a tutor verification.')
                    ->line($url)
                    ->action('Verify', url('/'))
                    ->line('Thank you for using our application!');
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
