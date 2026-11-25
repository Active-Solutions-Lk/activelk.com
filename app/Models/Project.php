<?php
declare(strict_types=1);

namespace App\Models;

class Project extends Model {
    protected static string $table = 'projects';

    public static function getFeatured(): array {
        try {
            $db = static::getDb();
            $stmt = $db->query("SELECT * FROM projects WHERE is_active = 1 ORDER BY is_featured DESC, id DESC");
            $rows = $stmt->fetchAll();
            return array_map(function ($row) {
                if (isset($row['tags']) && is_string($row['tags'])) {
                    $row['tags'] = json_decode($row['tags'], true);
                }
                return $row;
            }, $rows);
        } catch (\Throwable $e) {
            return [
                [
                    'slug' => 'bank-datacenter-storage',
                    'title' => 'High-Availability Synology NAS for Commercial Bank',
                    'client' => 'National Commercial Bank',
                    'industry' => 'Finance',
                    'summary' => 'Multi-petabyte redundant backup and enterprise disaster recovery cluster implementation.'
                ],
                [
                    'slug' => 'university-campus-switching',
                    'title' => 'Campus-Wide 10G BDCOM Switching Infrastructure',
                    'client' => 'Metropolitan University',
                    'industry' => 'Education',
                    'summary' => 'High density core-distribution-access network connecting 15 faculties and research labs.'
                ]
            ];
        }
    }
}
