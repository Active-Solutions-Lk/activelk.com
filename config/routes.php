<?php
declare(strict_types=1);

/**
 * Route definitions: [METHOD, PATTERN, CONTROLLER, ACTION, [MIDDLEWARES]]
 */
return [
    // Web Pages
    ['GET',  '/',                  'HomeController',       'index'],
    ['GET',  '/solutions',         'SolutionController',   'index'],
    ['GET',  '/solutions/{slug}',  'SolutionController',   'show'],
    ['GET',  '/projects',          'ProjectController',    'index'],
    ['GET',  '/projects/{slug}',   'ProjectController',    'show'],
    ['GET',  '/contact',           'ContactController',    'index'],
    ['POST', '/contact',           'ContactController',    'store'],
    ['GET',  '/reseller-register', 'ResellerController',   'index'],
    ['POST', '/reseller-register', 'ResellerController',   'store'],

    // API endpoints
    ['GET',  '/api/v1/health',     'Api\HealthController',    'ping'],
    ['GET',  '/api/v1/solutions',  'Api\SolutionController',  'index'],
    ['POST', '/api/v1/contact',    'Api\ContactController',   'store'],
];
