<?php

namespace Interaction\Config;

class Config
{
    public static function getConfig(string $configName, string $key = ''): array|string
    {
        $config = [];

        if (file_exists(__DIR__ . '/../../../app/config/' . $configName . '.php')) {
            $config = include __DIR__ . '/../../../app/config/' . $configName . '.php';
        }

        if ($key) {
            return $config[$key];
        }

        return $config;
    }
}