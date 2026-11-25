<?php
declare(strict_types=1);

namespace App\Models;

use Src\Database;
use PDO;

abstract class Model {
    protected static string $table = '';

    public static function getDb(): PDO {
        return Database::connect();
    }

    public static function all(string $orderBy = 'id ASC'): array {
        $db = static::getDb();
        $table = static::$table;
        $stmt = $db->query("SELECT * FROM `{$table}` ORDER BY {$orderBy}");
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array {
        $db = static::getDb();
        $table = static::$table;
        $stmt = $db->prepare("SELECT * FROM `{$table}` WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

    public static function findBySlug(string $slug): ?array {
        $db = static::getDb();
        $table = static::$table;
        $stmt = $db->prepare("SELECT * FROM `{$table}` WHERE slug = :slug LIMIT 1");
        $stmt->execute(['slug' => $slug]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

    public static function create(array $data): int {
        $db = static::getDb();
        $table = static::$table;
        
        $fields = array_keys($data);
        $columns = implode(', ', array_map(fn($f) => "`$f`", $fields));
        $placeholders = implode(', ', array_map(fn($f) => ":$f", $fields));
        
        $sql = "INSERT INTO `{$table}` ({$columns}) VALUES ({$placeholders})";
        $stmt = $db->prepare($sql);
        $stmt->execute($data);
        return (int) $db->lastInsertId();
    }
}
