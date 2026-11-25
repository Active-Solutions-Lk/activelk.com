<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use Src\Request;
use Src\Response;
use App\Actions\ValidateContactForm;
use App\Actions\SaveContactLead;
use App\Actions\SendContactEmail;
use Src\Middleware\RateLimitMiddleware;

class ContactController {
    public function store(Request $req): Response {
        $limiter = new RateLimitMiddleware();
        if (!$limiter->handle($req, 10, 60)) {
            return json([
                'status'  => 'error',
                'message' => 'Rate limit exceeded. Try again in 60 seconds.'
            ], 429);
        }

        $validator = new ValidateContactForm();
        $validation = $validator->handle($req->json());

        if (!$validation['isValid']) {
            return json([
                'status'  => 'error',
                'errors'  => $validation['errors'],
                'message' => 'Validation failed.'
            ], 422);
        }

        $cleanData = $validation['clean'];

        try {
            (new SaveContactLead())->handle($cleanData);
        } catch (\Throwable $e) {
            // Log fallback
        }

        (new SendContactEmail())->handle($cleanData);

        return json([
            'status'  => 'success',
            'message' => 'Contact lead registered successfully.'
        ]);
    }
}
