<?php

require __DIR__ . '/../vendor/autoload.php';

use Kasl\KaslFw\Core\Config;

// Test configuration retrieval
$appName = Config::get('app.name');
$appDebug = Config::get('app.debug');

// Output the values
echo "App Name: $appName\n";
echo "Debug Mode: " . ($appDebug ? 'ON' : 'OFF') . "\n";
