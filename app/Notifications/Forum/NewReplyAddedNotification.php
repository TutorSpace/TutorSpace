<?php

namespace App\Notifications\Forum;

use App\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewReplyAddedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $post;
    private $content;
    private $forFollowers;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Post $post, $content, $forFollowers)
    {
        $this->post = $post;
        $this->content = $content;
        $this->forFollowers = $forFollowers;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // return (new MailMessage)
        //             ->line('The introduction to the notification.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our application!');
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
            'postId' => $this->post->id,
            'content' => $this->content,
            'forFollowers' => $this->forFollowers
        ];
    }
}
