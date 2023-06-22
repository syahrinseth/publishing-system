<?php

namespace App\Console\Commands;

use App\Models\Manuscript;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ManuscriptReviewerNotification;

class ManuscriptReviewerReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manuscript:remind-reviewer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind reviewer to review manuscript through email.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get members where reviewer is not reviewed the manuscript yet.
        $manuscripts = Manuscript::where('status', 'Submit For Review')->whereHas('reviewers', function($q) {
            $q->where('reviewed', null);
        })->get();

        // Send email notifications to these reviewers.
        foreach ($manuscripts as $manuscript) {

            $reviewers = $manuscript->reviewers()->where('reviewed', null)->get()->values()->all();
            // Send mail.
            foreach ($reviewers as $reviewer) {

                Notification::send($reviewer->user, new ManuscriptReviewerNotification($manuscript, $reviewer->user));

            }

        }

        // Done.
        return 0;
    }
}
