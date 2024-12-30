<?php

use Kasl\KaslFw\Http\ExampleMiddleware;
use Kasl\KaslFw\Controllers\HomeController;

// Add a route
$router->register('GET', '/', [HomeController::class, 'index']);

// Add middleware
$router->addMiddleware(new ExampleMiddleware());
