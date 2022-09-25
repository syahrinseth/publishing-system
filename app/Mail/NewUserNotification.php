<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewUserNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $toUser;
    public $registeredUser;

    /**
     * Create a new message instance.
     * @param User $user
     * @return void
     */
    public function __construct(User $toUser, User $registeredUser)
    {
        $this->toUser = $toUser;
        $this->registeredUser = $registeredUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('bot@sensormalaysia.com.my', 'JSSM Sensor Malaysia System')->view('emails.new_user_notification');
    }
}
