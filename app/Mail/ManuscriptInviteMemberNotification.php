<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ManuscriptInviteMemberNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var App\Models\Manuscript
     */
    public $manuscript;

    /**
     * @var App\Models\User
     */
    public $user;

    /**
     * @var string
     */
    public $roleName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($manuscript, $user, $roleName)
    {
        $this->manuscript = $manuscript;
        $this->user = $user;
        $this->roleName = $roleName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('bot@sensormalaysia.com.my', 'JSSM Sensor Malaysia System')->view('emails.manuscript_invite_member_notification');
    }
}
