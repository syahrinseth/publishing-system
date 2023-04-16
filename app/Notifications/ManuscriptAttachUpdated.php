<?php

namespace App\Notifications;

use App\Models\Manuscript;
use App\Models\ManuscriptAttachFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ManuscriptAttachUpdated extends Notification
{
    use Queueable;

    protected $manuscript;
    protected $attachFile;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Manuscript $manuscript, ManuscriptAttachFile $attachFile)
    {
        $this->manuscript = $manuscript;
        $this->attachFile = $attachFile;
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
                    ->line("Attachment {$this->attachFile->getType()['name']} has been updated in Manuscript {$this->manuscript->manuscript_attach_id}!")
                    ->action('View', route('manuscript.edit', ['id' => $this->manuscript->id]))
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
            'message' => "Attachment {$this->attachFile->getType()['name']} has been updated in Manuscript {$this->manuscript->manuscript_attach_id}!",
            'link' => route('manuscript.edit', ['id' => $this->manuscript->id]),
            'model_type' => Manuscript::class,
            'model_id' => $this->manuscript->id
        ];
    }
}
