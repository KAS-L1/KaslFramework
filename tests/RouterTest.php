<?php

use PHPUnit\Framework\TestCase;
use Kasl\KaslFw\Core\Router;

class RouterTest extends TestCase
{
    public function testRouteRegistration()
    {
        $router = new Router();
        $router->register('GET', '/test', function () {
            return 'Hello, World!';
        });

        $this->assertEquals('Hello, World!', $router->dispatch('GET', '/test'));
    }

    public function testRouteNotFound()
    {
        $router = new Router();
        $this->assertEquals('404 Not Found', $router->dispatch('GET', '/unknown'));
    }
}
