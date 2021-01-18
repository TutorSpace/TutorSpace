<?php

namespace App\Notifications\Forum;

use App\Post;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MarkedAsBestReplyNotification extends Notification
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
        if($this->forFollowers) {
            return (new MailMessage)
                        ->greeting('Dear ' . $notifiable->first_name)
                        ->line('A reply to post: "' . $this->post->title . '" is marked as best reply.')
                        ->action('View the Post', route('posts.show', $this->post->slug))
                        ->line('Thank you for using TutorSpace!');
        } else {
            return (new MailMessage)
                        ->greeting('Dear ' . $notifiable->first_name)
                        ->line('Your reply to post: "' . $this->post->title . '" is marked as best reply.')
                        ->action('View the Post', route('posts.show', $this->post->slug))
                        ->line('Thank you for using TutorSpace!');
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
            'post' => $this->post,
            'content' => $this->content,
            'forFollowers' => $this->forFollowers
        ];
    }
}
