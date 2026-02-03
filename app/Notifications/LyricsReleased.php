<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LyricsReleased extends Notification
{
    use Queueable;

    public function __construct(public $song)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('song.show', [$this->song->artist->slug, $this->song->slug]);

        return (new MailMessage)
            ->subject('Lyrics Released: ' . $this->song->title_english)
            ->greeting('Hello!')
            ->line('Great news! The lyrics for "' . $this->song->title_english . '" are now available.')
            ->action('Read Lyrics', $url)
            ->line('Thank you for using our application!');
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
        ];
    }
}
