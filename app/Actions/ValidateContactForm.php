<?php
declare(strict_types=1);

namespace App\Actions;

class ValidateContactForm {
    private array $errors = [];

    /**
     * Validates contact form submission data.
     *
     * @param array $data Input payload
     * @return array ['isValid' => bool, 'errors' => array, 'data' => array]
     */
    public function handle(array $data): array {
        $this->errors = [];
        $name    = trim((string)($data['name'] ?? ''));
        $email   = trim((string)($data['email'] ?? ''));
        $company = trim((string)($data['company'] ?? ''));
        $phone   = trim((string)($data['phone'] ?? ''));
        $interest = trim((string)($data['interest'] ?? 'general'));
        $message = trim((string)($data['message'] ?? ''));

        if ($name === '') {
            $this->errors['name'] = 'Your name is required.';
        } elseif (mb_strlen($name) < 2 || mb_strlen($name) > 120) {
            $this->errors['name'] = 'Name must be between 2 and 120 characters.';
        }

        if ($email === '') {
            $this->errors['email'] = 'Email address is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Please provide a valid email address.';
        }

        if ($phone !== '' && !preg_match('/^[0-9+\-\s()]{7,25}$/', $phone)) {
            $this->errors['phone'] = 'Please enter a valid contact phone number.';
        }

        if ($message !== '' && mb_strlen($message) > 5000) {
            $this->errors['message'] = 'Message cannot exceed 5000 characters.';
        }

        $validInterests = ['storage', 'switching', 'routing', 'software', 'general'];
        if (!in_array($interest, $validInterests, true)) {
            $interest = 'general';
        }

        return [
            'isValid' => empty($this->errors),
            'errors'  => $this->errors,
            'clean'   => [
                'name'     => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
                'email'    => strtolower($email),
                'company'  => htmlspecialchars($company, ENT_QUOTES, 'UTF-8'),
                'phone'    => $phone,
                'interest' => $interest,
                'message'  => htmlspecialchars($message, ENT_QUOTES, 'UTF-8'),
            ]
        ];
    }
}
