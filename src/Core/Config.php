<?php

namespace Kasl\KaslFw\Core;

class Config
{
    public static function get($key)
    {
        $parts = explode('.', $key);
        $file = __DIR__ . '/../../config/' . $parts[0] . '.php';

        if (!file_exists($file)) {
            throw new \Exception("Configuration file {$parts[0]} not found.");
        }

        $config = require $file;

        return $parts[1] ?? null ? ($config[$parts[1]] ?? null) : $config;
    }
}
