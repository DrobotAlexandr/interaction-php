<?php

namespace Interaction\Http;
class CORS
{
    public static function set(callable $callback): void
    {
        $headers = $callback();

        if ($headers) {
            foreach ($headers as $header) {
                header($header);
            }
        }
    }
}