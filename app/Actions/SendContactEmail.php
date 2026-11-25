<?php
declare(strict_types=1);

namespace App\Actions;

class SendContactEmail {
    public function handle(array $data): bool {
        // Log notification to storage/logs/leads.log
        $logFile = dirname(__DIR__, 2) . '/storage/logs/leads.log';
        $entry = sprintf(
            "[%s] New Lead: %s <%s> | Interest: %s | Message: %s\n",
            date('Y-m-d H:i:s'),
            $data['name'] ?? '',
            $data['email'] ?? '',
            $data['interest'] ?? '',
            str_replace(["\r", "\n"], ' ', $data['message'] ?? '')
        );
        @file_put_contents($logFile, $entry, FILE_APPEND);

        // Can integrate PHPMailer or mail() when SMTP credentials are provided in .env
        return true;
    }
}
