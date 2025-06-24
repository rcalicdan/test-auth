<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Laravel\SerializableClosure\SerializableClosure;

class BackgroundWorkerController extends Controller
{
    public function index()
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setStatusCode(405)
                ->setJSON(['error' => 'Method not allowed']);
        }

        $this->bgLog('Worker accessed via CI4 controller');

        ignore_user_abort(true);
        set_time_limit(0);

        $payload = json_decode($this->request->getPost('payload') ?? '{}', true);
        $this->bgLog('Decoded payload type: ' . ($payload['type'] ?? 'unknown'));

        try {
            switch ($payload['type'] ?? null) {
                case 'closure':
                    $this->handleClosureTask($payload);
                    break;

                case 'array':
                    $data = $payload['data'] ?? [];
                    $this->bgLog('Array task executed: ' . json_encode($data));
                    break;

                default:
                    $this->bgLog('Unknown task type: ' . ($payload['type'] ?? 'null'), 'error');
            }

            $this->bgLog('Task completed successfully');
        } catch (\Throwable $e) {
            $this->bgLog('Task execution failed: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(), 'error');
        }

        return $this->response->setJSON(['status' => 'success']);
    }

    private function handleClosureTask(array $payload): void
    {
        $this->bgLog('=== STARTING CLOSURE TASK DEBUG ===');
        $this->bgLog('Full payload: ' . json_encode($payload));

        if (!isset($payload['closure'])) {
            $this->bgLog('ERROR: No closure data in payload');
            return;
        }

        $this->bgLog('Closure data length: ' . strlen($payload['closure']));

        try {
            // Deserialize the closure
            $this->bgLog('Step 1: Decoding base64...');
            $serialized = base64_decode($payload['closure']);
            $this->bgLog('Decoded length: ' . strlen($serialized));

            $this->bgLog('Step 2: Unserializing...');
            $serializableClosure = unserialize($serialized);
            $this->bgLog('Unserialized type: ' . gettype($serializableClosure));

            if (!$serializableClosure instanceof SerializableClosure) {
                $this->bgLog('ERROR: Invalid serializable closure - actual type: ' . get_class($serializableClosure));
                return;
            }

            $this->bgLog('Step 3: Getting closure...');
            $closure = $serializableClosure->getClosure();

            if (!$closure instanceof \Closure) {
                $this->bgLog('ERROR: Invalid closure after deserialization - type: ' . gettype($closure));
                return;
            }

            $this->bgLog('Step 4: Executing closure...');

            // Execute the closure
            $result = $closure();

            $this->bgLog('Step 5: Closure executed successfully');
            $this->bgLog('Closure result: ' . (is_null($result) ? 'null' : gettype($result)));
        } catch (\Throwable $e) {
            $this->bgLog('CLOSURE EXECUTION ERROR: ' . $e->getMessage());
            $this->bgLog('Error file: ' . $e->getFile() . ':' . $e->getLine());
            $this->bgLog('Stack trace: ' . $e->getTraceAsString());
            throw $e;
        }

        $this->bgLog('=== CLOSURE TASK DEBUG COMPLETE ===');
    }

    private function bgLog($message, $level = 'info')
    {
        $logFile = WRITEPATH . 'logs/background_' . date('Y-m-d') . '.log';

        // Ensure directory exists
        $logDir = dirname($logFile);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }

        $timestamp = date('Y-m-d H:i:s');
        $logEntry = "[{$timestamp}] [{$level}] {$message}\n";
        file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
    }
}
