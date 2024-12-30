<?php

namespace Kasl\KaslFw\Core;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class Database
{
    public static function initialize()
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $config = require __DIR__ . '/../../config/database.php';

        $capsule = new Capsule;
        $capsule->addConnection($config);

        // Optional: Set up event dispatcher
        $capsule->setEventDispatcher(new Dispatcher(new Container));

        // Make Capsule globally available and boot Eloquent
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}
