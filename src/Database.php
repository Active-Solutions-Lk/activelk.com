<?php
declare(strict_types=1);

namespace Src;

class Database {
    private static ?\PDO $instance = null;

    public static function connect(): \PDO {
        if (self::$instance === null) {
            $cfg = config('database');
            $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s',
                $cfg['host'],
                $cfg['port'],
                $cfg['database'],
                $cfg['charset']
            );
            self::$instance = new \PDO($dsn, $cfg['username'], $cfg['password'], $cfg['options']);
        }
        return self::$instance;
    }
}
