<?php

use Kasl\KaslFw\Http\AuthMiddleware;
use Kasl\KaslFw\Controllers\UserController;

// List all users
$router->register('GET', '/users', [UserController::class, 'index']);
$router->register('GET', '/users/{id}', [UserController::class, 'show']);
// $router->addMiddleware(new AuthMiddleware());
