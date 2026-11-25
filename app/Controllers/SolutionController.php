<?php
declare(strict_types=1);

namespace App\Controllers;

use Src\Request;
use Src\Response;
use App\Models\Solution;

class SolutionController {
    public function index(Request $req): Response {
        $solutions = Solution::getActiveSolutions();
        return view('solutions/index', [
            'solutions' => $solutions
        ]);
    }

    public function show(Request $req, array $params): Response {
        $slug = $params['slug'] ?? '';
        $solutions = Solution::getActiveSolutions();
        $solution = null;

        foreach ($solutions as $s) {
            if ($s['id'] === $slug || ($s['slug'] ?? '') === $slug) {
                $solution = $s;
                break;
            }
        }

        if (!$solution) {
            return view('errors/404', [], 404);
        }

        return view('solutions/show', [
            'solution' => $solution
        ]);
    }
}
