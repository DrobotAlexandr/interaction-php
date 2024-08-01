<?php

namespace Interaction\Stands;

class Stand
{
    public static function run(string $name, callable $callback): void
    {
        if ($GLOBALS['STAND_NAME'] == $name) {
            echo PHP_EOL;
            print_r($callback());
            echo '--------------------------------------------> ' . $name;
            echo PHP_EOL;
            exit();
        }
    }
}