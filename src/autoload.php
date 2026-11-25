<?php
declare(strict_types=1);

spl_autoload_register(function ($class) {
    $prefixes = [
        'App\\' => dirname(__DIR__) . '/app/',
        'Src\\' => dirname(__DIR__) . '/src/',
    ];

    foreach ($prefixes as $prefix => $baseDir) {
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            continue;
        }

        $relativeClass = substr($class, $len);
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});

require_once dirname(__DIR__) . '/lib/helpers.php';
