<?php
declare(strict_types=1);

return [
    'name'  => env('APP_NAME', 'Active Solutions'),
    'env'   => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url'   => rtrim((string) env('APP_URL', 'http://localhost'), '/'),
];
