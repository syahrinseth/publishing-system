<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Manuscript;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ManuscriptRejectedInviteToResubmitNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Manuscript instance
     * 
     * @var \App\Models\Manuscript
     */
    public $manuscript;

    /**
     * User instance.
     * 
     * @var \App\Models\User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Manuscript $manuscript, User $user)
    {
        $this->manuscript = $manuscript;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('bot@sensormalaysia.com.my', 'JSSM Sensor Malaysia System')->view('emails.manuscript_rejected_invite_to_resubmit_notification');
    }
}
