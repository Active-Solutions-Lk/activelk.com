<?php
declare(strict_types=1);

namespace App\Actions;

use App\Models\Solution;
use App\Models\Project;

class GenerateSitemap {
    public function handle(): string {
        $baseUrl = rtrim((string) config('app.url', 'http://localhost'), '/');
        $urls = [
            '/',
            '/solutions',
            '/projects',
            '/contact',
        ];

        // Dynamic solutions
        $solutions = Solution::getActiveSolutions();
        foreach ($solutions as $s) {
            if (($s['id'] ?? '') !== 'intro') {
                $urls[] = '/solutions/' . $s['id'];
            }
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($baseUrl . $u, ENT_QUOTES, 'UTF-8') . "</loc>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "  </url>\n";
        }
        $xml .= '</urlset>';

        return $xml;
    }
}
