<?php

namespace Kasl\KaslFw\Http;

use Kasl\KaslFw\Core\MiddlewareInterface; // Correct path to the MiddlewareInterface

class ExampleMiddleware implements MiddlewareInterface
{
    public function handle($request, $next)
    {
        // Example middleware logic
        if (true) { // Replace 'true' with your actual condition
            // Perform some logic here, such as authentication or logging
        }

        return $next($request); // Continue to the next middleware or final action
    }
}
