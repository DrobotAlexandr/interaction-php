<?php

# Boot Loader
include_once 'Interaction/Boot/Boot.php';

# API container
Interaction\Boot\Loader::container(function () {
    Interaction\Http\Api::load('/');
});

# Front-container
Interaction\Boot\Loader::container(function () {
    App\Controllers\FrontController::index();
});
