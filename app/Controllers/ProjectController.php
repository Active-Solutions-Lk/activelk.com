<?php
declare(strict_types=1);

namespace App\Controllers;

use Src\Request;
use Src\Response;
use App\Models\Project;

class ProjectController {
    public function index(Request $req): Response {
        $projects = Project::getFeatured();
        return view('projects/index', [
            'projects' => $projects
        ]);
    }

    public function show(Request $req, array $params): Response {
        $slug = $params['slug'] ?? '';
        $project = Project::findBySlug($slug);
        return view('projects/show', ['slug' => $slug, 'project' => $project]);
    }
}
