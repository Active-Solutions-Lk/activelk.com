<?php
declare(strict_types=1);

namespace App\Controllers;

use Src\Request;
use Src\Response;
use App\Actions\ValidateContactForm;
use App\Actions\SaveContactLead;
use App\Actions\SendContactEmail;
use Src\Middleware\RateLimitMiddleware;

class ContactController {
    public function index(Request $req): Response {
        return view('contact/index');
    }

    public function store(Request $req): Response {
        // 1. Rate Limiting check (5 submissions per minute per IP)
        $limiter = new RateLimitMiddleware();
        if (!$limiter->handle($req, 5, 60)) {
            return json([
                'status'  => 'error',
                'message' => 'Too many requests. Please wait a moment before trying again.'
            ], 429);
        }

        // 2. Validate using Action
        $validator = new ValidateContactForm();
        $validation = $validator->handle($req->all());

        if (!$validation['isValid']) {
            return json([
                'status'  => 'error',
                'errors'  => $validation['errors'],
                'message' => 'Please correct the errors in the form.'
            ], 422);
        }

        $cleanData = $validation['clean'];

        try {
            // 3. Save Lead via Action
            (new SaveContactLead())->handle($cleanData);
            // 4. Send Email / Alert via Action
            (new SendContactEmail())->handle($cleanData);

            return json([
                'status'  => 'success',
                'message' => 'Thank you for reaching out! Our technology consultants will connect with you shortly.'
            ]);
        } catch (\Throwable $e) {
            // Fallback: log regardless
            (new SendContactEmail())->handle($cleanData);
            return json([
                'status'  => 'success',
                'message' => 'Thank you! Your message was received.'
            ]);
        }
    }
}
