<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use Src\Request;
use Src\Response;

class HealthController {
    public function ping(Request $req): Response {
        return json([
            'status'    => 'ok',
            'timestamp' => date('c'),
            'app'       => config('app.name'),
        ]);
    }
}
