<?php

namespace Kasl\KaslFw\Controllers;

class BaseController
{
    // Common properties or methods that all controllers might use
    protected function render($view, $data = [])
    {
        // Here you can integrate a template engine later
        extract($data);
        include sprintf(__DIR__ . "/../View/%s.php", $view);
    }
}
