<?php

namespace Kasl\KaslFw\Controllers;

use Kasl\KaslFw\Core\Template;

class HomeController
{
    public function index()
    {
        $template = new Template();
        return $template->render('home', ['title' => 'Welcome to KaslFW']);
    }
}
