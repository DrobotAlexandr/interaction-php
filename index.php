<?php

# Boot Loader
include_once 'interaction/boot/boot.php';

# API container
Interaction\Boot\Loader::container(function () {
    Interaction\Http\Api::load('/');
});

# Front-container
Interaction\Boot\Loader::container(function () {
    App\Controllers\FrontController::index();
});