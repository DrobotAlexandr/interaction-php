<?php

function dd(): void
{
    echo "<pre style='background: #253139; color: #fff; font-size: 16px; cursor: default; padding: 16px; border-radius: 4px; width: fit-content; min-width: 700px;'>";

    $args = func_get_args();
    $numArgs = func_num_args();

    for ($i = 0; $i < $numArgs; $i++) {
        print_r($args[$i]);

        if (isset($args[$i + 1])) {
            echo '<br/>';
            echo '-------------------------------------------------------------------------------';
            echo '<br/>';
        }
    }

    echo "</pre>";
    exit();
}
