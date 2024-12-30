<?php

namespace Kasl\KaslFw\Http;

use Kasl\KaslFw\Core\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{
    public function handle($request, $next)
    {
        if (!isset($request->user)) {
            http_response_code(401);
            return "Unauthorized.";
        }

        return $next($request);
    }
}
