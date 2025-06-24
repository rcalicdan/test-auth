<?php
// public/bg_worker.php

use CodeIgniter\Boot;
use Config\Paths;

/*
 *---------------------------------------------------------------
 * CHECK PHP VERSION
 *---------------------------------------------------------------
 */

$minPhpVersion = '8.1';
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPhpVersion,
        PHP_VERSION,
    );

    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo $message;
    exit(1);
}

/*
 *---------------------------------------------------------------
 * SET THE CURRENT DIRECTORY
 *---------------------------------------------------------------
 */

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 */

// LOAD OUR PATHS CONFIG FILE
require FCPATH . '../app/Config/Paths.php';

$paths = new Paths();

// LOAD THE FRAMEWORK BOOTSTRAP FILE
require $paths->systemDirectory . '/Boot.php';

$app = Boot::bootWeb($paths);

/*
 *---------------------------------------------------------------
 * BACKGROUND WORKER LOGIC
 *---------------------------------------------------------------
 */

// Simple logging function
function bg_log($message, $level = 'info') {
    $logFile = WRITEPATH . 'logs/background_' . date('Y-m-d') . '.log';
    
    $logDir = dirname($logFile);
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[{$timestamp}] [{$level}] {$message}\n";
    file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
}

ignore_user_abort(true);
set_time_limit(0);

$payload = json_decode($_POST['payload'] ?? '{}', true);

try {
    switch ($payload['type'] ?? null) {
        case 'closure':
            $serialized = base64_decode($payload['closure']);
            $closure = unserialize($serialized)->getClosure();
            
            if ($closure instanceof Closure) {
                $closure();
                bg_log('Closure task completed successfully');
            }
            break;
            
        case 'array':
            $data = $payload['data'] ?? [];
            bg_log('Array task executed: ' . json_encode($data));
            break;
            
        default:
            bg_log('Unknown task type: ' . ($payload['type'] ?? 'null'), 'error');
    }
} catch (Throwable $e) {
    bg_log('Task execution failed: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), 'error');
}

// Success response
http_response_code(200);
echo json_encode(['status' => 'success']);