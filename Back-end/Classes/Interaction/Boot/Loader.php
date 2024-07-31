<?php

namespace Interaction\Boot;

class Loader
{
    public static function loadClasses(): void
    {
        spl_autoload_register('Interaction\Boot\Loader::loadClasses__loadClasses');
        spl_autoload_register('Interaction\Boot\Loader::loadClasses__loadApp');
    }

    public static function loadClasses__loadClasses(string $className): void
    {
        $classPath = strtr(
            strtr(__DIR__ . '/' . $className . '.php', ['\\' => '/']), ['/Interaction/Boot/Interaction/' => '/Interaction/']
        );

        if (file_exists($classPath) and !class_exists($className)) {
            require $classPath;
        }
    }

    public static function loadClasses__loadApp(string $className): void
    {
        if (!str_contains('--' . $className, '--App\\') and !str_contains('--' . $className, '--\\App\\')) {
            return;
        }

        $classPath = __DIR__ . '/../../../App/' . strtr($className, ['\\' => '/', 'App\\' => '']) . '.php';

        if (file_exists($classPath) and !class_exists($className)) {
            require $classPath;
        }
    }

    public static function loadFunctions(): void
    {
        foreach (scandir(__DIR__ . '/../../../Functions') as $file) {
            if (str_contains($file, '.php')) {
                require __DIR__ . '/../../../Functions/' . $file;
            }
        }
    }

    public static function container(callable $container): void
    {
        $container();
    }

}