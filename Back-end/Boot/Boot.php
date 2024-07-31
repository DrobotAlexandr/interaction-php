<?php

require __DIR__ . '/../Classes/Interaction/Boot/Loader.php';

# Classes
\Interaction\Boot\Loader::container(function () {
    Interaction\Boot\Loader::loadClasses();
});

# App
\Interaction\Boot\Loader::container(function () {
    Interaction\Boot\Loader::loadFunctions();
});