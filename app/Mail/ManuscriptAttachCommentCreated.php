<?php

namespace App\Mail;

use App\Models\ManuscriptAttachFileComment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ManuscriptAttachCommentCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ManuscriptAttachFileComment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('bot@sensormalaysia.com.my', 'JSSM Sensor Malaysia System')->view('emails.manuscript_attach_comment_notify');
    }
}
