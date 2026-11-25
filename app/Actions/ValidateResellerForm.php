<?php
declare(strict_types=1);

namespace App\Actions;

class ValidateResellerForm {
    private array $errors = [];

    /**
     * Validates reseller registration form submission data.
     *
     * @param array $data Input payload
     * @return array{isValid: bool, errors: array, clean: array}
     */
    public function handle(array $data): array {
        $this->errors  = [];
        $companyName   = trim((string)($data['company_name'] ?? ''));
        $contactName   = trim((string)($data['contact_name'] ?? ''));
        $email         = trim((string)($data['email'] ?? ''));
        $phone         = trim((string)($data['phone'] ?? ''));
        $website       = trim((string)($data['website'] ?? ''));
        $message       = trim((string)($data['message'] ?? ''));

        if ($companyName === '') {
            $this->errors['company_name'] = 'Company name is required.';
        } elseif (mb_strlen($companyName) < 2 || mb_strlen($companyName) > 150) {
            $this->errors['company_name'] = 'Company name must be between 2 and 150 characters.';
        }

        if ($contactName === '') {
            $this->errors['contact_name'] = 'Contact person name is required.';
        } elseif (mb_strlen($contactName) < 2 || mb_strlen($contactName) > 120) {
            $this->errors['contact_name'] = 'Contact name must be between 2 and 120 characters.';
        }

        if ($email === '') {
            $this->errors['email'] = 'Work email address is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Please provide a valid email address.';
        }

        if ($phone === '') {
            $this->errors['phone'] = 'Phone number is required.';
        } elseif (!preg_match('/^[0-9+\-\s()]{7,25}$/', $phone)) {
            $this->errors['phone'] = 'Please enter a valid contact phone number.';
        }

        if ($website !== '' && !filter_var($website, FILTER_VALIDATE_URL)) {
            $this->errors['website'] = 'Please enter a valid website URL (including https://).';
        }

        if ($message !== '' && mb_strlen($message) > 3000) {
            $this->errors['message'] = 'Message cannot exceed 3000 characters.';
        }

        return [
            'isValid' => empty($this->errors),
            'errors'  => $this->errors,
            'clean'   => [
                'company_name'  => htmlspecialchars($companyName, ENT_QUOTES, 'UTF-8'),
                'contact_name'  => htmlspecialchars($contactName, ENT_QUOTES, 'UTF-8'),
                'email'         => strtolower($email),
                'phone'         => $phone,
                'website'       => htmlspecialchars($website, ENT_QUOTES, 'UTF-8'),
                'message'       => htmlspecialchars($message, ENT_QUOTES, 'UTF-8'),
            ],
        ];
    }
}
