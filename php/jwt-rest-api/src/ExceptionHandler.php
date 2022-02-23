<?php

namespace App\Src;

use ErrorException;

class ExceptionHandler
{
    static function handle_error(
        int $errno,
        string $errstr,
        string $errfile,
        int $errline
    ) {
        /** Set HTTP response code */
        http_response_code(500);
        /** Log errors in JSON */
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }
    static function handle_exception(\Throwable $ex)
    {
        /** Set HTTP response code */
        http_response_code(500);
        /** Log errors in JSON */
        echo json_encode([
            "message" => $ex->getMessage(),
            "code" => $ex->getCode(),
            "file" => $ex->getFile(),
            "line" => $ex->getLine()
        ]);
    }
}
