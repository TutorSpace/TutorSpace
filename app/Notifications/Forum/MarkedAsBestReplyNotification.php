<?php

namespace App\Notifications\Forum;

use App\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MarkedAsBestReplyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $post;
    public $email;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Post $post, String $email)
    {
        $this->post = $post;
        $this->email = $email;
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
        return (new SubscriptionMessage($this->email))
                    ->line('Your Reply to Post: ' . $this->post->title . ' is marked as best reply.')
                    ->action('View the Post: ' . $this->post->title, route('posts.show', $this->post->slug))
                    ->line('Thank you for using TutorSpace!');
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
