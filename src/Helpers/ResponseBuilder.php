<?php

namespace App\Helpers;

class ResponseException extends \Exception {}

class ResponseBuilder
{
    public static function success($data = [], $message = ''): void
    {
        $response = json_encode(['success' => true, 'message' => $message, 'data' => $data]);
        if (getenv('APP_ENV') === 'testing') {
            throw new ResponseException($response);
        }
        echo $response;
        exit;
    }

    public static function error($message, $errors = []): void
    {
        $response = json_encode(['success' => false, 'errors' => $errors, 'message' => $message]);
        if (getenv('APP_ENV') === 'testing') {
            throw new ResponseException($response);
        }
        echo $response;
        exit;
    }
}
