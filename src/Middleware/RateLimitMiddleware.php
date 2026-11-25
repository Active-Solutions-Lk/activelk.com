<?php
declare(strict_types=1);

namespace Src\Middleware;

use Src\Request;
use Src\Response;

class RateLimitMiddleware {
    /**
     * Checks if a request exceeds rate limits.
     *
     * @param Request $req
     * @param int $maxAttempts Max allowable attempts
     * @param int $decaySeconds Window in seconds
     * @return bool True if permitted, false if rate limited
     */
    public function handle(Request $req, int $maxAttempts = 10, int $decaySeconds = 60): bool {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $key = 'rate_' . md5($ip . '_' . $req->path());
        
        $cacheDir = dirname(__DIR__, 2) . '/storage/cache';
        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir, 0755, true);
        }

        $file = $cacheDir . '/' . $key . '.json';
        $now = time();
        $record = ['attempts' => 0, 'expires_at' => $now + $decaySeconds];

        if (file_exists($file)) {
            $content = @file_get_contents($file);
            $parsed = json_decode((string)$content, true);
            if (is_array($parsed) && isset($parsed['expires_at']) && $parsed['expires_at'] > $now) {
                $record = $parsed;
            }
        }

        if ($record['attempts'] >= $maxAttempts) {
            return false;
        }

        $record['attempts']++;
        @file_put_contents($file, json_encode($record), LOCK_EX);
        return true;
    }
}
