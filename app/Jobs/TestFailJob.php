<?php 

namespace App\Jobs;

use Rcalicdan\Ci4Larabridge\Queue\Job;

class TestFailJob extends Job 
{
    public int $tries = 3; // Changed from 1 to 3 to allow retries
    public int $timeout = 60;
    
    public function __construct() 
    {
       //
    }
    
    public function handle(): void 
    {
        log_message('error', 'TestFailJob: About to throw exception for testing failed jobs');
        throw new \Exception('This job always fails for testing failed job logging');
    }
    
    public function failed(\Throwable $exception): void 
    {
        log_message('error', 'Job failed method called: ' . get_class($this) . ' - ' . $exception->getMessage());
        log_message('error', 'Job failed, attempts exhausted - should be logged to failed_jobs table');
    }
}