<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Manuscript;
use App\Models\ManuscriptMember;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InviteReviewerForReview extends Notification implements ShouldQueue
{
    use Queueable;

    protected $manuscript;
    protected $member;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Manuscript $manuscript, ManuscriptMember $member)
    {
        $this->manuscript = $manuscript;
        $this->member = $member;
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
            ->greeting("Dear " . $this->member?->user?->first_name . ' ' . $this->member?->user->last_name . ",")
            ->line('In view of your work in the field, your name has been recommended, as a potential reviewer, for the manuscript entitled "' . $this->manuscript?->title . '" that has been submitted for publication in the ' . config('app.name') .' (' . config('app.url') . ').')
            ->line('Kindly please review the abstract below, to see if it comes in your direct field of expertise, and provide us a confirmation of your willingness to review the complete manuscript. I hope that you will be able to help us.')
            ->line('Title: ' . $this->manuscript?->title)
            ->line('Abstract: ' . $this->manuscript?->abstract)
            ->line('I would appreciate it if you could kindly respond to this invitation at your earliest. Since we are endeavouring to provide an efficient review process for our authors, we would request that you send your comments and recommendations, if any, back to us as soon as possible.')
            ->line('Kindly indicate your approval or disapproval by clicking the appropriate button below.')
            ->action('Accept', route('manuscript.member.acceptInvitation', [ 'id' => $this->manuscript->id, 'member_id' => $this->member->id ]))
            ->line('In addition to carrying out this review, we would also like to propose your name, as a reviewer, to be included in the Reviewer Panel of this journals, and possibly others relevant to your field. ')
            ->line('Thank you for your consideration.')
            ->line('Regards,')
            ->line('Editor-In-Chief')
            ->line(config('app.namme'));
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
