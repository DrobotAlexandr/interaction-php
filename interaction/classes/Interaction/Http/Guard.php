<?php

namespace Interaction\Http;

use Interaction\Http\Response;

class Guard
{
    public static function control(callable $callback): void
    {
        if (!$callback()) {

            $res = [
                'status' => 'error',
                'errorCode' => 'authorizationError',
                'errorMessage' => 'Ошибка авторизации!',
                'authLink' => '/login/',
            ];

            Response::json($res);
        }
    }
}