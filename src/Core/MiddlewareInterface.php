<?php

namespace Kasl\KaslFw\Core;

interface MiddlewareInterface
{
    public function handle($request, $next);
}
