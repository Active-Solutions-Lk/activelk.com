<?php
declare(strict_types=1);

namespace App\Models;

class Setting extends Model {
    protected static string $table = 'site_settings';

    public static function get(string $key, $default = null) {
        try {
            $db = static::getDb();
            $stmt = $db->prepare("SELECT `value` FROM site_settings WHERE `key` = :k LIMIT 1");
            $stmt->execute(['k' => $key]);
            $res = $stmt->fetchColumn();
            return ($res !== false) ? $res : $default;
        } catch (\Throwable $e) {
            return $default;
        }
    }

    public static function set(string $key, string $value): void {
        $db = static::getDb();
        $stmt = $db->prepare("INSERT INTO site_settings (`key`, `value`) VALUES (:k, :v) ON DUPLICATE KEY UPDATE `value` = :v2");
        $stmt->execute(['k' => $key, 'v' => $value, 'v2' => $value]);
    }
}
