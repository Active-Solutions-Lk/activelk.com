<?php
declare(strict_types=1);

namespace App\Actions;

use App\Models\ContactLead;

class SaveContactLead {
    public function handle(array $data, ?string $ip = null): int {
        return ContactLead::create([
            'name'        => trim((string)($data['name'] ?? '')),
            'email'       => trim((string)($data['email'] ?? '')),
            'company'     => trim((string)($data['company'] ?? '')),
            'phone'       => trim((string)($data['phone'] ?? '')),
            'interest'    => trim((string)($data['interest'] ?? 'general')),
            'message'     => trim((string)($data['message'] ?? '')),
            'source_page' => trim((string)($data['source_page'] ?? '')),
            'ip_address'  => $ip ?? ($_SERVER['REMOTE_ADDR'] ?? null),
        ]);
    }
}
