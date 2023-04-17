<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Manuscript;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InviteReviewerForReview extends Notification implements ShouldQueue
{
    use Queueable;

    protected $manuscript;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Manuscript $manuscript, User $user)
    {
        $this->manuscript = $manuscript;
        $this->user = $user;
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
            ->subject('Manuscript Review Invitation')
            ->greeting('Dear ' . $this->user?->first_name . ',')
            ->line("Manuscript {$this->manuscript->manuscript_no} is ready to be review by you.")
            ->line("Click the link below to proceed to the manuscript page:")
            ->action('Accept', route('manuscript.member.acceptInvitation', [ 'id' => $this->manuscript->id, 'member_id' => '' ]))
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
