<?php

namespace App\Jobs;

use Rcalicdan\Ci4Larabridge\Facades\Auth;
use Rcalicdan\Ci4Larabridge\Queue\Job;

class SendVerficationEmail extends Job
{
    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Auth::sendEmailVerification(auth()->user());
    }
}
