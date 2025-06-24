<?php

namespace App\Jobs;

use Rcalicdan\Ci4Larabridge\Facades\Auth;
use Rcalicdan\Ci4Larabridge\Queue\Job;

class SendVerificationEmailJob extends Job
{
    public function __construct()
    {
       //
    }

    public function handle(): void
    {
       Auth::sendEmailVerification(auth()->user());
    }
}