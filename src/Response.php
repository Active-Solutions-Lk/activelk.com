<?php
declare(strict_types=1);

namespace Src;

class Response {
    private int $status = 200;
    private array $headers = [];
    private string $content = '';

    public function setStatus(int $code): self {
        $this->status = $code;
        return $this;
    }

    public function header(string $key, string $value): self {
        $this->headers[$key] = $value;
        return $this;
    }

    public function setContent(string $content): self {
        $this->content = $content;
        return $this;
    }

    public function json(array $data, int $status = 200): self {
        $this->status = $status;
        $this->headers['Content-Type'] = 'application/json; charset=utf-8';
        $this->content = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return $this;
    }

    public function view(string $tpl, array $data = [], int $status = 200): self {
        $this->status = $status;
        if (!isset($this->headers['Content-Type'])) {
            $this->headers['Content-Type'] = 'text/html; charset=utf-8';
        }

        $viewFile = dirname(__DIR__) . '/app/Views/' . ltrim($tpl, '/') . '.php';
        if (!file_exists($viewFile)) {
            $this->status = 500;
            $this->content = "<h1>View [{$tpl}] not found</h1>";
            return $this;
        }

        extract($data);
        ob_start();
        require $viewFile;
        $this->content = ob_get_clean();
        return $this;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function __toString(): string {
        return $this->content;
    }

    public function redirect(string $url, int $code = 302): self {
        $this->status = $code;
        $this->headers['Location'] = $url;
        return $this;
    }

    public function send(): void {
        http_response_code($this->status);
        foreach ($this->headers as $k => $v) {
            header("$k: $v");
        }
        echo $this->content;
    }
}
