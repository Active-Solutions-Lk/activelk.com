<?php
declare(strict_types=1);

namespace App\Models;

class Solution extends Model {
    protected static string $table = 'solutions';

    public static function getActiveSolutions(): array {
        try {
            $db = static::getDb();
            $stmt = $db->query("SELECT * FROM solutions WHERE is_active = 1 ORDER BY sort_order ASC");
            $rows = $stmt->fetchAll();
            
            // Format JSON fields
            return array_map(function ($row) {
                if (isset($row['video_t']) && is_string($row['video_t'])) {
                    $row['t'] = json_decode($row['video_t'], true);
                }
                if (isset($row['scroll_vh']) && is_string($row['scroll_vh'])) {
                    $row['vh'] = json_decode($row['scroll_vh'], true);
                }
                $row['objX'] = $row['obj_x'] ?? 50;
                $row['cta'] = [$row['cta_label'] ?? 'Learn More', $row['cta_href'] ?? '#contact'];
                $row['id'] = $row['slug'];
                $row['label'] = $row['label'] ?? $row['badge'] ?? $row['title'] ?? ('Section ' . ($row['sort_order'] ?? 0));
                return $row;
            }, $rows);
        } catch (\Throwable $e) {
            // Fallback to content config if DB is not yet migrated/connected
            $cfg = config('content');
            return $cfg['sections'] ?? [];
        }
    }
}
