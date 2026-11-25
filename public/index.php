<?php
declare(strict_types=1);

/**
 * Active Solutions Front Controller
 */

require_once dirname(__DIR__) . '/src/autoload.php';

$request = new Src\Request();
$routes  = require dirname(__DIR__) . '/config/routes.php';
$router  = new Src\Router($routes);

$response = $router->dispatch($request);
$response->send();
