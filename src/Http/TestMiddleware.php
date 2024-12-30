<?php

namespace Kasl\KaslFw\Middleware;

class TestMiddleware
{
    public function handle($request, $next)
    {
        // Middleware logic here
        return $next($request);
    }
}
