<?php

\Interaction\Http\Api::runMethod(function () {

    return \App\Services\Users\UserService::getUser(
        \Interaction\Http\Request::getParam('id')
    );

});