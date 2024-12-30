<?php

require __DIR__ . '/../vendor/autoload.php';

use Kasl\KaslFw\Core\Database;
use Kasl\KaslFw\Core\ServiceContainer;
use Kasl\KaslFw\Core\Router;

// Initialize Eloquent ORM
Database::initialize();

// Instantiate the service container
$container = new ServiceContainer();

// Register the router as a service
$container->set('router', function () {
    return new Router();
});

// Retrieve the router from the container
$router = $container->get('router');

// Load web and API routes
require __DIR__ . '/../routes/web.php';
require __DIR__ . '/../routes/api.php';

// Dispatch the current request
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
echo $router->dispatch($method, $uri);
