<?php

namespace Kasl\KaslFw\Resources;

class UserResource
{
    public static function toArray($user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at->toDateTimeString(),
        ];
    }
}
