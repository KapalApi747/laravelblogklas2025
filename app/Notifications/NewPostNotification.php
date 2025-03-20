<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPostNotification extends Notification
{
    use Queueable;

    protected Post $post;

    /**
     * Create a new notification instance.
     */
    public function __construct(Post $post)
    {
        //
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nieuwe post gepubliceerd:'.$this->post->title)
            ->greeting('Hallo,'.$notifiable->name.',')
            ->line('Er is een nieuwe post gepubliceerd:')
            ->line($this->post->title)
            ->action('Bekijk Post', url(route('posts.show', $this->post->slug)))
            ->line('Bedankt voor je aandacht!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
            'post_id' => $this->post->id,
            'title' => $this->post->title,
            'author' => $this->post->author->name,
            'author' => $this->post->author()->first()->name,
            'url' => route('posts.show', $this->post->slug),
        ];
    }
}
