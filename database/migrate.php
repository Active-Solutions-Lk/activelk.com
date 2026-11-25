<?php
declare(strict_types=1);

/**
 * Database Migration & Seeding CLI Script
 * Run with: php database/migrate.php
 */

require_once dirname(__DIR__) . '/lib/helpers.php';

$host     = env('DB_HOST', '127.0.0.1');
$port     = (int) env('DB_PORT', 3306);
$database = env('DB_DATABASE', 'active_solutions');
$username = env('DB_USERNAME', 'root');
$password = env('DB_PASSWORD', '');

echo "==========================================\n";
echo " Active Solutions - Database Migration\n";
echo "==========================================\n\n";

try {
    echo "Connecting to MySQL server at {$host}:{$port}...\n";
    $dsn = sprintf('mysql:host=%s;port=%d;charset=utf8mb4', $host, $port);
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => true,
    ]);
    echo "[OK] Connected to MySQL successfully.\n\n";

    echo "Ensuring database `{$database}` exists...\n";
    $pdo->exec(sprintf(
        "CREATE DATABASE IF NOT EXISTS `%s` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;",
        $database
    ));
    $pdo->exec(sprintf("USE `%s`;", $database));
    echo "[OK] Database `{$database}` is ready.\n\n";

    $schemaFile = __DIR__ . '/schema.sql';
    if (file_exists($schemaFile)) {
        echo "Applying schema (tables) from database/schema.sql...\n";
        $schemaSql = file_get_contents($schemaFile);
        $pdo->exec($schemaSql);
        echo "[OK] Schema applied successfully.\n\n";
    } else {
        echo "[WARN] schema.sql not found at {$schemaFile}\n";
    }

    $seedFile = __DIR__ . '/seed.sql';
    if (file_exists($seedFile)) {
        echo "Seeding initial data from database/seed.sql...\n";
        $seedSql = file_get_contents($seedFile);
        $pdo->exec($seedSql);
        echo "[OK] Seed data inserted successfully.\n\n";
    } else {
        echo "[WARN] seed.sql not found at {$seedFile}\n";
    }

    // List created tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "Tables in `{$database}`:\n";
    foreach ($tables as $table) {
        $countStmt = $pdo->query("SELECT COUNT(*) FROM `{$table}`");
        $count = $countStmt->fetchColumn();
        echo "  - {$table} ({$count} records)\n";
    }

    echo "\n[SUCCESS] Migration and seeding completed successfully!\n";

} catch (PDOException $e) {
    echo "\n[ERROR] Database Error: " . $e->getMessage() . "\n\n";
    echo "Troubleshooting Tips:\n";
    echo "1. Make sure MySQL is running in XAMPP / MariaDB / Docker on port {$port}.\n";
    echo "2. Check DB credentials in .env (DB_HOST, DB_PORT, DB_USERNAME, DB_PASSWORD).\n";
    exit(1);
} catch (Throwable $e) {
    echo "\n[ERROR] " . $e->getMessage() . "\n";
    exit(1);
}
