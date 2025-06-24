<?php

namespace App\Jobs;

use App\Models\User;
use Rcalicdan\Ci4Larabridge\Facades\Auth;
use Rcalicdan\Ci4Larabridge\Queue\Job;

class SendEmailVerfication extends Job
{
    protected $userId;
    /**
     * Create a new job instance.
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::find($this->userId);
        Auth::sendEmailVerification($user);
    }
}
