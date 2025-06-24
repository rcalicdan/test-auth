<?php
// app/Libraries/BackgroundTasks.php
namespace App\Libraries;

use Rcalicdan\FiberAsync\Background;

class BackgroundTasks
{
    public function __construct()
    {
        // Configure the background worker
        Background::configure([
            'worker_filename' => 'bg_worker.php',
            'timeout' => 10, // Increase timeout for email operations
            'auto_create_worker' => false,
            'log_errors' => true,
            'fallback_host' => 'localhost:8080',
        ]);
    }

    public function queue(\Closure $task): void
    {
        try {
            Background::run($task);

            $logFile = WRITEPATH . '/logs/background_tasks_' . date('Y-m-d') . '.log';
            $timestamp = date('Y-m-d H:i:s');
            $logEntry = "[{$timestamp}] Task queued successfully\n";
            file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
        } catch (\Throwable $e) {
            // Log queueing errors
            $logFile = WRITEPATH . '/logs/background_tasks_' . date('Y-m-d') . '.log';
            $timestamp = date('Y-m-d H:i:s');
            $logEntry = "[{$timestamp}] Task queueing failed: {$e->getMessage()}\n";
            file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);

            throw $e;
        }
    }
}
