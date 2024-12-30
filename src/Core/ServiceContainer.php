<?php

namespace Kasl\KaslFw\Core;

class ServiceContainer
{
    protected $services = [];

    public function set($name, callable $resolver)
    {
        $this->services[$name] = $resolver;
    }

    public function get($name)
    {
        if (!isset($this->services[$name])) {
            throw new \Exception("Service {$name} not defined.");
        }
        return $this->services[$name]();
    }
}
