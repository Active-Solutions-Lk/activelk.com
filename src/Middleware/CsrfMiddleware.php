<?php
declare(strict_types=1);

namespace Src\Middleware;

use Src\Request;

class CsrfMiddleware {
    public static function generateToken(): string {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            @session_start();
        }
        if (empty($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf_token'];
    }

    public static function validate(Request $req): bool {
        if ($req->method() === 'GET' || $req->method() === 'HEAD' || $req->method() === 'OPTIONS') {
            return true;
        }

        if (session_status() !== PHP_SESSION_ACTIVE) {
            @session_start();
        }

        $sessionToken = $_SESSION['_csrf_token'] ?? '';
        if ($sessionToken === '') {
            return false;
        }

        $data = $req->all();
        $token = $data['_csrf_token'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');

        return hash_equals($sessionToken, (string)$token);
    }
}
