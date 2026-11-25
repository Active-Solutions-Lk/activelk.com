<?php
declare(strict_types=1);

/**
 * Global helpers for Active Solutions application.
 */

if (!function_exists('env')) {
    function env(string $key, $default = null) {
        static $loaded = false;
        if (!$loaded) {
            $envFile = dirname(__DIR__) . '/.env';
            if (file_exists($envFile)) {
                $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line === '' || strpos($line, '#') === 0) continue;
                    if (strpos($line, '=') !== false) {
                        [$k, $v] = explode('=', $line, 2);
                        $k = trim($k);
                        $v = trim($v, " \t\n\r\0\x0B\"'");
                        if (!array_key_exists($k, $_ENV)) {
                            $_ENV[$k] = $v;
                            putenv("$k=$v");
                        }
                    }
                }
            }
            $loaded = true;
        }

        $val = $_ENV[$key] ?? getenv($key);
        if ($val === false || $val === null) return $default;
        
        switch (strtolower((string) $val)) {
            case 'true': return true;
            case 'false': return false;
            case 'null': return null;
            case 'empty': return '';
        }
        return $val;
    }
}

if (!function_exists('config')) {
    function config(string $key, $default = null) {
        static $configs = [];
        $parts = explode('.', $key);
        $file = array_shift($parts);

        if (!isset($configs[$file])) {
            $path = dirname(__DIR__) . "/config/{$file}.php";
            if (file_exists($path)) {
                $configs[$file] = require $path;
            } else {
                $configs[$file] = [];
            }
        }

        $current = $configs[$file];
        foreach ($parts as $p) {
            if (!is_array($current) || !array_key_exists($p, $current)) {
                return $default;
            }
            $current = $current[$p];
        }
        return $current;
    }
}

if (!function_exists('e')) {
    function e(?string $v): string {
        return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('url')) {
    function url(string $path = ''): string {
        $baseUrl = rtrim((string) config('app.url', ''), '/');
        
        // Auto-detect dynamic host and scheme if accessed via LAN IP / other device
        if (!empty($_SERVER['HTTP_HOST'])) {
            $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
            $parsed = parse_url($baseUrl);
            $basePath = isset($parsed['path']) ? rtrim($parsed['path'], '/') : '';
            $baseUrl = $scheme . $_SERVER['HTTP_HOST'] . $basePath;
        }

        $cleanPath = '/' . ltrim($path, '/');
        return $cleanPath === '/' ? $baseUrl : $baseUrl . $cleanPath;
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string {
        $clean = ltrim($path, '/');
        $full = dirname(__DIR__) . '/public/' . $clean;
        $ver = file_exists($full) ? filemtime($full) : 1;
        return url('/' . $clean) . '?v=' . $ver;
    }
}

if (!function_exists('view')) {
    function view(string $tpl, array $data = [], int $status = 200): Src\Response {
        $res = new Src\Response();
        return $res->view($tpl, $data, $status);
    }
}

if (!function_exists('json')) {
    function json(array $data, int $status = 200): Src\Response {
        $res = new Src\Response();
        return $res->json($data, $status);
    }
}

if (!function_exists('component')) {
    function component(string $name, array $data = []): void {
        extract($data);
        $file = dirname(__DIR__) . "/app/Views/components/{$name}.php";
        if (file_exists($file)) {
            require $file;
        } else {
            echo "<!-- Component [{$name}] not found -->";
        }
    }
}

if (!function_exists('icon')) {
    function icon(string $name): string {
        $icons = [
            'home'    => '<path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><path d="M9 22V12h6v10"/>',
            'chevron' => '<path d="m6 9 6 6 6-6"/>',
            'arrow'   => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
            'down'    => '<path d="M12 5v14"/><path d="m19 12-7 7-7-7"/>',
            'mail'    => '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
            'menu'    => '<path d="M4 6h16M4 12h16M4 18h16"/>',
            'shield'  => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/>',
            'headset' => '<path d="M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-5Zm0 0a9 9 0 1 1 18 0m0 0v5a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3Z"/><path d="M21 16v2a4 4 0 0 1-4 4h-5"/>',
            'bulb'    => '<path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"/><path d="M9 18h6"/><path d="M10 22h4"/>',
            'play'    => '<polygon points="7 4 20 12 7 20 7 4" fill="currentColor"/>',
            'sparkle' => '<path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/>'
        ];
        $path = $icons[$name] ?? '<circle cx="12" cy="12" r="10"/>';
        return '<svg class="ic" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $path . '</svg>';
    }
}
