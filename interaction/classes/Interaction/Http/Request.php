<?php

namespace Interaction\Http;

class Request
{
    public static function getParam(string $key): string|array
    {

        if (isset($_POST[$key])) {
            if (is_array($_POST[$key])) {
                return $_POST[$key];
            } else {
                return htmlspecialchars($_POST[$key]);
            }
        }

        if (isset($_GET[$key])) {
            if (is_array($_GET[$key])) {
                return $_GET[$key];
            } else {
                return htmlspecialchars($_GET[$key]);
            }
        }

        $payLoad = (array)json_decode(file_get_contents('php://input'));

        if (isset($payLoad[$key])) {
            if (is_array($payLoad[$key])) {
                return $payLoad[$key];
            } else {
                return htmlspecialchars($payLoad[$key]);
            }
        }

        return '';

    }


}