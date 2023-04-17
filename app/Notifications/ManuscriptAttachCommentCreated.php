<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\ManuscriptAttachFileComment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ManuscriptAttachCommentCreated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $comment;

    protected $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ManuscriptAttachFileComment $comment)
    {
        $this->comment = $comment;
        $this->message = "The " . ucfirst($this->comment->from) . " have sent you a comment on Manuscript number " . $this->comment->attachFile->manuscript->manuscript_no . "! The message contains: \"" . $this->comment->text . "\".";
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
                    ->subject('Notification - JSSM Sensor Malaysia System')
                    ->greeting('Hello!')
                    ->line($this->message)
                    ->action('Open', route('manuscript.edit', ['id' => $this->comment->attachFile->manuscript?->id]))
                    ->line('Thank you for using our application!');
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

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
            'link' => $this->link(),
            'model_type' => ManuscriptAttachFileComment::class,
            'model_id' => $this->comment?->id
        ];
    }

    protected function link()
    {
        return route('manuscript.edit', ['id' => $this->comment->attachFile->manuscript?->id]);
    }
}
