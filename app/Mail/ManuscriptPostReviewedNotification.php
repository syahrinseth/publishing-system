<?php

namespace App\Mail;

use App\Models\Manuscript;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ManuscriptPostReviewedNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Manuscript instance
     * 
     * @var \App\Models\Manuscript
     */
    public $manuscript;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Manuscript $manuscript)
    {
        $this->manuscript = $manuscript;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('bot@sensormalaysia.com.my', 'JSSM Sensor Malaysia System')->view('emails.manuscript_post_reviewed_notification');
    }
}
