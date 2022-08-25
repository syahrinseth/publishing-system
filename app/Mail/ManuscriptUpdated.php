<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ManuscriptUpdated extends Mailable
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
    public function __construct($manuscript, $user)
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
        return $this->from('bot@sensormalaysia.com.my', 'JSSM Sensor Malaysia System')->view('emails.manuscript_updated');
    }
}
