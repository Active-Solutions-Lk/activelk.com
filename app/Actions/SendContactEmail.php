<?php
declare(strict_types=1);

namespace App\Actions;

class SendContactEmail {
    public function handle(array $data): bool {
        // Log notification to storage/logs/leads.log
        $logDir = dirname(__DIR__, 2) . '/storage/logs';
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0755, true);
        }
        $logFile = $logDir . '/leads.log';
        $entry = sprintf(
            "[%s] New Lead: %s <%s> | Phone: %s | Reason: %s | Interest: %s | Message: %s\n",
            date('Y-m-d H:i:s'),
            $data['name'] ?? '',
            $data['email'] ?? '',
            $data['phone'] ?? '',
            $data['reason'] ?? '',
            $data['interest'] ?? '',
            str_replace(["\r", "\n"], ' ', $data['message'] ?? '')
        );
        @file_put_contents($logFile, $entry, FILE_APPEND);

        // Can integrate PHPMailer or mail() when SMTP credentials are provided in .env
        return true;
    }
}
