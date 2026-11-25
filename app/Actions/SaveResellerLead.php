<?php
declare(strict_types=1);

namespace App\Actions;

use App\Models\ResellerLead;

class SaveResellerLead {
    public function handle(array $data, ?string $ip = null): int {
        return ResellerLead::create([
            'company_name'  => trim((string)($data['company_name'] ?? '')),
            'contact_name'  => trim((string)($data['contact_name'] ?? '')),
            'email'         => trim((string)($data['email'] ?? '')),
            'phone'         => trim((string)($data['phone'] ?? '')),
            'website'       => trim((string)($data['website'] ?? '')),
            'message'       => trim((string)($data['message'] ?? '')),
            'ip_address'    => $ip ?? ($_SERVER['REMOTE_ADDR'] ?? null),
        ]);
    }

    public function logFallback(array $data): void {
        $logDir = dirname(__DIR__, 2) . '/storage/logs';
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0755, true);
        }
        $logFile = $logDir . '/resellers.log';
        $entry = sprintf(
            "[%s] Reseller Application: %s (%s) <%s> | Phone: %s | Type: %s | Web: %s | Message: %s\n",
            date('Y-m-d H:i:s'),
            $data['company_name'] ?? '',
            $data['contact_name'] ?? '',
            $data['email'] ?? '',
            $data['phone'] ?? '',
            $data['website'] ?? '',
            str_replace(["\r", "\n"], ' ', $data['message'] ?? '')
        );
        @file_put_contents($logFile, $entry, FILE_APPEND);
    }
}
