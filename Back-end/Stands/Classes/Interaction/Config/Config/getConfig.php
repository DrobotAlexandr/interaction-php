<?php

\Interaction\Stands\Stand::run('Classes/Interaction/Config/Config/getConfig', function () {

    return \Interaction\Config\Config::getConfig('database');

});