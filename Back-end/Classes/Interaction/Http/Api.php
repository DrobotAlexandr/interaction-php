<?php

namespace Interaction\Http;

class Api
{

    public static function load(string $basePath): void
    {
        if (!isset($_SERVER['REQUEST_URI'])) {
            return;
        }

        if (!str_contains($_SERVER['REQUEST_URI'], '/api/')) {
            return;
        }

        if ($methodPath = self::getEndPointFilePath($basePath)) {
            self::includeCORS($methodPath);
            self::includeGuard($methodPath);

            require_once $methodPath;

        } else {

            Response::json(['status' => 'error', 'errorCode' => 'MethodNotExists']);

        }

    }

    private static function getEndPointFilePath(string $basePath): string
    {
        if (!isset($_SERVER['REQUEST_URI'])) {
            return '';
        }

        $methodPath = strtr(__DIR__ . '/../../../App/' . explode('?', $_SERVER['REQUEST_URI'])[0], ['//' => '/']);

        $methodPath = strtr($methodPath, ['/App' . $basePath . 'api/' => '/App/api/']) . '.php';
        $methodPath = strtr($methodPath, ['/App/api/' => '/App/Api/', '/.php' => '.php']);

        if (file_exists($methodPath)) {
            return $methodPath;
        } else {
            return '';
        }
    }

    public static function runMethod($callback): void
    {
        try {
            Response::json(
                $callback()
            );
        } catch (\Throwable $e) {
            Response::json(
                Response::error(
                    $e->getMessage(),
                    $e->getCode()
                )
            );
        }
    }

    private static function includeCORS(string $endpointPath): void
    {
        $directory = '';

        foreach (explode('/', $endpointPath) as $dir) {
            $directory .= $dir . '/';

            if (file_exists($directory . '/_cors.php')) {
                include_once $directory . '/_cors.php';
            }
        }
    }

    private static function includeGuard(string $endpointPath): void
    {
        $directory = '';

        foreach (explode('/', $endpointPath) as $dir) {
            $directory .= $dir . '/';

            if (file_exists($directory . '/_guard.php')) {
                include_once $directory . '/_guard.php';
            }
        }
    }

}