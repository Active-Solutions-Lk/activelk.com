<?php
declare(strict_types=1);

namespace App\Controllers\Api;

use Src\Request;
use Src\Response;

class SolutionController {
    public function index(Request $req): Response {
        $cfg = config('content');
        return json([
            'status' => 'success',
            'data'   => $cfg['sections'] ?? []
        ]);
    }
}
