<?php
declare(strict_types=1);

namespace Src;

class Request {
    private string $method;
    private string $path;
    private array $get;
    private array $post;
    private array $server;
    private ?array $json = null;

    public function __construct() {
        $this->method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $this->server = $_SERVER;
        $this->get    = $_GET;
        $this->post   = $_POST;
        
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        
        // Find base path from SCRIPT_NAME (e.g. /active4/public/index.php -> /active4)
        $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
        $baseDir = dirname($scriptName); // e.g. /active4/public
        
        // If baseDir ends with /public, strip /public to also handle the root rewrites
        $projectBase = preg_replace('#/public$#', '', $baseDir);

        if ($baseDir !== '/' && $baseDir !== '' && strpos($uri, $baseDir) === 0) {
            $uri = substr($uri, strlen($baseDir));
        } elseif ($projectBase !== '/' && $projectBase !== '' && strpos($uri, $projectBase) === 0) {
            $uri = substr($uri, strlen($projectBase));
        }

        $clean = trim($uri ?: '/', '/');
        $this->path = $clean === '' ? '/' : '/' . $clean;
    }

    public function method(): string {
        return $this->method;
    }

    public function path(): string {
        return $this->path;
    }

    public function get(string $key, $default = null) {
        return $this->get[$key] ?? $default;
    }

    public function post(string $key, $default = null) {
        return $this->post[$key] ?? $default;
    }

    public function json(): array {
        if ($this->json === null) {
            $raw = file_get_contents('php://input');
            $this->json = json_decode($raw, true) ?? [];
        }
        return $this->json;
    }

    public function all(): array {
        return array_merge($this->get, $this->post, $this->json());
    }
}
