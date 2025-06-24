<?php
// app/Libraries/TrulyAsyncBackground.php
namespace App\Libraries;

use Laravel\SerializableClosure\SerializableClosure;

class TrulyAsyncBackground
{
    private string $workerUrl;

    public function __construct()
    {
        $this->workerUrl = base_url('bg_worker.php');
    }

    public function queue(\Closure $task): void
    {
        $payload = $this->serializeClosure($task);
        $this->fireAndForget($payload);
    }

    private function serializeClosure(\Closure $closure): string
    {
        $serialized = serialize(new SerializableClosure($closure));
        return json_encode([
            'type' => 'closure',
            'closure' => base64_encode($serialized),
        ]);
    }

    private function fireAndForget(string $payload): void
    {
        if (function_exists('curl_init')) {
            $this->curlFireAndForget($payload);
        } else {
            $this->streamFireAndForget($payload);
        }
    }

    private function curlFireAndForget(string $payload): void
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $this->workerUrl,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query(['payload' => $payload]),
            CURLOPT_RETURNTRANSFER => false,
            CURLOPT_TIMEOUT => 1, // Very short timeout
            CURLOPT_CONNECTTIMEOUT => 1,
            CURLOPT_NOSIGNAL => 1,
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_FORBID_REUSE => true,
        ]);

        // Execute without waiting for full response
        curl_exec($ch);
        curl_close($ch);

        $this->logExecution('cURL fire-and-forget executed');
    }

    private function streamFireAndForget(string $payload): void
    {
        $postData = http_build_query(['payload' => $payload]);

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-type: application/x-www-form-urlencoded\r\n" .
                    "Connection: Close\r\n",
                'content' => $postData,
                'timeout' => 0.1, // Very short timeout
                'ignore_errors' => true,
            ]
        ]);

        // Fire and forget with minimal timeout
        @file_get_contents($this->workerUrl, false, $context);

        $this->logExecution('Stream fire-and-forget executed');
    }

    private function logExecution(string $message): void
    {
        $logFile = WRITEPATH . 'logs/async_execution_' . date('Y-m-d') . '.log';
        $timestamp = date('Y-m-d H:i:s');
        file_put_contents($logFile, "[{$timestamp}] {$message}\n", FILE_APPEND | LOCK_EX);
    }
}
