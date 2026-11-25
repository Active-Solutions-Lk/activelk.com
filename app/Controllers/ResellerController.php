<?php
declare(strict_types=1);

namespace App\Controllers;

use Src\Request;
use Src\Response;
use App\Actions\ValidateResellerForm;
use App\Actions\SaveResellerLead;
use Src\Middleware\RateLimitMiddleware;

class ResellerController {
    public function index(Request $req): Response {
        return view('reseller/index');
    }

    public function store(Request $req): Response {
        // 1. Rate Limiting check (5 submissions per minute per IP)
        $limiter = new RateLimitMiddleware();
        if (!$limiter->handle($req, 5, 60)) {
            return json([
                'status'  => 'error',
                'message' => 'Too many requests. Please wait a moment before trying again.',
            ], 429);
        }

        // 2. Validate using Action
        $validator  = new ValidateResellerForm();
        $validation = $validator->handle($req->all());

        if (!$validation['isValid']) {
            return json([
                'status'  => 'error',
                'errors'  => $validation['errors'],
                'message' => 'Please correct the errors in the form.',
            ], 422);
        }

        $cleanData = $validation['clean'];
        $saver     = new SaveResellerLead();

        try {
            $saver->handle($cleanData);
            $saver->logFallback($cleanData);

            return json([
                'status'  => 'success',
                'message' => 'Thank you for applying! Our partner onboarding team will review your application and contact you shortly.',
            ]);
        } catch (\Throwable $e) {
            // Fallback: log to file even if DB table is not migrated yet
            $saver->logFallback($cleanData);

            return json([
                'status'  => 'success',
                'message' => 'Thank you! Your reseller registration request was received.',
            ]);
        }
    }
}
