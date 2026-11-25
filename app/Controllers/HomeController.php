<?php
declare(strict_types=1);

namespace App\Controllers;

use Src\Request;
use Src\Response;
use App\Models\Solution;
use App\Models\Setting;

class HomeController {
    public function index(Request $req): Response {
        $cfg = config('content');
        $sections = Solution::getActiveSolutions();

        return view('home/index', [
            'cfg'      => $cfg,
            'sections' => $sections ?: ($cfg['sections'] ?? []),
            'hero'     => $cfg['hero'] ?? [],
        ]);
    }
}
