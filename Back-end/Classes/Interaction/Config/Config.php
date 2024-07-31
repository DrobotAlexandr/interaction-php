<?php

namespace Interaction\Config;

class Config
{
    public static function getConfig(string $configName, string $key = ''): array|string
    {
        $config = [];

        if (file_exists(__DIR__ . '/../../../App/Config/' . $configName . '.php')) {
            $config = include __DIR__ . '/../../../App/Config/' . $configName . '.php';
        }

        if ($key) {
            return $config[$key];
        }

        return $config;
    }
}