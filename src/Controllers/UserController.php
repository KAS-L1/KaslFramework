<?php

namespace Kasl\KaslFw\Controllers;

use Kasl\KaslFw\Models\User;
use Kasl\KaslFw\Resources\UserResource;
use Illuminate\Support\Facades\Validator;

class UserController
{
    public function index($request)
    {
        return "Showing all users.";
    }

    public function show($request)
    {
        $id = $request->params[0] ?? null;
        return "Showing user with ID: {$id}";
    }
}
