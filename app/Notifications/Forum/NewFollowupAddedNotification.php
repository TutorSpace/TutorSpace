<?php

namespace App\Notifications\Forum;

use App\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewFollowupAddedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $post;
    private $content;
    private $userName;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Post $post, $content, $userName)
    {
        $this->post = $post;
        $this->content = $content;
        $this->userName = $userName;
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
        return (new MailMessage)
                        ->greeting('Dear ' . $notifiable->first_name)
                        ->line('Someone replied you in the post: "' . $this->post->title . '."')
                        ->action('View the Post', route('posts.show', $this->post->slug))
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
            'postId' => $this->post->id,
            'content' => $this->content,
            'userName' => $this->userName
        ];
    }
}
