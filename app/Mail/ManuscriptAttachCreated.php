<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ManuscriptAttachCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Manuscript instance
     * 
     * @var \App\Models\Manuscript
     */
    public $manuscript;

    /**
     * Manuscript instance
     * 
     * @var \App\Models\ManuscriptAttachFile
     */
    public $attachFile;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($manuscript, $attachFile)
    {
        $this->manuscript = $manuscript;
        $this->attachFile = $attachFile;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('bot@sensormalaysia.com.my', 'JSSM Sensor Malaysia System')->view('emails.manuscript_attach_created');
    }
}
