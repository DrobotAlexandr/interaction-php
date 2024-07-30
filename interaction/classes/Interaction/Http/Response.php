<?php

namespace Interaction\Http;

class Response
{
    public static function json(array $data): void
    {
        if (!isset($data['status'])) {
            $data['status'] = 'ok';
        }

        $data['version'] = self::json__getVersion($data);

        header('Content-type: application/json;');
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        print $json;
        exit();
    }

    private static function json__getVersion(array $data): string
    {
        if (!$data) {
            $data = '';
        }

        $version = md5(serialize($data));

        return md5(
            count($data) . $version
        );

    }

    public static function error(string $error = 'Error', string $errorCode = ''): array
    {
        return [
            'status' => 'error',
            'errorCode' => $errorCode,
            'errorMessage' => $error
        ];
    }


}