<?php

namespace App\Services\Users;

class UserService
{
    public static function getUser(int $id): array
    {
        return [
            'id' => $id
        ];
    }
}