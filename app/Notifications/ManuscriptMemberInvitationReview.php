<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Manuscript;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ManuscriptMemberInvitationReview extends Notification
{
    use Queueable;

    protected $reviewer;
    protected $manuscript;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Manuscript $manuscript, User $reviewer)
    {
        $this->manuscript = $manuscript;
        $this->reviewer = $reviewer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->subject('Manuscript Reviewer Invitation Review')
                    ->greeting('Hello!')
                    ->line('The manuscript with the identification number ' . $this->manuscript->manuscript_no .' has been assigned a suggested reviewer. Kindly indicate your approval or disapproval of the suggested reviewer by clicking the appropriate button below.')
                    ->action('Open', route('manuscript.edit', ['id' => $this->manuscript?->id]))
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
}
