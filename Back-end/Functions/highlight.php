<?php

function highlight(array $data): void
{
    if (isset($_SERVER['REQUEST_URI'])) {
        return;
    }

    echo PHP_EOL;
    echo 'highlight: ';
    print_r($data);
    echo PHP_EOL;
}
