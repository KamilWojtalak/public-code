<?php

namespace App\Src;

class CustomFunctions
{
    /**
     * set HTTP response code and exit script with given message
     */
    public static function display_error($message = 'Something went wrong 😥', int $code = 404, array $headers = []): void
    {
        (isset($headers)) && static::set_allow_header($headers);

        http_response_code($code);
        echo json_encode([
            "errors" => $message
        ]);
        exit;
    }

    public static function output_json($data = 'No data 🤡'): void
    {
        http_response_code(201);
        echo json_encode([
            "data" => $data
        ]);
    }

    public static function set_allow_header()
    {
        if (isset($headers)) {
            $headers_str = implode(", ", $headers);
            header("Allow: $headers_str");
        }
    }

    public static function get_http_input()
    {
        $data = file_get_contents("php://input");
        return (array) json_decode($data, true);
    }
}
