<?php

\Interaction\Http\Guard::control(function () {
    return true; // false - в случае если нет доступа к разделу
});