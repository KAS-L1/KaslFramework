<?php

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Facade;

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Initialize Capsule (Database)
$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => $_ENV['DB_DRIVER'] ?? 'mysql',
    'host'      => $_ENV['DB_HOST'] ?? '127.0.0.1',
    'database'  => $_ENV['DB_DATABASE'] ?? '',
    'username'  => $_ENV['DB_USERNAME'] ?? '',
    'password'  => $_ENV['DB_PASSWORD'] ?? '',
    'charset'   => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
    'collation' => $_ENV['DB_COLLATION'] ?? 'utf8mb4_unicode_ci',
    'prefix'    => $_ENV['DB_PREFIX'] ?? '',
]);

// Set event dispatcher for Capsule
$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make Capsule globally available and boot Eloquent
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Create and bind the container for facades
$container = new Container();
Facade::setFacadeApplication($container);

// Register Capsule as 'db' in the container
$container->instance('db', $capsule);

// Bind 'db.schema' to the Schema Builder
$container->bind('db.schema', function ($container) use ($capsule) {
    return $capsule->getConnection()->getSchemaBuilder();
});

// Set up Schema Facade Alias
class_alias(Illuminate\Support\Facades\Schema::class, 'Schema');
