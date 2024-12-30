<?php

namespace Kasl\KaslFw\Resources;

class ApiResponse
{
    public static function success($data, $message = 'Success', $statusCode = 200)
    {
        http_response_code($statusCode);

        return json_encode([
            'status' => $statusCode,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public static function error($message, $statusCode = 400)
    {
        http_response_code($statusCode);

        return json_encode([
            'status' => $statusCode,
            'message' => $message,
            'data' => null,
        ]);
    }
}
