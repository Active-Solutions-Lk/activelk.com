<?php
declare(strict_types=1);

namespace App\Models;

class BlogPost extends Model {
    protected static string $table = 'blog_posts';

    public static function getPublished(): array {
        try {
            $db = static::getDb();
            $stmt = $db->query("SELECT * FROM blog_posts WHERE is_active = 1 ORDER BY published_at DESC, id DESC");
            return $stmt->fetchAll();
        } catch (\Throwable $e) {
            return [];
        }
    }
}
