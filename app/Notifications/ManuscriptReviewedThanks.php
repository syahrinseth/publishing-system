<?php

namespace App\Notifications;

use App\Models\Manuscript;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ManuscriptReviewedThanks extends Notification
{
    use Queueable;

    protected $manuscript;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Manuscript $manuscript)
    {
        $this->manuscript = $manuscript;
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
                    ->line("Thank you for your review of manuscript {$this->manuscript->manuscript_no}.")
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
            'message' => "Thank you for your review of manuscript {$this->manuscript->manuscript_no}.",
            'link' => route('manuscript.edit', ['id' => $this->manuscript->id]),
            'model_type' => Manuscript::class,
            'model_id' => $this->manuscript->id
        ];
    }
}
