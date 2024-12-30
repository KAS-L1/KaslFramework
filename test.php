<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config/bootstrap.php';

use Kasl\KaslFw\Models\User;

try {
    $user = User::factory()->make();
    print_r($user->toArray());
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
